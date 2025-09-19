<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false; // sandbox dulu
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    public function createTransaction($booking, $orderId)
    {
        $params = [
            'transaction_details' => [
                'order_id'      => $orderId,
                'gross_amount'  => $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => $booking->guest_name,
                'email'      => $booking->guest_email,
                'phone'      => $booking->guest_phone,
            ]
        ];

        return Snap::getSnapToken($params);
    }
}
