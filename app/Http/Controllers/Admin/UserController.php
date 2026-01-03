<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Client;
use App\Models\Handyman;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display all users with filtering
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by role
        if ($request->has('role') && $request->role !== '') {
            $query->where('role', $request->role);
        }

        // Filter by search
        if ($request->has('search') && $request->search) {
            $query->where('email', 'like', "%{$request->search}%")
                  ->orWhere('fname', 'like', "%{$request->search}%")
                  ->orWhere('lname', 'like', "%{$request->search}%");
        }

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('email_verified_at', '!=', null);
            } elseif ($request->status === 'inactive') {
                $query->where('email_verified_at', null);
            }
        }

        $users = $query->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show user details
     */
    public function show($id)
    {
        $user = User::with(['client', 'handyman'])->findOrFail($id);
        $client = $user->client;
        $handyman = $user->handyman;

        return view('admin.users.show', compact('user', 'client', 'handyman'));
    }

    /**
     * Edit user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
            'role' => 'required|in:user,admin',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.show', $id)
                       ->with('success', 'User updated successfully');
    }

    /**
     * Delete user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
                       ->with('success', 'User deleted successfully');
    }

    /**
     * Ban/Unban user
     */
    public function toggleBan($id)
    {
        $user = User::findOrFail($id);
        $user->is_banned = !$user->is_banned;
        $user->save();

        $status = $user->is_banned ? 'banned' : 'unbanned';

        return redirect()->back()->with('success', "User {$status} successfully");
    }

    /**
     * Export users to CSV
     */
    public function export()
    {
        $users = User::all();
        $filename = 'users_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Email', 'Phone', 'Role', 'Created At']);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->fname . ' ' . $user->lname,
                    $user->email,
                    $user->phone_number,
                    $user->role,
                    $user->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
