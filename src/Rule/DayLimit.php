<?php

declare(strict_types=1);

namespace Confirmer\Rule;

use Confirmer\Entity\Request;
use Confirmer\Exception\TriesLimitException;
use DateTime;

class DayLimit implements RuleInterface
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
        if (empty($request->getStatus()->dayTries)) {
            $request->getStatus()->dayTries = 0;
        }
    }

    public function onConfirm(Request $request): void
    {
        if ($request->getStatus()->dayTries >= $this->maxTries) {
            throw new TriesLimitException();
        }

        if ($request->getStatus()->getRequestTime()->format('Y-m-d') == (new DateTime())->format('Y-m-d')) {
            $request->getStatus()->dayTries++;
        } else {
            $request->getStatus()->dayTries = 0;
        }
    }
}