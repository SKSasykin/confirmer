<?php

declare(strict_types=1);

namespace Confirmer;

interface ConfirmerInterface
{
    /**
     * @param string $code
     */
    public function request(string $code = ''): void;

    /**
     * @param string $code
     */
    public function confirm(string $code): void;
}