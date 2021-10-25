<?php

declare(strict_types=1);

namespace Confirmer\Rule;

use Confirmer\Entity\Request;
use Confirmer\Exception\NotExpiredException;

class RepeatLimit extends AbstractRule
{
    /**
     * @var int
     */
    private $repeatTimeout;

    /**
     * @psalm-suppress PropertyNotSetInConstructor
     * @var int
     */
    protected $repeatTime;

    public function __construct(int $repeatTimeout)
    {
        $this->repeatTimeout = $repeatTimeout;
    }

    protected function onRequestCommand(Request $request): void
    {
        if(isset($this->repeatTime) && $this->repeatTime > time()) {
            throw new NotExpiredException();
        }

        $this->repeatTime = time() + $this->repeatTimeout;
    }

    protected function onConfirmCommand(Request $request): void
    {
    }
}