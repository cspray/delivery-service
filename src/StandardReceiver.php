<?php

declare(strict_types = 1);

/**
 * @license See LICENSE file in project root
 */

namespace Cspray\DeliveryService;

class StandardReceiver implements Receiver {

    private $listeners = [];

    public function listen(string $messageType, callable $callback) : string {
        if (!isset($this->listeners[$messageType])) {
            $this->listeners[$messageType] = [];
        }

        $id = $this->getListenerId();
        $this->listeners[$messageType][$id] = $callback;
        return $id;
    }

    public function removeListener(string $listenerId) {
        $listenerType = null;
        foreach ($this->listeners as $type => $typeListeners) {
            foreach ($typeListeners as $idHash => $listener) {
                if ($listenerId === $idHash) {
                    $listenerType = $type;
                    break;
                }
            }
        }

        if ($listenerType) {
            unset($this->listeners[$listenerType][$listenerId]);
        }
    }

    public function getListeners(string $messageType) : array {
        return $this->listeners[$messageType] ?? [];
    }

    private function getListenerId() : string {
        return md5((string) random_int(PHP_INT_MIN, PHP_INT_MAX));
    }

}