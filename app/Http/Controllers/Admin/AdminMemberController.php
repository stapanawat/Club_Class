<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminMemberController extends Controller
{
    // 🧡 หน้าแสดงสมาชิกทั้งหมดที่รออนุมัติ
    public function index()
    {
        $pending = User::where('membership_status', 'pending')->get();
        $active  = User::where('membership_status', 'active')->get();

        return view('admin.members.index', [
            'pendingMembers' => $pending,
            'activeMembers'  => $active,
        ]);
    }

    // 🟢 อนุมัติสมาชิก
    public function approve(User $user)
    {
        $user->update([
            'membership_status' => 'active',
        ]);

        return back()->with('success', 'อนุมัติสมาชิกเรียบร้อยแล้ว');
    }

    // 🔴 ปฏิเสธ / ยกเลิกสมาชิก
    public function reject(User $user)
    {
        $user->update([
            'membership_status' => 'visitor', // หรือ 'rejected' ถ้าต้องการเก็บสถานะ
        ]);

        return back()->with('success', 'ปฏิเสธคำขอสมาชิกเรียบร้อยแล้ว');
    }
}
