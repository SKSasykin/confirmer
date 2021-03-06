<?php

declare(strict_types=1);

namespace Confirmer\Rule;

use Confirmer\Entity\Request;
use Confirmer\Exception\NotExpiredException;

class RepeatLimit implements RuleInterface
{
    protected $repeatTimeout;

    public function __construct(int $repeatTimeout)
    {
        $this->repeatTimeout = $repeatTimeout;
    }

    public function onRequest(Request $request): void
    {
        if(isset($request->getStatus()->repeatTime) && $request->getStatus()->repeatTime > time()) {
            throw new NotExpiredException();
        }

        $request->getStatus()->repeatTime = time() + $this->repeatTimeout;
    }

    public function onConfirm(Request $request): void
    {
    }
}