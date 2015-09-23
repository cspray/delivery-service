<?php

declare(strict_types = 1);

/**
 * @license See LICENSE file in project root
 */

namespace Cspray\DeliveryService;

use Cspray\DeliveryService\Exception\EmptyQueueException;

class InMemoryMessageQueue implements MessageQueue {

    private $queue = [];

    public function enqueue(MessageReceiptPromisor $messageReceiptPromisor) {
        $this->queue[] = $messageReceiptPromisor;
    }

    public function dequeue() : MessageReceiptPromisor {
        if (empty($this->queue)) {
            throw new EmptyQueueException('Attempted to dequeue an empty queue');
        }

        return array_shift($this->queue);
    }

    public function isEmpty() : bool {
        return empty($this->queue);
    }

    public function hasMessages() : bool {
        return !empty($this->queue);
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count() {
        return count($this->queue);
    }

}