<?php

namespace App\Http\Controllers;
use App\Http\Controllers\EventController;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;

class AdminController extends Controller
{
    public function AdminDashboard(Request $Request)

    {
        $users = User::all();
        $events = Event::latest()->paginate(6); 
        return view('admin.admin_dashboard', compact('users','events'));
    }

    public function dashboard()
    {
        $events = Event::latest()->get(); // Fetch the latest events
        return view('admin.dashboard', compact('events'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:user,admin,super_admin',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'User role updated successfully!');
    }

    public function index()
    {
        $events = Event::latest()->get(); // Fetch latest events
        return view('home', compact('events'));
    }
}
