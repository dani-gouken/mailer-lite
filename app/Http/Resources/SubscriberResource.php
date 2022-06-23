<?php

namespace App\Http\Resources;

use App\Models\SubscriberStateEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property int id
 * @property ?string $email
 * @property ?string $name
 * @property ?SubscriberStateEnum $state
 */
class SubscriberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    #[ArrayShape([
        "id" => "int",
        "email" => "null|string",
        "name" => "null|string",
        "state" => SubscriberStateEnum::class,
    ])] public function toArray($request): array
    {
        return [
            "id" => $this->id,
            "email" => $this->email,
            "name" => $this->name,
            "state" => $this->state,
        ];
    }
}
