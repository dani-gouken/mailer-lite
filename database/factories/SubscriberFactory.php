<?php

namespace Database\Factories;

use App\Models\SubscriberStateEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class SubscriberFactory extends Factory
{
    protected static array $freeEmailDomain = array('gmail.com', 'yahoo.com', 'hotmail.com');
    /**
     * Define the model's default state.
     *
     * @return array
     */
    #[ArrayShape(["email" => "string", "name" => "string", "state" => "mixed"])]
    public function definition(): array
    {
        return [
            "email" => $this->faker->freeEmail,
            "name" => $this->faker->name,
            "state" => $this->faker->randomElement(SubscriberStateEnum::cases())->value,
        ];
    }
}
