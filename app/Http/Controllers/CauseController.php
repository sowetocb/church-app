<?php

namespace App\Http\Controllers;

use App\Models\Cause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CauseController extends Controller
{
    // 1) Display causes one per page, and auto-advance after 10 seconds
    public function index()
    {
        // Show the newest cause first, one cause per page
        $causes = Cause::latest()->paginate(1);
        return view('causes.index', compact('causes'));
    }

    // 2) Show a form to create a new cause
    public function create()
    {
        return view('causes.create');
    }

    // 3) Store a newly created cause in the database
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'description']);

        if ($request->hasFile('image')) {
            // Store image in "cause_images" folder in /storage/app/public/
            $data['image'] = $request->file('image')->store('cause_images', 'public');
        }

        Cause::create($data);

        return redirect()->route('causes.create')->with('success', 'Cause created successfully!');
    }

    // 4) Delete a cause
    public function destroy(Cause $cause)
    {
         //Optionally remove the old image from storage:
         if ($cause->image) {
            Storage::disk('public')->delete($cause->image);
         }

        $cause->delete();
        return redirect()->route('donations.all')->with('success', 'Cause deleted successfully!');
    }
}
