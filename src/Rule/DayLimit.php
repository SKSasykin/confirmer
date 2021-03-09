<?php

declare(strict_types=1);

namespace Confirmer\Rule;

use Confirmer\Entity\Request;
use Confirmer\Exception\TriesLimitException;
use DateTime;

class DayLimit extends AbstractRule
{
    /**
     * @var int
     */
    private $maxTries;

    /**
     * @var int
     */
    protected $tries;

    public function __construct(int $maxTries)
    {
        $this->maxTries = $maxTries;
    }

    protected function onRequestCommand(Request $request): void
    {
        if (empty($this->tries)) {
            $this->tries = 0;
        }
    }

    protected function onConfirmCommand(Request $request): void
    {
        if ($this->tries >= $this->maxTries) {
            throw new TriesLimitException();
        }

        if ($request->getStatus()->getRequestTime()->format('Y-m-d') == (new DateTime())->format('Y-m-d')) {
            $this->tries++;
        } else {
            $this->tries = 0;
        }
    }
}