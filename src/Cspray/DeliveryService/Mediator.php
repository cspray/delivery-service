<?php

declare(strict_types = 1);

/**
 * @license See LICENSE file in project root
 */

namespace Cspray\DeliveryService;

interface Mediator {

    public function isSendingMessages() : bool;

    public function startSendingMessages();

    public function stopSendingMessages();

}