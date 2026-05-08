<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $stats = [
            'total'       => Complaint::count(),
            'pending'     => Complaint::where('status','pending')->count(),
            'review'      => Complaint::where('status','under_review')->count(),
            'resolved'    => Complaint::where('status','resolved')->count(),
            'rejected'    => Complaint::where('status','rejected')->count(),
            'total_users' => User::count(),
            'residents'   => User::role('resident')->count(),
            'staff'       => User::role('staff')->count(),
        ];

        $recent = Complaint::with('user')
            ->orderBy('created_at','desc')
            ->take(8)
            ->get();

        $categories = Complaint::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        return view('admin.dashboard', compact('stats','recent','categories'));
    }

    // All Complaints
    public function complaints(Request $request)
    {
        $query = Complaint::with('user')->orderBy('created_at','desc');

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('reference_number','like','%'.$request->search.'%')
                  ->orWhere('category','like','%'.$request->search.'%')
                  ->orWhereHas('user', fn($u) =>
                      $u->where('name','like','%'.$request->search.'%')
                  );
            });
        }

        $complaints = $query->paginate(15)->withQueryString();

        return view('admin.complaints', compact('complaints'));
    }

    // Update Complaint Status
    public function updateStatus(Request $request, Complaint $complaint)
{
    $request->validate([
        'status'          => 'required|in:pending,for_review,approved,rejected,scheduled,ongoing,resolved,escalated,closed',
        'remarks'         => 'nullable|string|max:1000',
        'hearing_date'    => 'nullable|date',
        'hearing_time'    => 'nullable',
        'punong_barangay' => 'nullable|string|max:255',
    ]);

    $complaint->update([
        'status'          => $request->status,
        'remarks'         => $request->remarks,
        'hearing_date'    => $request->hearing_date,
        'hearing_time'    => $request->hearing_time,
        'punong_barangay' => $request->punong_barangay,
    ]);

    return back()->with('success', 'Complaint ' . $complaint->reference_number . ' updated to ' . strtoupper($request->status) . '.');
}
    // Manage Users
    public function users(Request $request)
    {
        $query = User::with('roles')->orderBy('created_at','desc');

        if ($request->role && $request->role !== 'all') {
            $query->role($request->role);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name','like','%'.$request->search.'%')
                  ->orWhere('email','like','%'.$request->search.'%');
            });
        }

        $users = $query->paginate(15)->withQueryString();

        return view('admin.users', compact('users'));
    }

    // Update User Role
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:resident,staff,admin',
        ]);

        $user->syncRoles([$request->role]);

        return back()->with('success', $user->name."'s role updated to ".$request->role.".");
    }

    // Toggle Verify User
    public function toggleVerify(User $user)
    {
        if ($user->email_verified_at) {
            $user->update(['email_verified_at' => null]);
            $msg = $user->name.' has been unverified.';
        } else {
            $user->update(['email_verified_at' => now()]);
            $msg = $user->name.' has been verified.';
        }

        return back()->with('success', $msg);
    }

    // Delete User
    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return back()->with('success', 'User removed successfully.');
    }

    // Analytics
    public function analytics()
    {
        $stats = [
            'total'    => Complaint::count(),
            'pending'  => Complaint::where('status','pending')->count(),
            'review' => Complaint::where('status','for_review')->count(),
            'resolved' => Complaint::where('status','resolved')->count(),
            'rejected' => Complaint::where('status','rejected')->count(),
        ];

        $categories = Complaint::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $monthly = Complaint::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        return view('admin.analytics', compact('stats','categories','monthly'));
    }
}