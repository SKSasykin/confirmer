<?php

declare(strict_types=1);

namespace Confirmer\Rule;

use Confirmer\Entity\Request;

abstract class AbstractRule implements RuleInterface
{
    abstract protected function onRequestCommand(Request $request): void;

    abstract protected function onConfirmCommand(Request $request): void;

    final public function onRequest(Request $request): void
    {
        $this->loadFields($request);
        $this->onRequestCommand($request);
        $this->saveFields($request);
    }

    final public function onConfirm(Request $request): void
    {
        $this->loadFields($request);
        $this->onConfirmCommand($request);
        $this->saveFields($request);
    }

    private function loadFields(Request $request): void
    {
        $data = $request->getStatus()->{static::class} ?? [];
        foreach ($this->fields() as $field) {
            $this->{$field} = $data[$field] ?? null;
        }
    }

    private function saveFields(Request $request): void
    {
        $data = [];
        foreach ($this->fields() as $field) {
            $data[$field] = $this->{$field};
        }
        $request->getStatus()->{static::class} = $data;
    }

    /**
     * @return string[]
     */
    private function fields(): array
    {
        return array_diff(
            array_keys(get_class_vars(static::class)),
            array_keys(get_class_vars(self::class))
        );
    }
}