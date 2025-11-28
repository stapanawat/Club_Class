<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    // 🧾 หน้าแสดงคำขอสมาชิก + ประวัติล่าสุด
    public function index()
    {
        // คำขอที่ยัง pending
        $pendingPayments = Payment::with('user')
            ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->get();

        // ประวัติที่อนุมัติ/ปฏิเสธ ล่าสุดนิดหน่อย
        $recentPayments = Payment::with('user')
            ->whereIn('status', ['approved', 'rejected'])
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get();

        return view('admin.payments.index', compact('pendingPayments', 'recentPayments'));
    }

    // ✅ อนุมัติ
    public function approve(Payment $payment)
    {
        // กันเคสกดซ้ำ
        if ($payment->status !== 'pending') {
            return back()->with('error', 'คำขอนี้ถูกจัดการไปแล้ว');
        }

        // เปลี่ยนสถานะ payment
        $payment->update([
            'status' => 'approved',
            'notes'  => trim(($payment->notes ?? '') . "\nApproved at " . now()),
        ]);

        // เปลี่ยนสถานะ user -> active
        if ($payment->user) {
            $payment->user->update([
                'membership_status' => 'active',
            ]);
        }

        return back()->with('status', 'อนุมัติสมาชิกเรียบร้อยแล้ว');
    }

    // ❌ ปฏิเสธ
    public function reject(Request $request, Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->with('error', 'คำขอนี้ถูกจัดการไปแล้ว');
        }

        $reason = $request->input('reason');

        $payment->update([
            'status' => 'rejected',
            'notes'  => trim(($payment->notes ?? '') . "\nRejected at " . now() . ($reason ? " | Reason: {$reason}" : "")),
        ]);

        // ถ้า user ยัง pending ให้ revert กลับ visitor
        if ($payment->user && $payment->user->membership_status === 'pending') {
            $payment->user->update([
                'membership_status' => 'visitor',
            ]);
        }

        return back()->with('status', 'ปฏิเสธคำขอสมาชิกเรียบร้อยแล้ว');
    }
}
