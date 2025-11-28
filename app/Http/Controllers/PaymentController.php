<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;

class PaymentController extends Controller
{
    // ... method อื่น ๆ ที่มีอยู่แล้ว

    /**
     * สมัครแพ็กเกจแบบไม่ต้องจ่ายเงินจริง
     * แค่สร้าง payment = pending + set user เป็น pending
     */
    public function mockSubscribe(Request $request)
    {
        $user = $request->user();

        // กันเผื่อยังไม่ได้ login
        if (! $user) {
            return response()->json([
                'message' => 'กรุณาเข้าสู่ระบบก่อนทำรายการ',
            ], 401);
        }

        // validate ข้อมูลจาก front (ชื่อแพ็กเกจ + ราคา)
        $data = $request->validate([
            'plan'   => ['required', 'string', 'max:50'],   // 'monthly', 'lifetime' ฯลฯ
            'amount' => ['required', 'numeric', 'min:0'],   // 0 ก็ได้
        ]);

        // สร้าง Payment สถานะ pending
        $payment = Payment::create([
            'user_id'    => $user->id,
            'amount'     => $data['amount'],
            'status'     => 'pending',          // ให้ AdminPaymentController ไป approve/ reject ต่อ
            'channel'    => 'mock',             // บอกว่าเป็น mock สมัครในระบบ
            'reference'  => 'PLAN_'.$data['plan'],
            'notes'      => 'Mock subscribe from member page (no real payment).',
        ]);

        // อัปเดตสถานะสมาชิกของ user ให้เป็น pending
        $user->membership_status = 'pending';
        $user->save();

        return response()->json([
            'message'           => 'สร้างคำขอสมัครสมาชิกเรียบร้อย กำลังรอแอดมินอนุมัติ',
            'payment_id'        => $payment->id,
            'membership_status' => $user->membership_status,
        ]);
    }
}
