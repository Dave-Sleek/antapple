<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    // Display all users
    public function index(Request $request)
    {
        $query = User::query();

        // 🔍 Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 📌 Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // 🗓️ Filter by join date
        if ($request->filled('joined')) {
            switch ($request->joined) {
                case 'today':
                    $query->whereDate('created_at', now());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month);
                    break;
                case 'year':
                    $query->whereYear('created_at', now()->year);
                    break;
            }
        }

        // 🔄 Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                default: // newest
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // 📊 Paginate and keep filters in pagination links
        $users = $query->paginate(10)->appends($request->query());

        // If you still want employer stats:
        $employers = User::where('role', 'employer')->latest()->paginate(10);
        $totalEmployers = User::where('role', 'employer')->count();

        return view('admin.users.index', compact('users', 'employers', 'totalEmployers'));
    }


    // Show create user form
    public function create()
    {
        $roles = ['admin', 'editor'];
        return view('admin.users.create', compact('roles'));
    }

    public function show(User $user)
    {

        $subscription = $user->subscription;

        $expiresAt = $subscription?->ends_at;

        $daysLeft = $expiresAt ? now()->diffInDays($expiresAt, false) : null;
        // Optional: load relationships
        $user->load(['jobs', 'subscription']);

        return view('admin.users.show', compact('user', 'expiresAt', 'daysLeft'));
    }

    // Store new user
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:admin,editor',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'User created.');
    }

    // Show edit form
    public function edit(User $user)
    {
        $roles = ['admin', 'editor', 'employer'];
        return view('admin.users.edit', compact('user', 'roles'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
            'role' => 'required|in:admin,editor',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($data['password'] ?? false) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated.');
    }

    // Delete user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }


    public function employers(Request $request)
    {
        $query = User::where('role', 'employer');

        // 🔎 Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // 📌 Filter by status
        if ($request->status !== null) {
            $query->where('is_active', $request->status);
        }

        // 📅 Filter by date range
        if ($request->from && $request->to) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        $employers = $query->latest()->paginate(10);

        // 📊 Chart Data
        $activeCount = User::where('role', 'employer')->where('is_active', true)->count();
        $suspendedCount = User::where('role', 'employer')->where('is_active', false)->count();

        // Monthly Growth
        $monthlyGrowth = User::where('role', 'employer')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        return view('admin.users.employers', compact(
            'employers',
            'activeCount',
            'suspendedCount',
            'monthlyGrowth'
        ));
    }


    public function exportEmployers()
    {
        $employers = User::where('role', 'employer')->get();

        $filename = "employers.csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($employers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Name', 'Email', 'Status', 'Joined']);

            foreach ($employers as $user) {
                fputcsv($file, [
                    $user->name,
                    $user->email,
                    $user->is_active ? 'Active' : 'Suspended',
                    $user->created_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function suspend(User $user)
        {
            $user->update(['is_active' => false]);

            // Disable all their jobs
            $user->jobs()->update([
                'status' => 'inactive'
            ]);

            // Disable opportunities (if applicable)
            $user->opportunities()->update([
                'status' => 'inactive'
            ]);

            return back()->with('success', 'Employer suspended successfully.');
        }

    public function unsuspend(User $user)
        {
            $user->update([
                'is_active' => true
            ]);

            // Reactivate jobs
            $user->jobs()->where('status', 'inactive')->update([
                    'status' => 'active'
                ]);

            // Reactivate opportunities
            $user->opportunities()->where('status', 'inactive')->update([
                'status' => 'active'
            ]);

            return back()->with('success', 'Employer unsuspended successfully.');
        }
}
