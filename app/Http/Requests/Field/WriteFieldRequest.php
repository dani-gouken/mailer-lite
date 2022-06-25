<?php

namespace App\Http\Requests\Field;

use App\Http\Requests\AbstractApiFormRequest;
use App\Models\FieldTypeEnum;
use Illuminate\Validation\Rules\Enum;
use JetBrains\PhpStorm\ArrayShape;

class WriteFieldRequest extends AbstractApiFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(["title" => "array", "type" => "array"])] public function rules(): array
    {
        return [
            "title" => $this->optionalRuleOnUpdate(["required", "string",]),
            "type" => $this->optionalRuleOnUpdate(["required", new Enum(FieldTypeEnum::class)]),
        ];
    }
}
