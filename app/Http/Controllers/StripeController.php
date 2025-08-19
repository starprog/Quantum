<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;

class StripeController extends Controller
{
    public function show()
    {
        return view('checkout');
    }

    public function createCheckoutSession(Request $request)
    {
        $domain = config('app.url') ?? url('/');
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = CheckoutSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Test Product',
                    ],
                    'unit_amount' => 500,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $domain . '/checkout/success',
            'cancel_url' => $domain . '/checkout/cancel',
        ]);

        return response()->json(['id' => $session->id]);
    }

    public function success()
    {
        return view('checkout-success');
    }

    public function cancel()
    {
        return view('checkout-cancel');
    }
}
