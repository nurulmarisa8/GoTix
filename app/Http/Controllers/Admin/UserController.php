<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller {
    public function __construct() {
        $this->middleware('can:manage-users');
    }

    public function index() {
        $users = User::paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function approveOrganizer(User $user) {
        $user->update([
            'role' => 'organizer',
            'organizer_status' => 'approved'
        ]);
        return back()->with('success', 'Organizer approved');
    }

    public function rejectOrganizer(User $user) {
        $user->update([
            'role' => 'user',
            'organizer_status' => 'rejected'
        ]);
        return back()->with('success', 'Organizer request rejected');
    }

    public function destroy(User $user) {
        // Prevent deletion of current admin user
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
