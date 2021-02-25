<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{

    function generateMobileOtp(Request $request){

        if($request->has('phone')){
            $check_user = Customer::where('phone',$request->phone);
            if($check_user->get()->count() > 0){
                return[
                    "status"=>0,
                    "message"=>"User Already Exist"
                ];
            }else{
                    $save_phone = new Customer;
                    $save_phone->phone = $request->phone;
                    $save_phone->otp = mt_rand(000000,999999);

                    $result = $save_phone->save();

                    if($result){
                            return[
                                "status"=>1,
                                "message"=>"Otp Generated Sucessfully"
                            ];
                    }else{
                        return[
                            "status"=>0,
                            "message"=>"Otp not Generated"
                        ];
                    }
            }
        }else{
            return[
                "status"=>0,
                "message"=>"Inavalid Credentital"
            ];
        }

    }

    function generateEmailOtp(Request $request){

        if($request->has('email')){
            $check_user = Customer::where('email_id',$request->email);
            if($check_user->get()->count() > 0){

                return[
                    "status"=>0,
                    "message"=>"User Already Does not Exist"
                ];

            }else{
                $save_email = new Customer;
                    $save_email->email_id = $request->email;
                    $save_email->otp = mt_rand(000000,999999);

                    $result = $save_email->save();

                    if($result){
                            return[
                                "status"=>1,
                                "message"=>"Otp Generated Sucessfully"
                            ];
                    }else{
                        return[
                            "status"=>0,
                            "message"=>"Otp not Generated"
                        ];
                    }
            }
        }else{
            return[
                "status"=>0,
                "message"=>"Inavalid Credentital"
            ];
        }

    }




    function register(Request $request)
    {


        if ($request->has('phone') and $request->has('otp')) {
            $check_user = Customer::where('phone',$request->phone)->where('otp',$request->otp);
            if($check_user->get()->count()>0){
                $result = $check_user->update([
                    "name"=>$request->name,
                    "email_id"=>$request->email_id,
                    "password"=>$request->password
                ]);

                if($result){
                    return[
                        "status"=>1,
                        "message"=>"Sucessfully Registered"
                    ];
                }else{
                    return[
                        "status"=>0,
                        "message"=>"Failed to Register"
                    ];
                }
            }else{
                return [
                    "status"=>0,
                    "message"=>"Mobile No not exits"
                ];
            }
        } else {
            return [
                "status" => 0,
                "message" => "Required fields are missing"
            ];
        }
    }

    function login(Request $request){

        if($request->has("phone") and $request->has("otp")){
            $user_check = Customer::where('phone',$request->phone)->where('otp',$request->otp);

            if($user_check->get()->count()){
                return[
                    "status"=>1,
                    "message"=>"User logged in sucessfully",
                    "data"=>$user_check->get()->first()
                ];
            }else{
                return[
                    "status"=>0,
                    "message"=>"Wrong Moblie or Otp"
                ];
            }

        }else{
            return[
                "status"=>0,
                "message"=>"Fiels are Missing"
            ];
        }

    }


    function getContact(Request $request){
       if($request->has('email')){
        $customer = Customer::where('email_id',$request->email);
        if($customer->get()->count()>0){
            return[
                "status"=>1,
                "message"=>"Sucess",
                "email_id"=>$customer->first()->email_id,
                "phone"=>$customer->first()->phone

            ];
        }else{
            return [
                "status"=>0,
                "message"=>"Invalid Email id"
            ];
        }

       }else{
           return [
               "status"=>0,
               "message"=>"Required Fields are missing"
           ];
       }

    }


    function updatePassword(Request $request){
        if($request->has('phone') or $request->has('email')and $request->has('otp') and $request->has('password')){

            $check_user = Customer::where('phone',$request->phone)->orWhere('email_id', $request->email);


          if($check_user->get()->count() > 0){
                $result = $check_user->update([
                    "password"=>$request->password
                ]);

                if($result){
                    return[
                        "status"=>1,
                        "message"=>"Password Changed Sucessfully"
                    ];
                }else{
                    return[
                        "status"=>0,
                        "message"=>"Please Enter new password"
                    ];
                }
          }else{
              return[
                  "status"=>0,
                  "message"=>"No Data Found"
              ];
          }
        }else{
            return [
                "status"=>0,
                "message"=>"Required Fields are missing"
            ];
        }
    }



}
