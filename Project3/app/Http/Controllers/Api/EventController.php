<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Traits\LoadOptionalRelationships;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{

    use LoadOptionalRelationships;

    private array $relations = ['user', 'attendees', 'attendees.user'];

    /**
     * Display a listing of the resource.
     *
     * After specifying with the EventResource, we will not just only see arrays, but everything
     * will be wrapped around a "data": [] property
     *
     * It allows you to have 'more fields' allowing you to add some type of for example 'meta' fields
     * You can see the more practical part inside the EventResource.php file at the toArray() method
     * where we can literally modify how the data will be seen, what to see, etc... (hiding attrbiutes, etc...)
     *
     * Simply: We can make that datas visible that we only want
     *
     * Real life benefits: For example if I want to show the Event's owner's name, I dont have to fetch all the time this User table column,
     * and here comes the help of the resource -> we don't have to make 100, 200 request just to display the organizer's name...
     */
    public function index()
    {
        /**
         * We will be loading all the events together with the user relation (inside EventResource whenLoaded() method's usage is visible here)
         * Because when the user relation is LOADED then it will be visible,
         * if not loaded (using the normal Event::all()) then it wont be visible with the user relation
        */
        $query = $this->loadRelationships(Event::query());

        return EventResource::collection(
            $query->latest()->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $event = Event::create([
            ...$request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time'
            ]),
            'user_id' => 1
        ]);

        return new EventResource($this->loadRelationships($event));
    }

    /**
     * Display the specified resource.
     *
     * Return a single Event
     *
     * With API resources (EventResource) the same happened as at the index()
     * The data was wrapped around a "data": {} property
     */
    public function show(Event $event)
    {
        //Resource usage when we want to load also the user relation just at a single data
        //$event->load('user', 'attendees');
        return new EventResource($this->loadRelationships($event));
    }

    /**
     * Update the specified resource in storage.
     *
     * sometimes validation:
     * It will only check the next valditaion constraints after some times if the value is present in the input
     */
    public function update(Request $request, Event $event)
    {
        $event->update($request->validate([
                'name' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'sometimes|date',
                'end_time' => 'sometimes|date|after:start_time'
        ]));

        return new EventResource($this->loadRelationships($event));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json([
            'message' => 'Event deleted successfully!'
        ]);
        /**
         * Alternative can be (PHP > 8.x.x):
         * return response(status: 204);
         *
         * The 204 code is common practice at RESTApis when deleting resources
         *
         * As an older version PHP:
         * return response('', status: 204);
         */
    }
}
