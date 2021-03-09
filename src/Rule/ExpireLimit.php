<?php

declare(strict_types=1);

namespace Confirmer\Rule;

use Confirmer\Entity\Request;
use Confirmer\Exception\ExpiredException;

class ExpireLimit extends AbstractRule
{
    /**
     * @var int
     */
    private $expireTimeout;

    /**
     * @var int
     */
    protected $expire;

    public function __construct(int $expireTimeout)
    {
        $this->expireTimeout = $expireTimeout;
    }

    protected function onRequestCommand(Request $request): void
    {
        $this->expire = time() + $this->expireTimeout;
    }

    protected function onConfirmCommand(Request $request): void
    {
        if($this->expire < time()) {
            throw new ExpiredException();
        }
    }
}