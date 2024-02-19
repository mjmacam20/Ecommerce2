@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Update Vendor Details</h3>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="justify-content-end d-flex">
                            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                    <a class="dropdown-item" href="#">January - March</a>
                                    <a class="dropdown-item" href="#">March - June</a>
                                    <a class="dropdown-item" href="#">June - August</a>
                                    <a class="dropdown-item" href="#">August - November</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($slug=="personal")
        <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Update Personal Information</h4>
                      @if(Session::has('error_message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong>Error: </strong> {{ Session::get('error_message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                      @endif

                      @if(Session::has('success_message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                          <strong>Success: </strong> {{ Session::get('success_message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                      @endif

                        @if ($errors->any())
                           <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                           </div>
                        @endif

                    <form class="forms-sample" action="{{url('admin/update-vendor-details/personal') }}" method="post" enctype="multipart/form-data">@csrf
                      <div class="form-group">
                        <label>Vendor Username</label>
                        <input class="form-control" value="{{ Auth::guard('admin')->user()->email ?? ''}}" readonly="">
                      </div>
                      <div class="form-group">
                        <label for="vendor_name">Name</label>
                        <input type="text" class="form-control" id="vendor_name" placeholder="Name" name="vendor_name" value="{{ Auth::guard('admin')->user()->name }}"required="">
                      </div>
                      <div class="form-group">
                            <label for="vendor_address">Address</label>
                            <input type="text" class="form-control" id="vendor_address" placeholder="Address" name="vendor_address"  value="{{ $vendorDetails['address'] ?? ''  }}" required="" >
                        </div>
                        <div class="form-group">
                            <label for="vendor_city">City</label>
                            <input type="text" class="form-control" id="vendor_city" placeholder="City" name="vendor_city"  value="{{ $vendorDetails['city'] ?? ''  }}" required="" >
                        </div>
                        <div class="form-group">
                            <label for="vendor_state">State</label>
                            <input type="text" class="form-control" id="vendor_state" placeholder="State" name="vendor_state" value="{{ $vendorDetails['state'] ?? ''  }}" required="" >
                        </div>                     
                          <div class="form-group">
                              <label for="vendor_country">Country</label>
                              <select class="form-control" id="vendor_country" name="vendor_country" style="color: #495057">
                                  <option value="">Select Country</option>
                                  @foreach($countries as $country)
                                      <option value="{{ $country['country_name'] }}" @if($country['country_name']==($vendorDetails['country'] ?? '' )) selected @endif>
                                          {{ $country['country_name'] }}
                                      </option>
                                  @endforeach
                              </select>
                          </div>
                          
                          <div class="form-group">
                            <label for="vendor_zipcode">Zipcode</label>
                            <input type="text" class="form-control" id="vendor_zipcode" placeholder="Zipcode" name="vendor_zipcode" value="{{ $vendorDetails['zipcode'] ?? ''  }}" required="" >
                        </div>
                      <div class="form-group">
                        <label for="vendor_mobile">Mobile</label>
                        <input type="text" class="form-control" id="vendor_mobile" placeholder="Mobile" name="vendor_mobile" value="{{ Auth::guard('admin')->user()->mobile }}" maxlength="11" minlength="11" required="">
                      </div>
                      <div class="form-group">
                        <label for="vendor_image">Photo</label>
                        <input type="file" class="form-control" id="vendor_image" name="vendor_image">
                        @if(!empty(Auth::guard('admin')->user()->image))
                            <a target="_blank" href="{{ url ('admin/images/photos/'.Auth::guard('admin')->user()->image) }}">View Image</a>
                            <input type="hidden" name="current_vendor_image" value="{{ Auth::guard('admin')->user()->image }}">
                        @endif
                      </div>
                      <button type="submit" class="btn btn-primary mr-2">Submit</button>
                      <button class="btn btn-dark">Cancel</button>
                    </form>
                  </div>
                </div>
              </div>

        @elseif($slug=="business")
        <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Update Business Information</h4>
                      @if(Session::has('error_message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong>Error: </strong> {{ Session::get('error_message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                      @endif

                      @if(Session::has('success_message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                          <strong>Success: </strong> {{ Session::get('success_message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                      @endif

                        @if ($errors->any())
                           <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                           </div>
                        @endif

                    <form class="forms-sample" action="{{url('admin/update-vendor-details/business') }}" method="post" enctype="multipart/form-data">@csrf
                      <div class="form-group">
                        <label>Vendor Username</label>
                        <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="">
                      </div>
                      <div class="form-group">
                        <label for="shop_name">Shop Name</label>
                        <input type="text" class="form-control" id="shop_name" placeholder="Shop Name" name="shop_name"  @if(isset($vendorDetails['shop_name'])) value="{{ $vendorDetails['shop_name'] }}" required="" @endif >
                      </div>
                      <div class="form-group">
                        <label for="shop_address">Shop Address</label>
                        <input type="text" class="form-control" id="shop_address" placeholder="Shop Address" name="shop_address" @if(isset($vendorDetails['shop_address']))  value="{{ $vendorDetails['shop_address'] }}"required=""  @endif>
                      </div>
                      <div class="form-group">
                        <label for="shop_city">Shop City</label>
                        <input type="text" class="form-control" id="shop_city" placeholder="Shop City" name="shop_city"  @if(isset($vendorDetails['shop_city'])) value="{{ $vendorDetails['shop_city']}}"required=""  @endif>
                      </div>
                      <div class="form-group">
                        <label for="shop_state">Shop State</label>
                        <input type="text" class="form-control" id="shop_state" placeholder="Shop State" name="shop_state"  @if(isset($vendorDetails['shop_state'])) value="{{ $vendorDetails['shop_state']  }}"required=""  @endif>
                      </div>

                      <div class="form-group">
                        <label for="shop_country">Shop Country</label>
                        <select class="form-control" id="shop_country" name="shop_country" style="color: #495057">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country['country_name'] }}" @if(isset($vendorDetails['shop_country']) && $country['country_name'] == $vendorDetails['shop_country']) selected @endif>
                                    {{ $country['country_name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                      <div class="form-group">
                        <label for="shop_zipcode">Shop Zipcode</label>
                        <input type="text" class="form-control" id="shop_zipcode" placeholder="Shop Zipcode" name="shop_zipcode" @if(isset($vendorDetails['shop_zipcode'])) value="{{ $vendorDetails['shop_zipcode'] }}" required="" @endif>
                      </div>    
                      <div class="form-group">
                        <label for="shop_mobile">Shop Mobile</label>
                        <input type="text" class="form-control" id="shop_mobile" placeholder="Mobile" name="shop_mobile" @if(isset($vendorDetails['shop_mobile'])) value="{{ $vendorDetails['shop_mobile'] }}" maxlength="11" minlength="11" required="" @endif>
                      </div>
                      <div class="form-group">
                        <label for="business_license_number">Business License Number</label>
                        <input type="text" class="form-control" id="business_license_number" placeholder="Business License Number" name="business_license_number" @if(isset($vendorDetails['business_license_number'])) value="{{ $vendorDetails['business_license_number']}}" required="" @endif>
                      </div>
                      <div class="form-group">
                        <label for="gst_number">TIN Number</label>
                        <input type="text" class="form-control" id="gst_number" placeholder="TIN Number" name="gst_number" @if(isset($vendorDetails['gst_number'])) value="{{ $vendorDetails['gst_number'] }}" required="" @endif>
                      </div>
                      <div class="form-group">
                        <label for="pan_number">CNS Number</label>
                        <input type="text" class="form-control" id="pan_number" placeholder="CNS Number" name="pan_number" @if(isset($vendorDetails['pan_number'])) value="{{ $vendorDetails['pan_number'] }}" required="" @endif>
                      </div>
                      

                      <div class="form-group">
                        <label for="address_proof">Valid ID</label>
                        <select class="form-control" name="address_proof" id="address_proof">
                            <option value="Passport" @if(isset($vendorDetails['address_proof']) && $vendorDetails ['address_proof']=="Passport") selected @endif>Passport</option>
                            <option value="Drivers License" @if(isset($vendorDetails['address_proof']) && $vendorDetails ['address_proof']=="Drivers License") selected @endif>Drivers License</option>
                            <option value="National ID" @if(isset($vendorDetails['address_proof']) && $vendorDetails ['address_proof']=="National ID") selected @endif>National ID</option>
                        </select>
                    </div>
                      <div class="form-group">
                        <label for="address_proof_image">Address Proof Image</label>
                        <input type="file" class="form-control" id="address_proof_image" name="address_proof_image">
                        @if(!empty($vendorDetails['address_proof_image']))
                            <a target="_blank" href="{{ url ('admin/images/proofs/'.$vendorDetails['address_proof_image']) }}">View Image</a>
                            <input type="hidden" name="current_address_proof" value="{{ $vendorDetails['address_proof_image'] }}">
                        @endif
                      </div>

                      <div class="form-group">
                          <label for="address_proof_image">Address Proof Image</label>
                          <input type="file" class="form-control" id="address_proof_image" name="address_proof_image">
                          @if(!empty($vendorDetails['address_proof_image']))
                              <a target="_blank" href="{{ url('admin/images/proofs/'.$vendorDetails['address_proof_image']) }}">View Image</a>
                              <input type="hidden" name="current_address_proof" value="{{ $vendorDetails['address_proof_image'] }}">
                          @endif
                      </div>

                      <button type="submit" class="btn btn-primary mr-2">Submit</button>
                      <button class="btn btn-dark">Cancel</button>
                    </form>
                  </div>
                </div>
              </div>

        @elseif($slug=="bank")
        <div class="row">
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Update Bank Information</h4>
                      @if(Session::has('error_message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong>Error: </strong> {{ Session::get('error_message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                      @endif

                      @if(Session::has('success_message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                          <strong>Success: </strong> {{ Session::get('success_message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                      @endif

                        @if ($errors->any())
                           <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                           </div>
                        @endif

                    <form class="forms-sample" action="{{url('admin/update-vendor-details/bank') }}" method="post" enctype="multipart/form-data">@csrf
                      <div class="form-group">
                        <label>Vendor Username</label>
                        <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="">
                      </div>
                      <div class="form-group">
                        <label for="account_holder_name">Account Holder Name</label>
                        <input type="text" class="form-control" id="account_holder_name" placeholder="Account Holder Name" name="account_holder_name" @if(isset($vendorDetails['account_holder_name'])) value="{{ $vendorDetails['account_holder_name'] }}"required="" @endif>
                      </div>
                      <div class="form-group">
                        <label for="bank_name">Bank Name</label>
                        <input type="text" class="form-control" id="bank_name" placeholder="Bank Name" name="bank_name" @if(isset($vendorDetails['bank_name'])) value="{{ $vendorDetails['bank_name']  }}"required="" @endif>
                      </div>
                      <div class="form-group">
                        <label for="account_number">Account Number</label>
                        <input type="text" class="form-control" id="account_number" placeholder="Account Number" name="account_number"  @if(isset($vendorDetails['account_number'])) value="{{ $vendorDetails['account_number']  }}"required="" minlength='12' maxlength='12' @endif>
                      </div>
                      <div class="form-group">
                        <label for="bank_ifsc_code">Bank Code</label>
                        <input type="text" class="form-control" id="bank_ifsc_code" placeholder="Bank Code" name="bank_ifsc_code" @if(isset($vendorDetails['bank_ifsc_code'])) value="{{ $vendorDetails['bank_ifsc_code']  }}"required="" @endif>
                      </div>
                      <button type="submit" class="btn btn-primary mr-2">Submit</button>
                      <button class="btn btn-dark">Cancel</button>
                    </form>
                  </div>
                </div>
              </div>
        @endif
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>

@endsection