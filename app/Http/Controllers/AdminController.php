<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $stats = [
            'total'       => Complaint::count(),
            'pending'     => Complaint::where('status', 'pending')->count(),
            'review'      => Complaint::where('status', 'for_review')->count(),
            'resolved'    => Complaint::where('status', 'resolved')->count(),
            'rejected'    => Complaint::where('status', 'rejected')->count(),
            'total_users' => User::count(),
            'residents'   => User::role('resident')->count(),
            'staff'       => User::role('staff')->count(),
        ];

        $recent = Complaint::with('user')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        $categories = Complaint::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        return view('admin.dashboard', compact('stats', 'recent', 'categories'));
    }

    // All Complaints
    public function complaints(Request $request)
    {
        $query = Complaint::with('user')->orderBy('created_at', 'desc');

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('reference_number', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', fn($u) =>
                      $u->where('name', 'like', '%' . $request->search . '%')
                  );
            });
        }

        $complaints = $query->paginate(15)->withQueryString();

        return view('admin.complaints', compact('complaints'));
    }

    // Complaint Detail
    public function show(Complaint $complaint)
    {
        return view('admin.complaints-show', compact('complaint'));
    }

    // Update Complaint Status
    public function updateStatus(Request $request, Complaint $complaint)
{
    $request->validate([
        'status'          => 'required|in:pending,for_review,approved,rejected,scheduled,ongoing,resolved,escalated,closed',
        'category'        => 'required|string|max:255',
        'remarks'         => 'nullable|string|max:1000',
        'hearing_date'    => 'nullable|date',
        'hearing_time'    => 'nullable',
        'punong_barangay' => 'nullable|string|max:255',
    ]);

    $oldStatus = $complaint->status;

    $complaint->update([
        'status'          => $request->status,
        'category'        => $request->category,
        'remarks'         => $request->remarks,
        'hearing_date'    => $request->hearing_date,
        'hearing_time'    => $request->hearing_time,
        'punong_barangay' => $request->punong_barangay,
    ]);

    // ─── Auto Notification ───
    if ($oldStatus !== $request->status) {
        $messages = [
            'for_review' => [
                'title'   => '📋 Complaint Under Review',
                'message' => 'Your complaint ' . $complaint->reference_number . ' is now being reviewed by the Barangay.',
                'type'    => 'info',
            ],
            'scheduled' => [
                'title'   => '📅 Hearing Scheduled',
                'message' => 'Your complaint ' . $complaint->reference_number . ' has a hearing scheduled on ' .
                             ($request->hearing_date ? \Carbon\Carbon::parse($request->hearing_date)->format('F d, Y') : 'a date to be confirmed') .
                             ($request->hearing_time ? ' at ' . \Carbon\Carbon::parse($request->hearing_time)->format('h:i A') : '') . '. Please appear at the Barangay Hall.',
                'type'    => 'info',
            ],
            'ongoing' => [
                'title'   => '⚖️ Mediation Ongoing',
                'message' => 'The mediation process for your complaint ' . $complaint->reference_number . ' is now ongoing.',
                'type'    => 'info',
            ],
            'approved' => [
                'title'   => '✅ Complaint Approved',
                'message' => 'Your complaint ' . $complaint->reference_number . ' has been approved and referred to the Pangkat ng Tagapagkasundo.',
                'type'    => 'success',
            ],
            'resolved' => [
                'title'   => '🎉 Complaint Resolved',
                'message' => 'Your complaint ' . $complaint->reference_number . ' has been successfully resolved. Thank you for using BlotterLink.',
                'type'    => 'success',
            ],
            'rejected' => [
                'title'   => '❌ Complaint Rejected',
                'message' => 'Your complaint ' . $complaint->reference_number . ' has been rejected.' .
                             ($request->remarks ? ' Reason: ' . $request->remarks : ''),
                'type'    => 'danger',
            ],
            'escalated' => [
                'title'   => '⚠️ Case Escalated',
                'message' => 'Your complaint ' . $complaint->reference_number . ' has been escalated and may now be filed in court/government office.',
                'type'    => 'warning',
            ],
            'closed' => [
                'title'   => '🔒 Case Closed',
                'message' => 'Your complaint ' . $complaint->reference_number . ' has been officially closed.',
                'type'    => 'info',
            ],
        ];

        if (isset($messages[$request->status])) {
            \App\Models\ComplaintNotification::create([
                'user_id'      => $complaint->user_id,
                'complaint_id' => $complaint->id,
                'title'        => $messages[$request->status]['title'],
                'message'      => $messages[$request->status]['message'],
                'type'         => $messages[$request->status]['type'],
            ]);
        }
    }

    return back()->with('success', 'Complaint ' . $complaint->reference_number . ' updated to ' . strtoupper($request->status) . '.');
}

    // Manage Users
    public function users(Request $request)
    {
        $query = User::with('roles')->orderBy('created_at', 'desc');

        if ($request->role && $request->role !== 'all') {
            $query->role($request->role);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
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

        return back()->with('success', $user->name . "'s role updated to " . $request->role . ".");
    }

    // Toggle Verify User
    public function toggleVerify(User $user)
    {
        if ($user->email_verified_at) {
            $user->update(['email_verified_at' => null]);
            $msg = $user->name . ' has been unverified.';
        } else {
            $user->update(['email_verified_at' => now()]);
            $msg = $user->name . ' has been verified.';
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
            'total'     => Complaint::count(),
            'pending'   => Complaint::where('status', 'pending')->count(),
            'review'    => Complaint::where('status', 'for_review')->count(),
            'resolved'  => Complaint::where('status', 'resolved')->count(),
            'rejected'  => Complaint::where('status', 'rejected')->count(),
            'scheduled' => Complaint::where('status', 'scheduled')->count(),
            'ongoing'   => Complaint::where('status', 'ongoing')->count(),
            'escalated' => Complaint::where('status', 'escalated')->count(),
            'closed'    => Complaint::where('status', 'closed')->count(),
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

        return view('admin.analytics', compact('stats', 'categories', 'monthly'));
    }

    // ─── PDF FORM GENERATORS ───

    public function formComplainant(Complaint $complaint)
    {
        $pdf = Pdf::loadView('admin.forms.form7', compact('complaint'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('KP-Form-7-' . $complaint->reference_number . '.pdf');
    }

    public function formNoticeHearing(Complaint $complaint)
    {
        $pdf = Pdf::loadView('admin.forms.form8', compact('complaint'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('KP-Form-8-' . $complaint->reference_number . '.pdf');
    }

    public function formSummons(Complaint $complaint)
    {
        $pdf = Pdf::loadView('admin.forms.form9', compact('complaint'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('KP-Form-9-' . $complaint->reference_number . '.pdf');
    }

    public function formSettlement(Complaint $complaint)
    {
        $pdf = Pdf::loadView('admin.forms.form16', compact('complaint'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('KP-Form-16-' . $complaint->reference_number . '.pdf');
    }

    public function formCFA(Complaint $complaint)
    {
        $pdf = Pdf::loadView('admin.forms.form22', compact('complaint'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('KP-Form-22-' . $complaint->reference_number . '.pdf');
    }
    public function formPangkat(Complaint $complaint)
    {
        $pdf = Pdf::loadView('admin.forms.form10', compact('complaint'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('KP-Form-10-' . $complaint->reference_number . '.pdf');
    }

    public function formPangkatMember(Complaint $complaint)
    {
        $pdf = Pdf::loadView('admin.forms.form11', compact('complaint'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('KP-Form-11-' . $complaint->reference_number . '.pdf');
    }

    public function formSubpoena(Complaint $complaint)
    {
        $pdf = Pdf::loadView('admin.forms.form13', compact('complaint'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('KP-Form-13-' . $complaint->reference_number . '.pdf');
    }

    public function formArbitration(Complaint $complaint)
    {
        $pdf = Pdf::loadView('admin.forms.form14', compact('complaint'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('KP-Form-14-' . $complaint->reference_number . '.pdf');
    }

    public function formArbitrationAward(Complaint $complaint)
    {
        $pdf = Pdf::loadView('admin.forms.form15', compact('complaint'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('KP-Form-15-' . $complaint->reference_number . '.pdf');
    }

    public function formNoticeComplainant(Complaint $complaint)
    {
        $pdf = Pdf::loadView('admin.forms.form18', compact('complaint'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('KP-Form-18-' . $complaint->reference_number . '.pdf');
    }

    public function formNoticeRespondent(Complaint $complaint)
    {
        $pdf = Pdf::loadView('admin.forms.form19', compact('complaint'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('KP-Form-19-' . $complaint->reference_number . '.pdf');
    }

    public function formCFALupon(Complaint $complaint)
    {
        $pdf = Pdf::loadView('admin.forms.form20', compact('complaint'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('KP-Form-20-' . $complaint->reference_number . '.pdf');
    }

    public function formMotionExecution(Complaint $complaint)
    {
        $pdf = Pdf::loadView('admin.forms.form25', compact('complaint'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('KP-Form-25-' . $complaint->reference_number . '.pdf');
    }

    public function formNoticeExecution(Complaint $complaint)
    {
        $pdf = Pdf::loadView('admin.forms.form27', compact('complaint'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('KP-Form-27-' . $complaint->reference_number . '.pdf');
    }
}