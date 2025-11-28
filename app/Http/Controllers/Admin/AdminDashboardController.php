<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ตัวเลขสรุป
        $contentCount   = Content::count();
        $activeMembers  = User::where('membership_status', 'active')->count();
        $pendingMembers = User::where('membership_status', 'pending')->count();

        // ตัวเลขวันนี้ (ถ้ายังไม่มี Payment ให้คอมเมนต์สองบรรทัดนี้ทิ้งก่อนได้)
        $newMembersToday   = User::whereDate('created_at', today())->count();
        $paymentsToday     = Payment::whereDate('created_at', today())->sum('amount');

        // รายการล่าสุด
        $latestContents = Content::with('category')
            ->latest()
            ->take(5)
            ->get();

        $latestMembers = User::latest()
            ->take(5)
            ->get();

        $latestPayments = Payment::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'contentCount',
            'activeMembers',
            'pendingMembers',
            'newMembersToday',
            'paymentsToday',
            'latestContents',
            'latestMembers',
            'latestPayments'
        ));
    }
}
