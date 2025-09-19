<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Notification;
use App\Models\Payment;
use App\Models\Booking;

class MidtransController extends Controller
{
    public function notification(Request $request)
    {
        $notif = new Notification();

        $payment = Payment::where('order_id', $notif->order_id)->first();

        if ($payment) {
            $payment->update([
                'transaction_id'      => $notif->transaction_id,
                'payment_type'        => $notif->payment_type,
                'transaction_status'  => $notif->transaction_status,
                'fraud_status'        => $notif->fraud_status,
                'raw_response'        => json_encode($notif),
            ]);

            $booking = $payment->booking;

            // ✅ kondisi sukses payment
            if (
                $notif->transaction_status == 'settlement' ||
                ($notif->transaction_status == 'capture' && $notif->fraud_status == 'accept')
            ) {
                $booking->update(['status' => 'complete']);
                $payment->update(['transaction_status' => 'success']);
            } elseif ($notif->transaction_status == 'pending') {
                $booking->update(['status' => 'pending']);
            } elseif (in_array($notif->transaction_status, ['deny', 'cancel', 'expire'])) {
                $booking->update(['status' => 'canceled']);
                $payment->update(['transaction_status' => 'failed']);
            }
        }

        return response()->json(['success' => true]);
    }
}
