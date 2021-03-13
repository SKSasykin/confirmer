<?php

declare(strict_types=1);

namespace Confirmer;

use Confirmer\CodeGenerator\Code;
use Confirmer\Entity\Message;
use Confirmer\Entity\Request;
use Confirmer\Entity\Status;
use Confirmer\Exception\InvalidCodeException;
use Confirmer\Rule\RuleInterface;

class Confirmer implements ConfirmerInterface
{
    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @var CommandInterface
     */
    private $command;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Message
     */
    private $message;

    /**
     * @var RuleInterface[]
     */
    private $rules = [];

    public function __construct(
        RepositoryInterface $repository,
        CommandInterface $command,
        Request $request,
        Message $message = null
    )
    {
        $this->repository = $repository;
        $this->command    = $command;
        $this->request    = $request;
        $this->message    = $message ?? new Message('Confirmation code: #(code)', 'Confirmation');
    }

    public function addRule(RuleInterface $rule): void
    {
        $this->rules[] = $rule;
    }

    /**
     * @inheritDoc
     */
    public function request(string $code = ''): void
    {
        foreach ($this->rules as $rule) {
            $rule->onRequest($this->request);
        }

        if ($code) {
            $code   = new Code($code);
            $status = $this->request->getStatus();
            $this->request->setStatus(new Status($code, $status->isConfirmed(), $status->getRequestTime()));
        } else {
            $code = $this->request->getStatus()->getCode();
        }

        $this->message->setParam('code', (string) $code);

        $this->repository->save($this->request);

        $this->command->execute($this->request, $this->message);
    }

    /**
     * @inheritDoc
     */
    public function confirm(string $code): void
    {
        foreach ($this->rules as $rule) {
            $rule->onConfirm($this->request);
        }

        if ($code != $this->request->getStatus()->getCode()) {
            $this->repository->save($this->request);

            throw new InvalidCodeException();
        }

        $status = $this->request->getStatus();

        $this->request->setStatus(new Status($status->getCode(), true, $status->getRequestTime()));

        $this->repository->save($this->request);
    }
}
