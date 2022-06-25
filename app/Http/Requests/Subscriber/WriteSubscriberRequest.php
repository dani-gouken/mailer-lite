<?php

namespace App\Http\Requests\Subscriber;

use App\Http\Requests\AbstractApiFormRequest;
use App\Models\Subscriber;
use App\Models\SubscriberStateEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use JetBrains\PhpStorm\ArrayShape;

class WriteSubscriberRequest extends AbstractApiFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape([
        "email" => "string[]",
        "name" => "string[]",
        "state" => "\Illuminate\Validation\Rules\Enum[]",
    ])] public function rules(): array
    {
        return [
            "email" => $this->optionalRuleOnUpdate([
                "required",
                "email:rfc,dns",
                Rule::unique(Subscriber::class, "email")->ignore(
                    $this->isUpdate() ? $this->route()->parameter("subscriber") : null
                ),
            ]),
            "name" => $this->optionalRuleOnUpdate(["required", "string"]),
            "state" => $this->optionalRuleOnUpdate(["required", new Enum(SubscriberStateEnum::class)]),
        ];
    }
}
