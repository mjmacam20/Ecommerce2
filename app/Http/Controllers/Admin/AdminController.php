<?php
namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Vendor;
use App\Models\Country;
use App\Models\VendorsBusinessDetail;
use App\Models\VendorsBankDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Mail;
use Hash;
use Auth;
use Session;

class AdminController extends Controller
{
    public function dashboard(){
        Session::put('page','sections');
        return view("admin.dashboard");
    }

    public function updateAdminPassword(Request $request){

        if($request->isMethod("post")){
            $data = $request->all();

            if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){

                if($data['confirm_password']==$data['new_password']){
                    Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_password'])]);
                    return redirect()->back()->with('success_message','Password has been updated successfully!');
                }
                else{
                    return redirect()->back()->with('error_message','New Password and Confirm Password does not match!');
                }
            }
            else{
                return redirect()->back()->with('error_message','Your current password is incorrect!');
            }
        }
        $adminDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first()->toArray();
            return view ('admin.settings.update_admin_password')->with(compact('adminDetails'));
    }

    public function updateAdminDetails(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric',
            ];

            $customMessages = [
                'admin_name.required' => 'Name is required',
                'admin_name.regex' => 'Valid Name is required',
                'admin_mobile.required' => 'Mobile is required',
                'admin_mobile.numeric' => 'Valid Mobile is required',
            ];

            $this->validate($request,$rules,$customMessages);
            //upload admin photo
            if($request->hasFile('admin_image')){
                $image_tmp = $request->file('admin_image');
                if($image_tmp->isValid()){
                    // Get image extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate new image
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'admin/images/photos/'.$imageName;
                    //upload Image
                    Image::make($image_tmp)->save($imagePath);
                }
            }else if (!empty($data['current_admin_image'])){
                $imageName = $data['current_admin_image'];
            }else{
                $imageName = "";
            }
            //update admin details
           Admin::where('id',Auth::guard('admin')->user()->id)->update(['name'=>$data['admin_name'],'mobile'=>$data['admin_mobile'],'image'=>$imageName]);
           return redirect()->back()->with('success_message','Admin details updated successfully!');
        }
        return view('admin.settings.update_admin_details');
    }

    public function checkAdminPassword(Request $request){
        $data = $request->all();
        if (Hash::check($data['current_password'],Auth::guard('admin')->user()->password)) {
            return 'true';
        }else{
            return 'false';
        }
    }

    /*Update Vendor Details*/
    public function updateVendorDetails($slug, Request $request){
        if($slug=="personal"){
            if($request->isMethod('post')){
                $data = $request->all();
                
                    $rules = [
                        'vendor_name' => 'required|regex:/^[\pL\s\-]+$/u',
                        'vendor_city' => 'required|regex:/^[\pL\s\-]+$/u',
                        'vendor_mobile' => 'required|numeric',
                    ];
        
                    $customMessages = [
                        'vendor_name.required' => 'Name is required',
                        'vendor_city.required' => 'Name is required',
                        'vendor_name.regex' => 'Valid Name is required',
                        'vendor_city.regex' => 'Valid City is required',
                        'vendor_mobile.required' => 'Mobile is required',
                        'vendor_mobile.numeric' => 'Valid Mobile is required',
                    ];
    
                    $this->validate($request,$rules,$customMessages);

                    $vendorCount = Vendor::where('id', Auth::guard('admin')->user()->vendor_id)->count();
                //upload admin photo
                    if($request->hasFile('vendor_image')){
                        $image_tmp = $request->file('vendor_image');
                        if($image_tmp->isValid()){
                            // Get image extension
                            $extension = $image_tmp->getClientOriginalExtension();
                            // Generate new image
                            $imageName = rand(111,99999).'.'.$extension;
                            $imagePath = 'admin/images/photos/'.$imageName;
                            //upload Image
                            Image::make($image_tmp)->save($imagePath);
                        }
                    }else if (!empty($data['current_vendor_image'])){
                        $imageName = $data['current_vendor_image'];
                    }else{
                        $imageName = "";
                    }
                    //update in admins table
                    Admin::where('id',Auth::guard('admin')->user()->id)->update(['name'=>$data['vendor_name'],'mobile'=>$data['vendor_mobile'],'image'=>$imageName]);
                    //update in vendors table
                  
                    //dd($data);
                    //iniba ko
                    Vendor::updateOrInsert(['id' => Auth::guard('admin')->user()->vendor_id],
                        [
                            'name' => $data['vendor_name'],
                            'mobile' => $data['vendor_mobile'],
                            'address' => $data['vendor_address'],
                            'city' => $data['vendor_city'],
                            'state' => $data['vendor_state'],
                            'country' => $data['vendor_country'],
                            'zipcode' => $data['vendor_zipcode']
                        ]
                    );
                    
                    return redirect()->back()->with('success_message','Vendor details updated successfully!');
        }
        // Checking if the value is null  Handle the case when $vendorDetails is null
            $vendorCount = Vendor::where('id',Auth::guard('admin')->user()->vendor_id)->count();
            if ($vendorCount>0) {
                $vendorDetails = Vendor::where('id',Auth::guard('admin')->user()->vendor_id)->first();
            } else {
                $vendorDetails = array();
            }
        }
        else if($slug=="business"){
            if($request->isMethod('post')){
                $data = $request->all();
                //echo "<pre>"; print_r($data); die;
                    $rules = [
                        'shop_name' => 'required|regex:/^[\pL\s\-]+$/u',
                        'shop_city' => 'required|regex:/^[\pL\s\-]+$/u',
                        'shop_mobile' => 'required|numeric',
                        'address_proof'=> 'required',
                    ];
        
                    $customMessages = [
                        'shop_name.required' => 'Name is required',
                        'shop_city.required' => 'Name is required',
                        'shop_name.regex' => 'Valid Name is required',
                        'shop_city.regex' => 'Valid City is required',
                        'shop_mobile.required' => 'Mobile is required',
                        'shop_mobile.numeric' => 'Valid Mobile is required',
                    ];
    
                    $this->validate($request,$rules,$customMessages);
                //upload admin photo
                    if($request->hasFile('address_proof_image')){
                        $image_tmp = $request->file('address_proof_image');
                        if($image_tmp->isValid()){
                            // Get image extension
                            $extension = $image_tmp->getClientOriginalExtension();
                            // Generate new image
                            $imageName = rand(111,99999).'.'.$extension;
                            $imagePath = 'admin/images/proofs/'.$imageName;
                            //upload Image
                            Image::make($image_tmp)->save($imagePath);
                        }
                    }else if (!empty($data['current_address_proof'])){
                        $imageName = $data['current_address_proof'];
                    }else{
                        $imageName = "";
                    }
                    $vendorCount =  VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
                        if($vendorCount>0){
                             //update in vendors_business_details table
                            VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update(['shop_name'=>$data['shop_name'],'shop_mobile'=>$data['shop_mobile'],'shop_address'=>$data['shop_address'],'shop_city'=>$data['shop_city'],'shop_state'=>$data['shop_state'],'shop_country'=>$data['shop_country'],'shop_zipcode'=>$data['shop_zipcode'],'business_license_number'=>$data['business_license_number'],'gst_number'=>$data['gst_number'],'pan_number'=>$data['pan_number'],'address_proof'=>$data['address_proof'],'address_proof_image'=>$imageName]);
                        }else{
                            //update in vendors_business_details table
                            VendorsBusinessDetail::insert(['vendor_id'=>Auth::guard('admin')->user()->vendor_id,'shop_name'=>$data['shop_name'],'shop_mobile'=>$data['shop_mobile'],'shop_address'=>$data['shop_address'],'shop_city'=>$data['shop_city'],'shop_state'=>$data['shop_state'],'shop_country'=>$data['shop_country'],'shop_zipcode'=>$data['shop_zipcode'],'business_license_number'=>$data['business_license_number'],'gst_number'=>$data['gst_number'],'pan_number'=>$data['pan_number'],'address_proof'=>$data['address_proof'],'address_proof_image'=>$imageName]);
                        }

                    return redirect()->back()->with('success_message','Vendor details updated successfully!');
        }
            $vendorCount = VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
            if ($vendorCount>0) {
                $vendorDetails = VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->first();
            } else {
                $vendorDetails = array();
            }
        }
        else if($slug=="bank"){
            if($request->isMethod('post')){
                $data = $request->all();
                
                    $rules = [
                        'account_holder_name' => 'required|regex:/^[\pL\s\-]+$/u',
                        'bank_name' => 'required',
                        'account_number' => 'required|numeric',
                        'bank_ifsc_code'=> 'required',
                    ];
        
                    $customMessages = [
                        'account_holder_name.required' => 'Account holder name is required',
                        'account_holder_name.regex' => 'Account holder name is required',
                        'bank_name.required' => 'Bank name is required',
                        'account_number.required' => 'Account Number is required',
                        'account_number.numeric' => 'Valid Account Number is required',
                        'bank_ifsc_code.required' => 'Bank Code is required',
                    ];
    
                    $this->validate($request,$rules,$customMessages);
                    $vendorCount = VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
                    if ($vendorCount>0) {
                    //update in vendors_business_details table
                        VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update(['account_holder_name'=>$data['account_holder_name'],'bank_name'=>$data['bank_name'],'account_number'=>$data['account_number'],'bank_ifsc_code'=>$data['bank_ifsc_code']]);
                    }else{
                        VendorsBankDetail::insert(['vendor_id'=>Auth::guard('admin')->user()->vendor_id,'account_holder_name'=>$data['account_holder_name'],'bank_name'=>$data['bank_name'],'account_number'=>$data['account_number'],'bank_ifsc_code'=>$data['bank_ifsc_code']]);
                    }
                    return redirect()->back()->with('success_message','Vendor details updated successfully!');
                }
                // Handle the case when $vendorDetails is null
                $vendorCount = VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
                if ($vendorCount>0) {
                    $vendorDetails = VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->first();
                } else {
                    $vendorDetails = array();
                }
        }
        $countries = Country::where('status',1)->get()->toArray();
        return view('admin.settings.update_vendor_details')->with(compact('slug','vendorDetails','countries'));
    }

    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            /*echo "<pre>"; print_r($data); die;*/
            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];

            $customMessages = [
                'email.required' => 'Email Address is required',
                'email.email' => 'Email Address in required',
                'password.required' => 'Password is required',
            ];

            $this -> validate($request, $rules, $customMessages);

            /*if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password'],'status'=>1])){
                return redirect('admin/dashboard');
            }
            else{
                return redirect()->back()->with('error_message','Invalid Email or Password');
            }*/

            if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']])){
                if(Auth::guard('admin')->user()->type=="vendor" && Auth::guard('admin')->user()->confirm=="No"){
                    return redirect()->back()->with('error_message','Please confirm your email to activate your Vendor Account.');

                }else if(Auth::guard('admin')->user()->type!="vendor" && Auth::guard('admin')->user()->status=="0"){
                    return redirect()->back()->with('error_message','Your admin account is not active');

                }else{
                    return redirect('admin/dashboard');
                }
            }
            else{
                return redirect()->back()->with('error_message','Invalid Email or Password');
            }
        }
        return view("admin.login");
    }
    public function admins($type=null){
        $admins = Admin::query();
        if(!empty($type)){
            $admins = $admins->where('type',$type);   
            $title = ucfirst($type)."s";
        }else{
            $title = "All Admin/Subadmin/Vendors";       
        }
            
        $admins = $admins->get()->toArray();
        return view('admin.admins.admins')->with(compact('admins','title'));
    }

    public function viewVendorDetails($id){
        $vendorDetails = Admin::with(['vendorPersonal','vendorBusiness','vendorBank'])->where('id',$id)->first();
        $vendorDetails = json_decode(json_encode($vendorDetails),true);
        //dd($vendorDetails);
        return view('admin.admins.view_vendor_details')->with(compact('vendorDetails'));
    }

    public function updateAdminStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            
            /*echo"<pre>"; print_r($data); die;*/
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Admin::where('id',$data['admin_id'])->update(['status'=>$status]);
            $adminDetails = Admin::where('id',$data['admin_id'])->first()->toArray();
            
            if($adminDetails['type']=="vendor" && $status==1){
                
                Vendor::where('id',$adminDetails['vendor_id'])->update(['status'=>$status]);    
                    //Send Approval Email
                $email = $adminDetails['email'];
                $messageData = [
                    'email' => $adminDetails['email'],
                    'name' => $adminDetails['name'],
                    'mobile' => $adminDetails['mobile'],
                ];

                Mail::send('emails.vendor_approved',$messageData,function($message)use($email){
                    $message->to($email)->subject('Vendor Account is approve');
                });
            }
            return response()->json(['status'=> $status,'admin_id'=>$data['admin_id']]);
        }
    }
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
