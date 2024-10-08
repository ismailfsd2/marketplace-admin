@extends('layout')
@section('head')
@stop
@section('body')
    <div class="position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg profile-setting-img">
            <img src="{{ asset('')}}assets/images/profile-bg.jpg" class="profile-wid-img" alt="">
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-3">
            <div class="card mt-n5">
                <div class="card-body p-4">
                    <div class="text-center">
                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                            @if($supplier->logo != "")
                                <img src="{{ asset($supplier->logo) }}" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="User Profile Image">
                            @else
                                <img src="{{ asset('') }}assets/images/users/avatar-1.jpg" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                            @endif
                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                <input id="profile-img-file-input" type="file" class="profile-img-file-input">
                                <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                    <span class="avatar-title rounded-circle bg-light text-body">
                                        <i class="ri-camera-fill"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <h5 class="fs-16 mb-1">{{ $supplier->name }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
        <div class="col-xxl-9">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab" aria-selected="true">
                                <i class="fas fa-home"></i> Personal Details
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab" aria-selected="false" tabindex="-1">
                                @if(!$supplier->user)
                                    <i class="far fa-user"></i> Create Login Account
                                @else
                                    <i class="far fa-user"></i> Login Detail Update
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="personalDetails" role="tabpanel">
                            @php
                                $user_id = 0;
                            @endphp
                            @if($supplier->user)
                                @php
                                    $user_id = $supplier->user->id;
                                @endphp
                            @endif
                            <form action="{{ route('suppliers.udpate',['supplier_id'=>$supplier->id,'user_id'=>$user_id]) }}" method="post" id="supplier-edit-form">
                                @csrf
                                <div class="row gy-4">
                                    <div class="col-md-6">
                                        <div>
                                            <label for="supplier-name" class="form-label">Name <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="supplier-name" name="name" required value="{{ $supplier->name }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label for="supplier-phone-number" class="form-label">Phone Number <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="supplier-phone-number" name="phone_number" required value="{{ $supplier->phone_number }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label for="supplier-email" class="form-label">Email </label>
                                            <input type="email" class="form-control" id="supplier-email" name="email" autocomplete="off" value="{{ $supplier->email }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label for="country" class="form-label">Country <span class="required">*</span></label>
                                            <select class="form-control countries-select" id="country" name="country" required data-url="{{ route('countries.select') }}" data-default_value="{{ $supplier->country_id }}" ></select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label for="state" class="form-label">State <span class="required">*</span></label>
                                            <select class="form-control states-select" id="state" name="state" required data-url="{{ route('states.select') }}" data-default_value="{{ $supplier->state_id }}" ></select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label for="city" class="form-label">City <span class="required">*</span></label>
                                            <select class="form-control cities-select" id="city" name="city" required data-url="{{ route('cities.select') }}" data-default_value="{{ $supplier->city_id }}" ></select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label for="supplier-postal-code" class="form-label">Pastal Code <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="supplier-postal-code" name="postal_code" required value="{{ $supplier->postal_code }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label for="supplier-address" class="form-label">Address <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="supplier-address" name="address" required value="{{ $supplier->address }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mt-4">
                                                    <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                                        <input type="checkbox" class="form-check-input" id="register-status" name="register_status" value="1" @if($supplier->tax_register_status == "yes") checked @endif >
                                                        <label class="form-check-label" for="register-status">Supplier Register?</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 register-fields">
                                                <div class="mt-4">
                                                    <div>
                                                        <label for="supplier-register-number" class="form-label">Register Number <span class="required">*</span></label>
                                                        <input type="text" class="form-control" id="supplier-register-number" name="register_number" value="{{ $supplier->tax_number }}" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div>
                                            <label for="supplier-detail" class="form-label">Detail</label>
                                            <textarea name="detail" id="supplier-detail" class="form-control" height="200">{{ $supplier->detail }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-start">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--end tab-pane-->
                        <div class="tab-pane" id="changePassword" role="tabpanel">
                            @if(!$supplier->user)
                                <form action="{{ route('suppliers.create_login_account',['supplier_id'=>$supplier->id]) }}" method="post" id="supplier-create-login-form">
                                @csrf
                                    <div class="row g-2">
                                        <div class="col-lg-4">
                                            <div>
                                                <label for="supplier-email" class="form-label">Email </label>
                                                <input type="email" class="form-control" id="supplier-email" name="email" autocomplete="off" value="{{ $supplier->email }}" >
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4">
                                            <div>
                                                <label for="new-password" class="form-label">New Password <span class="required">*</span></label>
                                                <input type="password" class="form-control" id="new-password" name="new_password" placeholder="Enter new password">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4">
                                            <div>
                                                <label for="new-password-confirm" class="form-label">Confirm Password <span class="required">*</span></label>
                                                <input type="password" class="form-control" id="new-password-confirm" name="new_password_confirm" placeholder="Confirm password">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="text-start">
                                                <button type="submit" class="btn btn-success">Create</button>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            @else
                                <form action="{{ route('suppliers.login_detail_update',['user_id'=>$supplier->user->id]) }}" method="post" id="supplier-change-password-form">
                                    @csrf
                                    <div class="row g-2">
                                        <div class="col-lg-4">
                                            <div>
                                                <label for="current-password" class="form-label">Current Password <span class="required">*</span></label>
                                                <input type="password" class="form-control" id="current-password" name="current_password" placeholder="Enter current password">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4">
                                            <div>
                                                <label for="new-password" class="form-label">New Password <span class="required">*</span></label>
                                                <input type="password" class="form-control" id="new-password" name="new_password" placeholder="Enter new password">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4">
                                            <div>
                                                <label for="new-password-confirm" class="form-label">Confirm Password <span class="required">*</span></label>
                                                <input type="password" class="form-control" id="new-password-confirm" name="new_password_confirm" placeholder="Confirm password">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div>
                                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                                    <input type="checkbox" class="form-check-input" id="user-status" name="status" value="1" @if($supplier->user->status == 1) checked @endif >
                                                    <label class="form-check-label" for="user-status">Login Account Active</label>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="text-start">
                                                <button type="submit" class="btn btn-success">Update</button>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
@stop
@section('bottom')
    <script>
        $.ajaxForm('#supplier-edit-form');
        $.ajaxForm('#supplier-create-login-form');
        $.ajaxForm('#supplier-change-password-form');
        $(document).ready(function() {
            $('#profile-img-file-input').on('change', function() {
                if (this.files && this.files[0]) {
                    var formData = new FormData();
                    formData.append('logo_image', this.files[0]);
                    $.ajax({
                        url: "{{ route('suppliers.change_profile',$supplier->id) }}",
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if(response.status){
                                location.reload();
                                $.alertShow('Profile Uploaded','success');
                            }
                            else{
                                $.alertShow('Something wrong!','danger');
                            }
                        },
                        error: function(xhr, status, error) {
                            $.alertShow('Something wrong!','danger');
                            alert('An error occurred while uploading the image.');
                        }
                    });
                }
            });
            check_register_field()
        });
        $('#register-status').change(function(){
            check_register_field();
        });
        function check_register_field(){
            if ($('#register-status').is(':checked')) {
                $('.register-fields').show();
            }
            else {
                $('.register-fields').hide();
            }
        }

    </script>
@stop

