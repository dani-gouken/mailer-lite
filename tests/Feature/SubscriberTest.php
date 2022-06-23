<?php

namespace Tests\Feature;

use App\Models\Subscriber;
use App\Models\SubscriberStateEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JetBrains\PhpStorm\ArrayShape;
use Tests\TestCase;

class SubscriberTest extends TestCase
{
    use RefreshDatabase;

    protected array $subscriberData;

    protected function setUp(): void
    {
        $this->subscriberData = [
            "state" => SubscriberStateEnum::Bounced->value,
            "name" => "foo",
            "email" => "jhondoe@gmail.com",
        ];
        parent::setUp();
    }

    #[ArrayShape([
        "id" => "int|null",
        "state" => "\App\Models\SubscriberStateEnum|null",
        "name" => "null|string",
        "email" => "null|string",
    ])] private function subscriber_to_array(Subscriber $subscriber): array
    {
        return [
            "id" => $subscriber->id,
            "state" => $subscriber->state,
            "name" => $subscriber->name,
            "email" => $subscriber->email,
        ];
    }

    public function test_subscribers_are_retrieved()
    {
        $subscribers = Subscriber::factory()->count(4)->create();

        $response = $this->getJson(route("subscribers.index"));
        $response->assertStatus(200);
        $response->assertJson([
            "data" => $subscribers->map(fn($v) => $this->subscriber_to_array($v))->toArray(),
        ]);
    }

    public function test_subscribers_are_created()
    {
        $response = $this->postJson(route("subscribers.store"), $this->subscriberData);
        $response->assertStatus(201);
        $this->assertDatabaseHas(Subscriber::class, $this->subscriberData);
        $response->assertJsonFragment($this->subscriberData);
    }


    public function test_creating_a_subscriber_with_a_taken_email_fails()
    {
        /**
         * @var Subscriber $subscriber
         */
        $subscriber = Subscriber::factory()->create();
        $data = array_merge($this->subscriberData, [
            "email" => $subscriber->getEmail(),
        ]);
        $response = $this->postJson(route("subscribers.store", $data));
        $response->assertJson([
            "email" => [
                "The email has already been taken.",
            ],
        ]);
        $response->assertStatus(422);
    }

    public function provideInvalidFieldsCases(): array
    {
        return [
            "email field is missing" => [["email" => null]],
            "state field is missing" => [["state" => null]],
            "name field is missing" => [["name" => null]],
            "state field is invalid" => [["state" => "foo"]],
            "email field is invalid" => [["email" => "test@example"]],
            "email dns is invalid" => [["email" => "test@example.com"]],
        ];
    }

    /**
     * @dataProvider  provideInvalidFieldsCases
     * @return void
     */
    public function test_creating_a_subscriber_with_invalid_input_fails(array $overrides)
    {
        $data = array_merge($this->subscriberData, $overrides);
        $response = $this->postJson(route("subscribers.store"), $data);
        $response->assertStatus(422);
    }

    /**
     * @return void
     */
    public function test_a_subscriber_is_updated()
    {
        /**
         * @var Subscriber $subscriber
         */
        $subscriber = Subscriber::factory()->create();
        $response = $this->putJson(route("subscribers.update", [
            "subscriber" => $subscriber->getId(),
        ]), $data = [
            "email" => "jhon@gmail.com",
        ]);
        $response->assertJson(["data" => $data]);
        $response->assertStatus(200);
        $this->assertDatabaseHas(Subscriber::class, $data);
        $response = $this->putJson(route("subscribers.update", [
            "subscriber" => $subscriber->getId(),
        ]), $data = [
            "email" => "jhon@gmail.com",
            "state" => SubscriberStateEnum::Junk->value,
            "name" => "john",
        ]);
        $response->assertJson(["data" => $data]);
        $response->assertStatus(200);
        $this->assertDatabaseHas(Subscriber::class, $data);
    }

    /**
     * @return void
     */
    public function test_updating_with_a_taken_email_fails()
    {
        /**
         * @var Subscriber $subscriber
         * @var Subscriber $subscriber1
         */
        $subscriber = Subscriber::factory()->create();
        $subscriber1 = Subscriber::factory()->create();
        $response = $this->patchJson(route("subscribers.update", [
            "subscriber" => $subscriber->getId(),
        ]), [
            "email" => $subscriber1->getEmail(),
        ]);
        $response->assertStatus(422);
        $response->assertJson([
            "email" => [
                "The email has already been taken.",
            ],
        ]);
    }

    /**
     * @return void
     */
    public function test_a_subscriber_is_retrieved()
    {
        /**
         * @var Subscriber $subscriber
         * @var Subscriber $subscriber1
         */
        $subscriber = Subscriber::factory()->create();
        $response = $this->getJson(route("subscribers.show", [
            "subscriber" => $subscriber->getId(),
        ]));
        $response->assertStatus(200);
        $response->assertJson(["data" => $this->subscriber_to_array($subscriber)]);
    }

    /**
     * @return void
     */
    public function test_a_subscriber_is_deleted()
    {
        /**
         * @var Subscriber $subscriber
         * @var Subscriber $subscriber1
         */
        $subscriber = Subscriber::factory()->create();
        $id = $subscriber->getId();
        $this->assertDatabaseHas(Subscriber::class,compact("id"));
        $response = $this->delete(route("subscribers.destroy", [
            "subscriber" => $id,
        ]));
        $response->assertNoContent(200);
        $this->assertDatabaseMissing(Subscriber::class,compact("id"));
    }

    /**
     * @return void
     */
    public function test_404_is_returned_when_accessing_unknown_subscriber()
    {
        $this->assertDatabaseMissing(Subscriber::class,["id" => $id =  42]);
        $response = $this->get(route("subscribers.show", [
            "subscriber" => $id,
        ]));
        $response->assertNotFound();
        $response = $this->get(route("subscribers.destroy", [
            "subscriber" => $id,
        ]));
        $response->assertNotFound();

    }

}
