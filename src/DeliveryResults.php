<?php

declare(strict_types = 1);

/**
 * @license See LICENSE file in project root
 */

namespace Cspray\DeliveryService;

interface DeliveryResults {

    public function getNumberListeners() : int;

    public function getSuccessfulResults() : array;

    public function getFailureResults() : array;

}