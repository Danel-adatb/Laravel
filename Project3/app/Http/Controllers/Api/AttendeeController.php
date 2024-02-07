<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;
use App\Http\Traits\LoadOptionalRelationships;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{

    use LoadOptionalRelationships;

    private array $relations = ['user'];

    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        $attendees = $this->loadRelationships(
            $event->attendees()->latest()
        );

        return AttendeeResource::collection(
            $attendees->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * When we are using create(), it is a MASS ASSIGNMENT operation, so we have to create a $fillable property
     * for every attribute that is used inside the MASS ASSIGNMENT
     *
     * When we want to for example associate an Attendee with an Event, we can use the relationship method
     * from the parent Model and THEN call create() on it
     * -> automatically sets the event ID (connects it with the event)
     * -> creates a new Attendee (obviously)
     *
     */
    public function store(Request $request, Event $event)
    {
        $attendee = $this->loadRelationships(
            $event->attendees()->create([
                'user_id' => 1
            ])
        );

        return new AttendeeResource($attendee);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, Attendee $attendee)
    {
        return new AttendeeResource($this->loadRelationships($attendee));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, Attendee $attendee)
    {
        $attendee->delete();

        return response(status: 204);
    }
}
