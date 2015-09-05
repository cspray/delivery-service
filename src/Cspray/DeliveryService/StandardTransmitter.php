<?php

declare(strict_types = 1);

/**
 * @license See LICENSE file in project root
 */

namespace Cspray\DeliveryService;

class StandardTransmitter implements Transmitter {

    private $promisorFactory;
    private $queue;

    public function __construct(ReceiptPromisorFactory $promisorFactory, MessageQueue $queue = null) {
        $this->promisorFactory = $promisorFactory;
        $this->queue = $queue ?? new InMemoryMessageQueue();
    }

    public function send(Message $message) : Receipt {
        $promisor = $this->promisorFactory->create();
        $msgReceiptPromisor = $this->getMessageReceiptPromisor($message, $promisor);
        $this->queue->enqueue($msgReceiptPromisor);
        return $promisor->getReceipt();
    }

    public function getMessageQueue() : MessageQueue {
        return $this->queue;
    }

    private function getMessageReceiptPromisor(Message $message, ReceiptPromisor $receiptPromisor) : MessageReceiptPromisor {
        return new class($message, $receiptPromisor) implements MessageReceiptPromisor {

            private $message;
            private $receiptPromisor;

            public function __construct($message, $receiptPromisor) {
                $this->message = $message;
                $this->receiptPromisor = $receiptPromisor;
            }

            public function getMessage() : Message {
                return $this->message;
            }

            public function getReceiptPromisor() : ReceiptPromisor {
                return $this->receiptPromisor;
            }

        };
    }

}