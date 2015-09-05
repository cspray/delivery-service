<?php

declare(strict_types = 1);

/**
 * @license See LICENSE file in project root
 */

namespace Cspray\DeliveryService;

interface Transmitter {

    public function send(Message $message) : Receipt;

    public function getMessageQueue() : MessageQueue;

}