<?php

declare(strict_types = 1);

/**
 * @license See LICENSE file in project root
 */

namespace Cspray\DeliveryService\Test;

use Cspray\DeliveryService\StandardReceiver;
use PHPUnit_Framework_TestCase as UnitTestCase;

class StandardReceiverTest extends UnitTestCase {

    public function testAddListenerGetsListenerForType() {
        $receiver = new StandardReceiver();
        $cb = function() {};
        $key = $receiver->listen('type', $cb);

        $expected = [$key => $cb];

        $this->assertSame($expected, $receiver->getListeners('type'));
    }

    public function testRemovingListeners() {
        $receiver = new StandardReceiver();
        $cb = function() {};

        $id1 = $receiver->listen('type', $cb);
        $id2 = $receiver->listen('type', $cb);
        $id3 = $receiver->listen('foo', $cb);

        $expectedType = [$id1 => $cb, $id2 => $cb];
        $expectedFoo = [$id3 => $cb];
        $this->assertSame($expectedType, $receiver->getListeners('type'));
        $this->assertSame($expectedFoo, $receiver->getListeners('foo'));

        $receiver->removeListener($id1);
        $receiver->removeListener($id3);

        $this->assertSame([$id2 => $cb], $receiver->getListeners('type'));
        $this->assertSame([], $receiver->getListeners('foo'));
    }

    public function testListenerIdsDoNoCollide() {
        $receiver = new StandardReceiver();
        $cb = function() {};
        $id1 = $receiver->listen('type', $cb);

        $receiver->removeListener($id1);

        $id2 = $receiver->listen('type', $cb);

        $this->assertNotSame($id1, $id2);
    }

}