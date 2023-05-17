<?php

namespace App\Http\Services;

use App\Interfaces\PaymentMethods;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Storage;

class PaymentService {

  public function payment(PaymentMethods $PaymentMethods){
            dd($PaymentMethods->pay());
    }  
}