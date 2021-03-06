<?php

declare(strict_types=1);

namespace Confirmer\Rule;

use Confirmer\Entity\Request;
use Confirmer\Exception\TriesLimitException;

class TriesLimit implements RuleInterface
{
    /**
     * @var int
     */
    private $maxTries;

    public function __construct(int $maxTries)
    {
        $this->maxTries = $maxTries;
    }

    public function onRequest(Request $request): void
    {
        $request->getStatus()->tries = 0;
    }

    public function onConfirm(Request $request): void
    {
        if($request->getStatus()->tries >= $this->maxTries) {
            throw new TriesLimitException();
        }

        $request->getStatus()->tries++;
    }
}