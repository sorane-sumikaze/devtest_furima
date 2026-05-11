<?php

namespace App\Services;

use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeCheckoutService
{
    public function createSession(array $params): Session
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        return Session::create($params);
    }

    public function retrieveSession(string $sessionId): Session
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        return Session::retrieve($sessionId);
    }
}
