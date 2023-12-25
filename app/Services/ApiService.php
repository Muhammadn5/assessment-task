<?php

namespace App\Services;

use App\Models\Affiliate;
use App\Models\Merchant;
use Illuminate\Support\Str;
use RuntimeException;
use Stripe\Stripe;

/**
 * You don't need to do anything here. This is just to help
 */
class ApiService
{
    public function __construct()
    {
        // Set your Stripe API key here
        Stripe::setApiKey(config('services.stripe.secret'));
    }
    
    /**
     * Create a new discount code for an affiliate
     *
     * @param Merchant $merchant
     *
     * @return array{id: int, code: string}
     */
    public function createDiscountCode(Merchant $merchant): array
    {
        return [
            'id' => rand(0, 100000),
            'code' => Str::uuid()
        ];
    }

    /**
     * Send a payout to an email
     *
     * @param  string $email
     * @param  float $amount
     * @return void
     * @throws RuntimeException
     */
    public function sendPayout(string $email, float $amount)
    {
        try {
            $payout = \Stripe\Payout::create([
                'amount' => $amount * 100, // Amount in cents
                'currency' => 'usd',
                'destination' => $email,
            ]);
        } catch (\Exception $exception) {
            throw new \RuntimeException('Payout failed');
        }
    }
}