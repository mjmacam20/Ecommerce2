<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin;
use App\Models\Vendor;
use Validator;
use DB;

class VendorController extends Controller
{
    public function loginRegister(){
        return view('front.vendors.login_register');
    }

    public function vendorRegister(Request $request){
        if($request->isMethod("post")){

            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            //Validate Vendor
            $rules = [
                "name" => "required",
                "email" => "required|email|unique:admins|unique:vendors",
                "mobile" => "required|min:11|numeric|unique:admins|unique:vendors",
                "accept" => "required"
            ];
            $customMessages = [
                "name.required" => "Name is required",
                "email.required" => "Email is required",
                "email.unique" => "Email already exists",
                "mobile.required" => "Mobile is required",
                "mobile.unique" => "Mobile already exists",
                "accept.required" => "Please accept terms and condition"
            ];
            $validator = Validator::make($data,$rules,$customMessages);
            if($validator->fails()){
                return Redirect::back()->withErrors($validator);
            }

            DB::beginTransaction();

            // Create Vendor Account

            //Insert the vendor details in vendors table
            $vendor = new Vendor;
            $vendor->name = $data['name'];
            $vendor->mobile = $data['mobile'];
            $vendor->email = $data['email'];
            $vendor->status = 0;
            $vendor->save();

            //Set timezone in Philippines 
            date_default_timezone_set("Asia/Manila");
            $vendor->created_at = date("Y-m-d H:i:s");
            $vendor->updated_at = date("Y-m-d H:i:s");
            $vendor->save();

            $vendor_id = $vendor->id;

            //Insert the vendor details in admins table
            $admin = new Admin;
            $admin->type = 'vendor';
            $admin->vendor_id = $vendor_id;
            $admin->name = $data['name'];
            $admin->mobile = $data['mobile'];
            $admin->email = $data['email'];
            $admin->password = bcrypt($data['password']);
            $admin->status = 0;
            //Set timezone in Philippines 
            date_default_timezone_set("Asia/Manila");
            $admin->created_at = date("Y-m-d H:i:s");
            $admin->updated_at = date("Y-m-d H:i:s");
            $admin->save();

            //Send Confirmation Email
            $email = $data['email'];
            $messageData = [
                'email' => $data['email'],
                'name' => $data['name'],
                'code' => base64_encode($data['email'])
            ];

            Mail::send('emails.vendor_confirmation',$messageData,function($message)use($email){
                $message->to($email)->subject('Confirm your Vendor Account');
            });
            
            DB::commit();
            //Redirect Back vendor with success message
            $message = "Thanks for Registering as Vendor. Please confirm your email to activate your account.";
            return redirect()->back()->with('success_message',$message);
        }
    }

    public function confirmVendor($email){
        // Decode Vendor Email
        $email = base64_decode($email);
        // Check Vendor Email Exists
        $vendorCount = Vendor::where('email',$email)->count();
        if($vendorCount>0){
            // Vendor Email is already activated or not
            $vendorDetails = Vendor::where('email',$email)->first();
            if($vendorDetails->confirm == "Yes"){
                $message = "Your Vendor Account is already confirmed.";
                return redirect('vendor/login-register')->with('error_message',$message);
            }else{
                // Update confirm column to Yes in both admins/ vendors table to activate the account
                Admin::where('email',$email)->update(['confirm'=>'Yes']);
                Vendor::where('email',$email)->update(['confirm'=>'Yes']);

                // Send Register Email

                //Send Confirmation Email
                $messageData = [
                'email' => $email,
                'name' => $vendorDetails->name,
                'mobile' => $vendorDetails->mobile
                ];

            Mail::send('emails.vendor_confirmed',$messageData,function($message)use($email){
                $message->to($email)->subject('Your Vendor Accoun Confirmed!');
            });

                // Redirect to vendor Login/Register page with success message
                $message = "Your Vendor email account is confirmed. You can login and add your personal, business, and bank details to activate your Vendor Account to add products.";

                return redirect('vendor/login-register')->with('success_message',$message);
            }
        }else{
            abort(404);
        }

    }
}
