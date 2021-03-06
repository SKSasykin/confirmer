<?php

declare(strict_types=1);

namespace Confirmer\Rule;

use Confirmer\Entity\Request;
use Confirmer\Exception\ExpiredException;

class ExpireLimit implements RuleInterface
{
    /**
     * @var int
     */
    private $expireTimeout;

    public function __construct(int $expireTimeout)
    {
        $this->expireTimeout = $expireTimeout;
    }

    public function onRequest(Request $request): void
    {
        $request->getStatus()->expire = time() + $this->expireTimeout;
    }

    public function onConfirm(Request $request): void
    {
        if($request->getStatus()->expire < time()) {
            throw new ExpiredException();
        }
    }
}