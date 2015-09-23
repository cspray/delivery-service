<?php

declare(strict_types = 1);

/**
 * @license See LICENSE file in project root
 */

namespace Cspray\DeliveryService\Test;

use Cspray\DeliveryService\Message;
use Cspray\DeliveryService\ReceiptPromisor;
use Cspray\DeliveryService\MessageReceiptPromisor;
use Cspray\DeliveryService\InMemoryMessageQueue;
use Cspray\DeliveryService\Exception\EmptyQueueException;
use PHPUnit_Framework_TestCase as UnitTestCase;

class InMemoryMessageQueueTest extends UnitTestCase {

    public function helperFunctionNoMessagesProvider() {
        return [
            ['count', 0],
            ['isEmpty', true],
            ['hasMessages', false]
        ];
    }

    /**
     * @dataProvider helperFunctionNoMessagesProvider
     */
    public function testHelperFunctionsNoMessagesQueued($method, $expected) {
        $queue = new InMemoryMessageQueue();

        $actual = $queue->$method();

        $this->assertSame($expected, $actual);
    }

    public function helperFunctionOneMessageProvider() {
        return [
            ['count', 1],
            ['isEmpty', false],
            ['hasMessages', true]
        ];
    }

    /**
     * @dataProvider helperFunctionOneMessageProvider
     */
    public function testHelperFunctionsOneMessageQueued($method, $expected) {
        $queue = new InMemoryMessageQueue();
        $messageReceiptPromisor = $this->getMock(MessageReceiptPromisor::class);
        $queue->enqueue($messageReceiptPromisor);

        $actual = $queue->$method();

        $this->assertSame($expected, $actual);
    }

    public function testDequeueingNothingQueuedThrowsException() {
        $queue = new InMemoryMessageQueue();

        $exc = EmptyQueueException::class;
        $msg = 'Attempted to dequeue an empty queue';
        $this->setExpectedException($exc, $msg);

        $queue->dequeue();
    }

    public function testDequeueingRemovesFirstItemEnqueued() {
        $queue = new InMemoryMessageQueue();

        $mr1 = $this->getMock(MessageReceiptPromisor::class);
        $mr2 = $this->getMock(MessageReceiptPromisor::class);

        $queue->enqueue($mr1);
        $queue->enqueue($mr2);

        $deq1 = $queue->dequeue();
        $deq2 = $queue->dequeue();

        $this->assertCount(0, $queue);
        $this->assertSame($mr1, $deq1);
        $this->assertSame($mr2, $deq2);
    }

}