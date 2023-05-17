<?php
namespace App\Actions;

use App\Interfaces\PaymentMethods;

class PayPalMethod implements PaymentMethods{
    
    public function  pay(){
        return 'paypal';
    }
}