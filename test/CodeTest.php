<?php

declare(strict_types=1);

namespace Confirmer\CodeGenerator;

use PHPUnit\Framework\TestCase;

class CodeTest extends TestCase
{
    public function testConstruct()
    {
        $code = new Code();

        self::assertEquals(Code::class, get_class($code));
    }

    public function testGetValue()
    {
        $code = new Code('1234');

        self::assertEquals('1234', $code->getValue());
    }

    public function testToString()
    {
        $code = new Code('1234');

        self::assertEquals('1234', (string) $code);
    }

    public function testSmsCode()
    {
        $code = new SmsCode();

        self::assertEquals(4, strlen((string) $code));
    }

    public function testEmailCode()
    {
        $code = new EmailCode();

        self::assertEquals(32, strlen((string) $code));
    }
}
