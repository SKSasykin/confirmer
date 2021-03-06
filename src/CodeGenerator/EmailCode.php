<?php

declare(strict_types=1);

namespace Confirmer\CodeGenerator;

class EmailCode extends Code
{
    public function __construct(string $value = '')
    {
        parent::__construct($value ?: md5(microtime()));
    }
}