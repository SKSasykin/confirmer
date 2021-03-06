<?php

declare(strict_types=1);

namespace Confirmer\Entity;

class Request
{
    /**
     * @var string
     */
    protected $recipient;

    /**
     * @var string
     */
    protected $ip;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var Status
     */
    protected $status;

    /**
     * @var mixed
     */
    protected $userPayload;

    public function __construct(
        string $recipient,
        string $ip,
        string $token,
        Status $status,
        $userPayload = null

    )
    {
        $this->recipient   = $recipient;
        $this->ip          = $ip;
        $this->token       = $token;
        $this->status      = $status;
        $this->userPayload = $userPayload;
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed|null
     */
    public function getUserPayload()
    {
        return $this->userPayload;
    }
}