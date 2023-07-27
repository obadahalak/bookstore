<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        
        $generalRules=[
            'email'=>['required','email','unique:users,email','max:255'],
            'password'=>['required','min:6','max:30'],
            'name'=>['required','alpha_dash','min:3','max:255'],
            'bio'=>['sometimes','max:255'], 
            'new_password'=>['sometimes','min:6','max:30','confirmed'], 
            'image'=>['sometimes','image','max:5000'],
        ];
      
       if($this->routeIs('user.login')){
        
        $generalRules['email'][2]='exists:users,email';
        
        return array_slice($generalRules,0,2);
       }
       if($this->routeIs('user.update')){
           $generalRules['type']=['nullable',Rule::in('author','user')];
        $generalRules['Author_type']=[Rule::RequiredIf(auth()->user()->tokenCan('Author'))];
        $generalRules['email'][2]='unique:users,email,'.auth()->id();
        $generalRules['password'][0]= 'sometimes'; // old password
        $generalRules['password'][1]= 'current_password'; // old password
        return $generalRules;

       }
       if($this->routeIs('user.forgetPassword')){
        $generalRules['email'][2]='';
        return array_slice($generalRules,0,1);
       }
       if($this->routeIs('user.verifyCode')){


        return [
           
            'token'=>['required','bail',function($attribute,$value,$fail){
              
                    if(!User::Where('rest_token',$value)->where('reset_token_expiration','>',now())->first()){
                       $fail('Token invalid or expired');
                    }
            }],
            'password'=>['required','min:6','max:30','confirmed'],
        ];
        
        
       

    }
        if($this->routeIs('user.register'))
            return $generalRules;
    
}

    
    public function ValidatedData(){
        $validated=$this->validated();
        $validated['type']='user';
        return $validated;
    }
    
}
