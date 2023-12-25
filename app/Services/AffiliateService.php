<?php

namespace App\Services;

use App\Exceptions\AffiliateCreateException;
use App\Mail\AffiliateCreated;
use App\Models\Affiliate;
use App\Models\Merchant;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Spatie\FlareClient\Api;

class AffiliateService
{
    public function __construct(
        protected ApiService $apiService
    ) {
    }

    /**
     * Create a new affiliate for the merchant with the given commission rate.
     *
     * @param  Merchant $merchant
     * @param  string $email
     * @param  string $name
     * @param  float $commissionRate
     * @return Affiliate
     */
    public function register(Merchant $merchant, string $email, string $name, float $commissionRate): Affiliate
    {
        // Check if the email is already in use
        $existingUser = User::where('email', $email)->first();

        if ($existingUser) {
            if ($existingUser->type === 'merchant') {
                throw new AffiliateCreateException("Email is already in use by a merchant");
            } elseif ($existingUser->type === 'affiliate') {
                throw new AffiliateCreateException("Email is already in use by an affiliate");
            }
        }
        
        $discount = $this->apiService->createDiscountCode($merchant);
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => '11111111',
            'type' => User::TYPE_MERCHANT
        ]);

        $affiliate = new Affiliate();
        $affiliate->user_id = $user->id;
        $affiliate->merchant_id = $merchant->id;
        $affiliate->commission_rate = $commissionRate;
        $affiliate->discount_code = $discount['code'];
        $affiliate->save();

        Mail::to($affiliate->user->email)
            ->send(new AffiliateCreated($affiliate));
        return $affiliate;
    }
}