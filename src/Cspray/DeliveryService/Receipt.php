<?php

declare(strict_types = 1);

/**
 * @license See LICENSE file in project root
 */

namespace Cspray\DeliveryService;


interface Receipt {

    /**
     * Invokes a callable when the Message for this Receipt has been delivered to
     * all listeners.
     *
     * function(DeliveryResults $results) {
     *
     * }
     *
     * @param callable $cb
     * @return self
     */
    public function delivered(callable $cb);

}