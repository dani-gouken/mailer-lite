<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property ?int $id
 * @property ?string $email
 * @property ?string $name
 * @property ?SubscriberStateEnum $state
 */
class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        "state",
        "name",
        "email",
    ];

    protected $casts = [
        "type" => SubscriberStateEnum::class,
    ];

    public function fields(): HasMany
    {
        return $this->hasMany(Field::class);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getId(): ?string
    {
        return $this->id;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getState(): ?SubscriberStateEnum
    {
        return $this->state;
    }
}
