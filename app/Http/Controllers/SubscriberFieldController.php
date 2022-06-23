<?php

namespace App\Http\Controllers;

use App\Http\Requests\Field\WriteFieldRequest;
use App\Http\Resources\FieldResource;
use App\Models\Field;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\Pure;

class SubscriberFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Subscriber $subscriber
     * @return AnonymousResourceCollection
     */
    public function index(Subscriber $subscriber): AnonymousResourceCollection
    {
        return FieldResource::collection($subscriber->fields()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param WriteFieldRequest $request
     * @param Subscriber $subscriber
     * @return FieldResource
     */
    public function store(WriteFieldRequest $request, Subscriber $subscriber): FieldResource
    {
        return new FieldResource($subscriber->fields()->create($request->data()));
    }

    /**
     * Display the specified resource.
     *
     * @param Subscriber $subscriber
     * @param Field $field
     * @return FieldResource
     */
    #[Pure] public function show(Subscriber $subscriber, Field $field): FieldResource
    {
        return new FieldResource($field);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param WriteFieldRequest $request
     * @param Field $field
     * @return FieldResource
     */
    public function update(WriteFieldRequest $request, Subscriber $subscriber, Field $field): FieldResource
    {
        $field->update(
            $request->data()
        );

        return new FieldResource($field->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Subscriber $subscriber
     * @param Field $field
     * @return Response
     */
    public function destroy(Subscriber $subscriber, Field $field): Response
    {
        $field->delete();

        return new Response("", Response::HTTP_OK);
    }
}
