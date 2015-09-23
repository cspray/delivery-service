<?php

declare(strict_types = 1);

/**
 * @license See LICENSE file in project root
 */

namespace Cspray\DeliveryService;

use Countable;

interface MessageQueue extends Countable {

    public function enqueue(MessageReceiptPromisor $messageReceiptPromisor);

    public function dequeue() : MessageReceiptPromisor;

    public function isEmpty() : bool;

    public function hasMessages() : bool;

}