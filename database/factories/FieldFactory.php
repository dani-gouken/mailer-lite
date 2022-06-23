<?php

namespace Database\Factories;

use App\Models\FieldTypeEnum;
use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class FieldFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape(["title" => "string", "type" => "mixed"])] public function definition(): array
    {
        return [
            "title" => $this->faker->title,
            "type" => $this->faker->randomElement(FieldTypeEnum::cases())->value,
        ];
    }


    public function forSubscriber(Subscriber $subscriber): FieldFactory
    {
        return $this->state(fn(array $attributes) => [
            'subscriber_id' => $subscriber->getId(),
        ]);
    }
}
