<?php

declare(strict_types=1);

namespace Confirmer\Rule;

use Confirmer\Entity\Request;
use Confirmer\Exception\TriesLimitException;

class TriesLimit extends AbstractRule
{
    /**
     * @var int
     */
    private $maxTries;

    /**
     * @psalm-suppress PropertyNotSetInConstructor
     * @var int
     */
    protected $tries;

    public function __construct(int $maxTries)
    {
        $this->maxTries = $maxTries;
    }

    public function onRequestCommand(Request $request): void
    {
        $this->tries = 0;
    }

    public function onConfirmCommand(Request $request): void
    {
        if($this->tries >= $this->maxTries) {
            throw new TriesLimitException();
        }

        $this->tries++;
    }
}