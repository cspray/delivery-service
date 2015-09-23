<?php

declare(strict_types = 1);

/**
 * @license See LICENSE file in project root
 */

namespace Cspray\DeliveryService;

class StandardDeliveryResults implements DeliveryResults {

    private $success;
    private $failure;

    public function __construct(array $success = [], array $failure = []) {
        $this->success = $success;
        $this->failure = $failure;
    }

    public function getNumberListeners() : int {
        return count($this->success) + count($this->failure);
    }

    public function getSuccessfulResults() : array {
        return $this->success;
    }

    public function getFailureResults() : array {
        return $this->failure;
    }

}