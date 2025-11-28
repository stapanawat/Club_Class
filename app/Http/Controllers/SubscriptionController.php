<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * ผู้ใช้เลือกแพ็กเกจ → ตั้งสถานะ pending
     */
    public function start(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|string|max:50',
        ]);

        $user = $request->user();

        // ตั้งสถานะเป็น pending
        $user->membership_status = 'pending';
        $user->selected_plan = $request->plan_id;

        $user->save();

        return response()->json([
            'message' => 'Subscription request pending.',
            'status' => $user->membership_status,
            'plan' => $user->selected_plan,
        ]);
    }
}
