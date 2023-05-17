<?php
namespace App\Actions;

use App\Interfaces\PaymentMethods;

class MasterMethod implements PaymentMethods{
    
    public function  pay(){
        return 'MasterMethod';
    }



}