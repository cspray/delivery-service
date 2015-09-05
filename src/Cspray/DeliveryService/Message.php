<?php

declare(strict_types = 1);

/**
 * @license See LICENSE file in project root
 */

namespace Cspray\DeliveryService;

interface Message {

    public function getType() : string;

    public function getPayload();

}