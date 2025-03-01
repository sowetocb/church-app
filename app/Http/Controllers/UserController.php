<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Event;

class UserController extends Controller
{
    public function UserDashboard(Request $request)

    {
        $events = Event::latest()->paginate(6);

       return view('user.user_dashboard',compact('events'));
    }

   
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,admin,super_admin'
        ]);

        $user->role = $request->input('role');
        $user->save();

        return Redirect::back()->with('status', 'User role updated.');
    }

    public function destroy(User $user)
    {
        // Prevent deleting your own account (optional)
        if(auth()->id() === $user->id) {
            return Redirect::back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();
        return Redirect::back()->with('status', 'User deleted.');
    }
}
