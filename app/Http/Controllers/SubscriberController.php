<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subscriber\WriteSubscriberRequest;
use App\Http\Resources\SubscriberResource;
use App\Models\Subscriber;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\Pure;

class SubscriberController extends Controller
{
    /**
     * all subscribers
     */
    public function index(): AnonymousResourceCollection
    {
        return SubscriberResource::collection(Subscriber::all());
    }

    /**
     * create a subscriber
     *
     * @param WriteSubscriberRequest $request
     * @return SubscriberResource
     */
    public function store(WriteSubscriberRequest $request): SubscriberResource
    {
        return new SubscriberResource(Subscriber::query()->create($request->data()));
    }

    /**
     * Display the specified resource.
     *
     * @param Subscriber $subscriber
     * @return SubscriberResource
     */
    #[Pure] public function show(Subscriber $subscriber): SubscriberResource
    {
        return new SubscriberResource($subscriber);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param WriteSubscriberRequest $request
     * @param Subscriber $subscriber
     * @return SubscriberResource
     */
    public function update(WriteSubscriberRequest $request, Subscriber $subscriber): SubscriberResource
    {
        $subscriber->update(
            $request->data()
        );
        return new SubscriberResource($subscriber->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Subscriber $subscriber
     * @return Response
     */
    public function destroy(Subscriber $subscriber): Response
    {
        $subscriber->delete();

        return new Response("", Response::HTTP_OK);
    }
}
