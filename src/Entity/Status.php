<?php

declare(strict_types=1);

namespace Confirmer\Entity;

use Confirmer\CodeGenerator\Code;
use DateTimeImmutable;
use DateTimeInterface;

class Status
{
    /**
     * @var Code
     */
    protected $code;

    /**
     * @var bool
     */
    protected $confirmed;

    /**
     * @var DateTimeInterface
     */
    protected $requestTime;

    /**
     * @var array
     */
    protected $dynamicPayload = [];

    public function __construct(
        Code $code,
        bool $confirmed = false,
        DateTimeInterface $requestTime = null,
        $dynamicPayload = []
    )
    {
        $this->code           = $code;
        $this->confirmed      = $confirmed;
        $this->requestTime    = $requestTime ?? new DateTimeImmutable();
        $this->dynamicPayload = $dynamicPayload;
    }

    public function __get($name)
    {
        return $this->dynamicPayload[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $this->dynamicPayload[$name] = $value;
    }

    public function __isset($name): bool
    {
        return isset($this->dynamicPayload[$name]);
    }

    public function getCode(): Code
    {
        return $this->code;
    }

    public function isConfirmed(): bool
    {
        return $this->confirmed;
    }

    public function getRequestTime(): DateTimeInterface
    {
        return $this->requestTime;
    }

    public function getDynamicPayload(): array
    {
        return $this->dynamicPayload;
    }
}