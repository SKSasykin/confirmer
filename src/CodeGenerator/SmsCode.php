<?php

declare(strict_types=1);

namespace Confirmer\CodeGenerator;

class SmsCode extends Code
{
    public function __construct(string $value = '')
    {
        parent::__construct($value ?: (string) rand(1000, 9999));
    }
}