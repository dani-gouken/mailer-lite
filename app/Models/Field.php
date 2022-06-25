<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property ?int $id
 * @property ?FieldTypeEnum $type
 * @property ?string $title
 */
class Field extends Model
{
    use HasFactory;

    protected $fillable = [
        "type",
        "title",
    ];

    protected $casts = [
        "type" => FieldTypeEnum::class,
    ];

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(Subscriber::class);
    }

    public function getType(): ?FieldTypeEnum
    {
        return $this->type;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }
}
