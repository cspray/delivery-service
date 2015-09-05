# DeliveryService

A library to allow transmitting and receiving messages within an asynchronous event loop. 
Includes a receipt that all listeners for a given messgae have read it.

This library primarily holds the interfaces designed to provide the discussed functionality 
and generic implementations that are not dependent on any particular event reactor. For 
functional implementations of these interfaces please check out:

- [`cspray/amp-delivery-service`](https://github.com/cspray/amp-delivery-service)

**This library requires PHP7! Because of this it will not be production ready until PHP7 is.**

## Overview

Here we talk about the interfaces that provide the messaging abstraction layer we place on 
top of your favorite reactor. It is assumed from this point forward that you have a high-level 
understanding of event loops, promises, and promisors. 
 
### `Message`

Represents a type and a set of data that can be transmitted and received. In other words, a message. 
The payload of the message can be whatever is appropriate for your domain.
 
```
<?php

namespace Cspray\DeliveryService;

interface Message {
    
    public function getType() : string;
    
    public function getPayload();
    
}
```

### `Receipt`

Every time you send a message you get a Receipt. This is a promise that will invoke any callbacks 
when the Message has been received by *everybody* that's supposed to receive it. The callback will 
be invoked regardless of whether listeners threw an exception; check out the DeliveryResults interface 
for more information.

```
<?php

namespace Cspray\DeliveryService;

interface Receipt {

    /**
     * The $callback should match the below signature:
     *
     * function(DeliveryResults $results, Message $message) {
     *
     * }
     */
    public function delivered(callable $callback);
    
}
```

### `DeliveryResults`

Represents the results of a Message having been delivered to all of its recipients. 
An implementation of this interface gets passed to all callbacks attached to a 
Receipt.

```
<?php

namespace Cspray\DeliveryService;

interface DeliveryResults {

    public function getNumberListeners() : int;
    
    public function getSuccessfulResults() : array;
    
    public function getFailureResults() : array;

    // The arrays returned from both successful and failed should match the following format
    // [$listenerId => $listenerReturnOrThrownException]

}}
```

### `Receiver`

Your code needs some way to receive messages; you accomplish this by adding a listener 
for a specific type of Message to a Receiver.

```
<?php

namespace Cspray\DeliveryService;

interface Receiver {
    
    // The string returned should be a unique identifier for the specific type and callable passed
    public function listen(string $messageType, callable $callback) : string;
    
    public function removeListener(string $listenerId);
    
    public function getListenersForType(string $messageType);
    
}
```

### `Transmitter`

If you expect to receive a message you need to send one first! The Transmitter interface is designed 
to do exactly that. Specifically we expect implementations to add Messages to a MessageQueue implementation, 
we'll get to that one below.

```
<?php

namespace Cspray\DeliveryService;

interface Transmitter {

    public function send(Message $message) : Receipt;
    
    public function getMessageQueue() : MesageQueue;

}
```

### `MessageQueue`

A first-in, first-out queue that holds Messages that are awaiting delivery. When a message is delivered it is 
removed from the queue.

```
<?php

namespace Cspray\DeliveryService;

interface MessageQueue {

    public function enqueue(MessageReceiptPromisor $messageReceiptPromisor);
    
    public function dequeue() : MessageReceiptPromisor;
    
    public function isEmpty() : bool;
    
    public function hasMessages() : bool;

}
```

### `Mediator`

Finally the interface that brings everything together. It coordinates with the event reactor of your 
choice, as well as a transmitter and receiver to actually dispatch thes Messages.

```
<?php

namespace Cspray\DeliveryService;

interface Mediator {

    public function startSendingMessages();
    
    public function stopSendingMessages();

}
```

For more information check out the implementation libraries that are listed above.