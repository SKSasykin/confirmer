<?php

declare(strict_types=1);

namespace Confirmer\Entity;

class Message
{
    /**
     * @var string
     */
    protected $head; // = 'head + param = #(param)'

    /**
     * @var string
     */
    protected $body; // = 'text + param = #(param)'

    /**
     * @var string[]
     */
    protected $params = [];

    public function __construct(string $body, string $head = '')
    {
        $this->head = $head;
        $this->body = $body;
    }

    public function getParam(string $name): string
    {
        return $this->params[$name] ?? '';
    }

    public function setParam(string $name, string $value): void
    {
        $this->params[$name] = $value;
    }

    /**
     * @param array $params
     *      example:
     *      array(
     *      'param1' => 'text param 1'
     *      'param2' => 'text param 2'
     *      )
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getHead(): string
    {
        return $this->build($this->head);
    }

    public function getBody(): string
    {
        return $this->build($this->body);
    }

    protected function build(string $content): string
    {
        $params = [];
        foreach ($this->params as $param => $text) {
            $params["#($param)"] = (string) $text;
        }

        return strtr($content, $params);
    }
}