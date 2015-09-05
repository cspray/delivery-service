<?php

declare(strict_types = 1);

/**
 * @license See LICENSE file in project root
 */

namespace Cspray\DeliveryService;

interface ReceiptPromisorFactory {

    public function create() : ReceiptPromisor;

}