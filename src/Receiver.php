<?php

declare(strict_types = 1);

/**
 * @license See LICENSE file in project root
 */

namespace Cspray\DeliveryService;

interface Receiver {

    /**
     * Should return a ListenerId that identifies the given listener
     * for a specific message type.
     *
     * @param string $messageType
     * @param callable $callback
     * @return string
     */
    public function listen(string $messageType, callable $callback) : string;

    public function removeListener(string $listenerId);

    public function getListeners(string $messageType) : array;

}