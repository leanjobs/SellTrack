<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function handleMidtrans(Request $request)
    {
        try {
            Log::info('Midtrans Notification Raw:', $request->all());
            $notif = new \Midtrans\Notification();

            Log::info('Parsed Midtrans Notification:', [
                'order_id' => $notif->order_id,
                'transaction_status' => $notif->transaction_status
            ]);

            $orderId = $notif->order_id;
            $transactionStatus = $notif->transaction_status;

            $payment = Payment::where('order_id', $orderId)->first();
            if (!$payment) {
                Log::warning("Payment with order_id {$orderId} not found.");
                return response()->json(['message' => 'Payment not found'], 404);
            }

            if ($transactionStatus === 'settlement') {
                $payment->status = 'succeed';
            } elseif ($transactionStatus === 'pending') {
                $payment->status = 'waiting';
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $payment->status = 'failed';
            }

            $payment->save();

            Log::info("Payment status updated for order_id {$orderId} to {$payment->status}");
                return response()->json(['message' => 'Notification handled'], 200);
        } catch (\Exception $e) {
            Log::error('Error handling Midtrans notification: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
