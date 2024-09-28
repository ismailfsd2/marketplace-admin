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
                            @if($employee->picture != "")
                                <img src="{{ asset($employee->picture) }}" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="User Profile Image">
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
                        <h5 class="fs-16 mb-1">{{ $employee->first_name }} {{ $employee->last_name }}</h5>
                        <p class="text-muted mb-0">{{ $employee->designation->name }} / {{ $employee->department->name }}</p>
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
                                <i class="far fa-user"></i> Login Detail Update
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="personalDetails" role="tabpanel">
                            <form action="{{ route('employees.udpate',['employee_id'=>$employee->id,'user_id'=>1]) }}" method="post" id="employee-edit-form">
                                @csrf
                                <div class="row gy-4">
                                    <div class="col-md-6">
                                        <div>
                                            <label for="first-name" class="form-label">First Name <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="first-name" name="first_name" required value="{{ $employee->first_name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label for="last-name" class="form-label">Last Name <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="last-name" name="last_name" required value="{{ $employee->last_name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label for="phone-number" class="form-label">Phone Number <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="phone-number" name="phone_number" required value="{{ $employee->phone_number }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label for="email" class="form-label">Email <span class="required">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" required value="{{ $employee->email }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label for="designation" class="form-label">Designation <span class="required">*</span></label>
                                            <select class="form-control designations-select" id="designation" name="designation" required data-url="{{ route('designations.select') }}" data-default_value="{{ $employee->designation_id }}"></select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label for="department" class="form-label">Department <span class="required">*</span></label>
                                            <select class="form-control departments-select" id="department" name="department" required data-url="{{ route('departments.select') }}" data-default_value="{{ $employee->department_id }}"></select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label for="country" class="form-label">Country <span class="required">*</span></label>
                                            <select class="form-control countries-select" id="country" name="country" required data-url="{{ route('countries.select') }}" data-default_value="{{ $employee->country_id }}"></select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label for="state" class="form-label">State <span class="required">*</span></label>
                                            <select class="form-control states-select" id="state" name="state" required data-url="{{ route('states.select') }}" data-default_value="{{ $employee->state_id }}"></select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label for="city" class="form-label">City <span class="required">*</span></label>
                                            <select class="form-control cities-select" id="city" name="city" required data-url="{{ route('cities.select') }}" data-default_value="{{ $employee->city_id }}"></select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label for="postal-code" class="form-label">Postal Code <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="postal-code" name="postal_code" required value="{{ $employee->postal_code }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div>
                                            <label for="address" class="form-label">Address <span class="required">*</span></label>
                                            <textarea class="form-control" id="address" name="address" >{{ $employee->address }}</textarea>
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
                            <form action="{{ route('employees.login_detail_update',['user_id'=>$employee->user->id]) }}" method="post" id="employee-change-password-form">
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
                                        <div class="mt-2">
                                            <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                                <input type="checkbox" class="form-check-input" id="own-data-visible" name="own_data_visible" value="1">
                                                <label class="form-check-label" for="own-data-visible">Own Data Show</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div>
                                            <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                                @if($employee->user->status == 1)
                                                    <input type="checkbox" class="form-check-input" id="user-status" name="status" value="1" checked>
                                                @else
                                                    <input type="checkbox" class="form-check-input" id="user-status" name="status" value="1">
                                                @endif
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
        $.ajaxForm('#employee-edit-form');
        $.ajaxForm('#employee-change-password-form');
        $(document).ready(function() {
            $('#profile-img-file-input').on('change', function() {
                if (this.files && this.files[0]) {
                    var formData = new FormData();
                    formData.append('profile_image', this.files[0]);
                    $.ajax({
                        url: "{{ route('employees.change_profile',['employee_id'=>$employee->id]) }}",
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
        });

    </script>
@stop

