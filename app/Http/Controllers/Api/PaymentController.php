<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'order_ref' => 'required|string',
            'payment_method' => 'required',
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $validated['amount'] * 100, // amount in cents
                'currency' => 'lkr',
                'description' => 'kELANI FABRICS ORDER: ' . $validated['order_ref'],
                'automatic_payment_methods' => ['enabled' => true],
            ]);

            return response()->json([
                 'clientSecret' => $paymentIntent->client_secret,
                 'order_ref' => $validated['order_ref'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }


 
}
