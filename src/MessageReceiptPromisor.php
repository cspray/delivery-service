<?php

declare(strict_types = 1);

/**
 * @license See LICENSE file in project root
 */

namespace Cspray\DeliveryService;

interface MessageReceiptPromisor {

    public function getMessageType() : string;

    public function getMessagePayload() : array;

    public function getReceiptPromisor() : ReceiptPromisor;

}