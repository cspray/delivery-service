<?php

declare(strict_types = 1);

/**
 * @license See LICENSE file in project root
 */

namespace Cspray\DeliveryService;


interface ReceiptPromisor {

    public function getReceipt() : Receipt;

    public function markDelivered(DeliveryResults $results);

}