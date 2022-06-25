<?php

namespace Tests\Feature;

use App\Models\Field;
use App\Models\FieldTypeEnum;
use App\Models\Subscriber;
use App\Models\SubscriberStateEnum;
use Database\Factories\FieldFactory;
use Database\Factories\SubscriberFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Tests\TestCase;

class SubscriberFieldTest extends TestCase
{
    use RefreshDatabase;

    protected array $fieldData;

    protected function setUp(): void
    {
        $this->fieldData = [
            "type" => FieldTypeEnum::Boolean->value,
            "title" => "foo",
        ];
        parent::setUp();
    }

    public function test_the_fields_of_a_subscriber_are_retrieved()
    {
        /**
         * @var Subscriber $subscriber1
         * @var Subscriber $subscriber2
         */
        $subscriber1 = Subscriber::factory()->create();
        $subscriber2 = Subscriber::factory()->create();

        $subscriber1Fields = FieldFactory::new()->count(4)->forSubscriber($subscriber1)->create();
        $subscriber2Fields = FieldFactory::new()->count(2)->forSubscriber($subscriber2)->create();


        $response = $this->getJson(route("subscribers.fields.index", [
            "subscriber" => $subscriber1,
        ]));
        $response->assertStatus(200);
        $response->assertJson([
            "data" => $subscriber1Fields->map(fn($v) => $this->field_to_array($v))->toArray(),
        ]);

        $response = $this->getJson(route("subscribers.fields.index", [
            "subscriber" => $subscriber2,
        ]));
        $response->assertStatus(200);
        $response->assertJson([
            "data" => $subscriber2Fields->map(fn($v) => $this->field_to_array($v))->toArray(),
        ]);
    }

    public function test_a_field_of_a_subscriber_is_retrieved()
    {
        /**
         * @var Field $field
         * @var Subscriber $subscriber
         */
        $subscriber = Subscriber::factory()->create();
        $field = FieldFactory::new()->forSubscriber($subscriber)->create();
        $response = $this->getJson(route("subscribers.fields.show", [
            "subscriber" => $subscriber->getId(),
            "field" => $field->getId()
        ]));
        $response->assertStatus(200);
        $response->assertJson([
            "data" => $this->field_to_array($field),
        ]);
    }

    public function test_fields_are_created()
    {
        $subscriber = SubscriberFactory::new()->create();
        $response = $this->postJson(route("subscribers.fields.store", [
            "subscriber" => $subscriber
        ]), $this->fieldData);
        $response->assertStatus(201);
        $this->assertDatabaseHas(Field::class, $this->fieldData);
        $response->assertJsonFragment($this->fieldData);
    }

    public function provideInvalidFieldsCases(): array
    {
        return [
            "title field is missing" => [["title" => null]],
            "type field is missing" => [["type" => null]],
            "type field is invalid" => [["type" => "foo"]],
        ];
    }

    /**
     * @dataProvider  provideInvalidFieldsCases
     * @return void
     */
    public function test_creating_a_subscriber_with_invalid_input_fails(array $overrides)
    {
        /**
         * @var Subscriber $subscriber
         */
        $subscriber = Subscriber::factory()->create();
        $data = array_merge($this->fieldData, $overrides);
        $response = $this->postJson(route("subscribers.fields.store", compact("subscriber")), $data);
        $response->assertStatus(422);
    }


    public function test_a_field_is_scoped_to_a_subscriber()
    {
        /**
         * @var Field $field
         * @var Subscriber $subscriber1
         * @var Subscriber $subscriber2
         */
        $subscriber1 = Subscriber::factory()->create();
        $subscriber2 = Subscriber::factory()->create();
        $field = FieldFactory::new()->forSubscriber($subscriber1)->create();
        $response = $this->getJson(route("subscribers.fields.show", [
            "subscriber" => $subscriber2->getId(),
            "field" => $field->getId()
        ]));
        $response->assertNotFound();
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
        $field = FieldFactory::new()->forSubscriber($subscriber)->create();
        $response = $this->putJson(route("subscribers.fields.update", [
            "subscriber" => $subscriber,
            "field" => $field
        ]), $data = [
            "title" => "foo1",
        ]);
        $response->assertJson(["data" => $data]);
        $response->assertStatus(200);
        $this->assertDatabaseHas(Field::class, $data);
        $response = $this->putJson(route("subscribers.fields.update", [
            "subscriber" => $subscriber,
            "field" => $field
        ]), $data = [
            "title" => "foo1",
            "type" => FieldTypeEnum::Number->value,
        ]);
        $response->assertJson(["data" => $data]);
        $response->assertStatus(200);
        $this->assertDatabaseHas(Field::class, $data);
    }

    /**
     * @return void
     */
    public function test_a_field_is_deleted()
    {
        /**
         * @var Subscriber $subscriber
         * @var Subscriber $subscriber1
         */
        $subscriber = Subscriber::factory()->create();
        $field = FieldFactory::new()->forSubscriber($subscriber)->create();
        $id = $field->getId();
        $this->assertDatabaseHas(Field::class, compact("id"));
        $response = $this->delete(route("subscribers.fields.destroy", [
            "subscriber" => $subscriber,
            "field" => $field
        ]));
        $response->assertNoContent(200);
        $this->assertDatabaseMissing(Field::class, compact("id"));
    }

    /**
     * @return void
     */
    public function test_404_is_returned_when_accessing_unknown_subscriber()
    {
        $subscriber = SubscriberFactory::new()->create();
        $this->assertDatabaseMissing(Field::class, ["id" => $id =  42]);
        $response = $this->get(route("subscribers.fields.show", [
            "subscriber" => $subscriber,
            "field" => $id
        ]));
        $response->assertNotFound();
        $response = $this->get(route("subscribers.fields.destroy", [
            "subscriber" => $subscriber,
            "field" => $id
        ]));
        $response->assertNotFound();
        $field = FieldFactory::new()->forSubscriber($subscriber)->create();
        $response = $this->get(route("subscribers.fields.destroy", [
            "subscriber" => $id,
            "field" => $field
        ]));
        $response->assertNotFound();
    }

    #[Pure] #[ArrayShape(["id" => "int|null", "title" => "null|string", "type" => "\App\Models\FieldTypeEnum|null"])]
    protected function field_to_array(Field $field): array
    {
        return ["id" => $field->getId(), "title" => $field->getTitle(), "type" => $field->getType()->value];
    }
}
