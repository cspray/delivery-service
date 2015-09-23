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

    public function send(string $messageType, array $payload = []) : Receipt {
        $promisor = $this->promisorFactory->create();
        $msgReceiptPromisor = $this->getMessageReceiptPromisor($messageType, $payload, $promisor);
        $this->queue->enqueue($msgReceiptPromisor);
        return $promisor->getReceipt();
    }

    public function getMessageQueue() : MessageQueue {
        return $this->queue;
    }

    private function getMessageReceiptPromisor(string $message, array $payload, ReceiptPromisor $receiptPromisor) : MessageReceiptPromisor {
        return new class($message, $payLoad, $receiptPromisor) implements MessageReceiptPromisor {

            private $message;
            private $payload;
            private $receiptPromisor;

            public function __construct($message, $payload, $receiptPromisor) {
                $this->message = $message;
                $this->payload = $payload;
                $this->receiptPromisor = $receiptPromisor;
            }

            public function getMessageType() : string {
                return $this->message;
            }

            public function getMessagePayload() : array {
                return $this->payload;
            }

            public function getReceiptPromisor() : ReceiptPromisor {
                return $this->receiptPromisor;
            }

        };
    }

}