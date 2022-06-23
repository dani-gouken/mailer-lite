<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractApiFormRequest extends FormRequest
{
    public function isUpdate(): bool
    {
        return $this->isMethod(self::METHOD_PATCH) || $this->isMethod(self::METHOD_PUT);
    }

    protected function optionalRuleOnUpdate(array $payload): array
    {
        return $this->isUpdate() ? array_merge(["sometimes"], $payload) : $payload;
    }

    public function data(): array
    {
        return $this->json()->all();
    }

}
