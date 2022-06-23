<?php

namespace App\Http\Resources;

use App\Models\FieldTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property int $id
 * @property FieldTypeEnum $type
 * @property string $title
 */
class FieldResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    #[ArrayShape(['id' => "int", 'type' => FieldTypeEnum::class, 'title' => "string"])]
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
        ];
    }
}
