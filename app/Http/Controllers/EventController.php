<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\View;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
  
    public function index(Request $request)
{
    $query = $request->input('q');

    if ($query) {
        $events = Event::where('title', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->latest()
            ->paginate(6);
    } else {
        $events = Event::latest()->paginate(6);
    }

    // Pass the query back to the view (so it remains in the search input)
    return view('event.events', compact('events'))->with('q', $query);
}

public function search(Request $request)
{
    $query = $request->input('q');
    if ($query) {
        $events = Event::where('title', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->latest()
            ->get();
    } else {
        $events = Event::latest()->get();
    }

    // Return a rendered view (partial) for AJAX response
    return view('event.events-list', compact('events'))->render();
}

    


   
public function create()
{
    return view('event.create');
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'youtube_embed_code' => 'required|string',
        'event_date' => 'required|date',
    ]);

    Event::create($request->all());

    return redirect()->route('event.create')->with('success', 'Event created successfully.');
}

public function destroy(Event $event)
{
    // Delete the event from the database
    $event->delete();

    // Redirect back to the admin events list with a success message
    return redirect()->route('event.index')->with('success', 'Event deleted successfully.');
}

}
