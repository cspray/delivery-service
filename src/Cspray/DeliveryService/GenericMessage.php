<?php

declare(strict_types = 1);

/**
 * @license See LICENSE file in project root
 */

namespace Cspray\DeliveryService;

class GenericMessage implements Message {

    private $type;
    private $payload;

    public function __construct(string $type, $payload = null) {
        $this->type = $type;
        $this->payload = $payload;
    }

    public function getType() : string {
        return $this->type;
    }

    public function getPayload() {
        return $this->payload;
    }

}