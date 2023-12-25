<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;

class AffiliateCreateException extends \RuntimeException
{
    public function report()
    {
        Log::error('AffiliateCreateException: ' . $this->getMessage());
    }

    public function render($request)
    {
        return response()->view('errors.affiliate_create', ['message' => $this->getMessage()], 500);
    }
}
