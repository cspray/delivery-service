<?php

declare(strict_types = 1);

/**
 * @license See LICENSE file in project root
 */

namespace Cspray\DeliveryService\Test;

use Cspray\DeliveryService\Receipt;
use Cspray\DeliveryService\ReceiptPromisorFactory;
use Cspray\DeliveryService\ReceiptPromisor;
use Cspray\DeliveryService\GenericMessage;
use Cspray\DeliveryService\StandardTransmitter;
use PHPUnit_Framework_TestCase as UnitTestCase;

class StandardTransmitterTest extends UnitTestCase {

    public function testSendingMessageAddsToQueue() {
        $factory = $this->getMock(ReceiptPromisorFactory::class);
        $promisor = $this->getMock(ReceiptPromisor::class);
        $promise = $this->getMock(Receipt::class);

        $factory->expects($this->once())->method('create')->willReturn($promisor);
        $promisor->expects($this->once())->method('getReceipt')->willReturn($promise);

        $transmitter = new StandardTransmitter($factory);

        $msg = new GenericMessage('generic');
        $transmitter->send($msg);

        $this->assertCount(1, $transmitter->getMessageQueue());
    }

}