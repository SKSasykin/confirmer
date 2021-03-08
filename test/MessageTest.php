<?php

declare(strict_types=1);

namespace Confirmer\Entity;

use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testConstruct()
    {
        $message = new Message('');

        self::assertEquals(Message::class, get_class($message));
    }

    public function testSetAndGetParams()
    {
        $params = ['param1' => 'test 1', 'param2' => 'test 2'];

        $message = new Message('');

        $message->setParams($params);

        self::assertEquals($params, $message->getParams());
    }

    public function testGetParam()
    {
        $params = ['param1' => 'test 1', 'param2' => 'test 2'];

        $message = new Message('');

        $message->setParams($params);

        self::assertEquals('test 1', $message->getParam('param1'));
    }

    public function testSetParam()
    {
        $params = ['param1' => 'test 1'];

        $message = new Message('');

        $message->setParam('param1', 'test 1');

        self::assertEquals($params, $message->getParams());
    }

    public function testGetBody()
    {
        $message = new Message('confirmation #(code)');

        $message->setParam('code', 'test 1');

        self::assertEquals('confirmation test 1', $message->getBody());
    }

    public function testGetHead()
    {
        $message = new Message('confirmation #(code)', 'head #(code)');

        $message->setParam('code', 'test 1');

        self::assertEquals('head test 1', $message->getHead());
    }
}
