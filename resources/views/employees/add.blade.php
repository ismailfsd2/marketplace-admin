@extends('layout')
@section('head')
@stop
@section('body')

    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#employee-detail-panel" role="tab" aria-selected="true">
                                    <i class="fas fa-home"></i> Employee Details
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <div class="tab-pane active" id="employee-detail-panel" role="tabpanel">
                                <form action="{{ route('employees.add') }}" method="post" id="employee-add-form">
                                    @csrf
                                    <div class="row gy-4">
                                        <div class="col-md-6">
                                            <div>
                                                <label for="first-name" class="form-label">First Name <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="first-name" name="first_name" required >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="last-name" class="form-label">Last Name <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="last-name" name="last_name" required >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="phone-number" class="form-label">Phone Number <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="phone-number" name="phone_number" required >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="email" class="form-label">Email <span class="required">*</span></label>
                                                <input type="email" class="form-control" id="email" name="email" required >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="designation" class="form-label">Designation <span class="required">*</span></label>
                                                <select class="form-control designations-select" id="designation" name="designation" required data-url="{{ route('designations.select') }}"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="department" class="form-label">Department <span class="required">*</span></label>
                                                <select class="form-control departments-select" id="department" name="department" required data-url="{{ route('departments.select') }}"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="country" class="form-label">Country <span class="required">*</span></label>
                                                <select class="form-control countries-select" id="country" name="country" required data-url="{{ route('countries.select') }}"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="state" class="form-label">State <span class="required">*</span></label>
                                                <select class="form-control states-select" id="state" name="state" required data-url="{{ route('states.select') }}"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="city" class="form-label">City <span class="required">*</span></label>
                                                <select class="form-control cities-select" id="city" name="city" required data-url="{{ route('cities.select') }}"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="postal-code" class="form-label">Postal Code <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="postal-code" name="postal_code" required >
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div>
                                                <label for="address" class="form-label">Address <span class="required">*</span></label>
                                                <textarea class="form-control" id="address" name="address" ></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mt-4">
                                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                                    <input type="checkbox" class="form-check-input" id="create-login-detail" name="create_login_detail" value="1">
                                                    <label class="form-check-label" for="create-login-detail">Create Login Detail</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 login-fields">
                                            <div>
                                                <label for="password" class="form-label">Password <span class="required">*</span></label>
                                                <input type="password" class="form-control" id="password" name="password" >
                                            </div>
                                        </div>
                                        <div class="col-md-6 login-fields">
                                            <div>
                                                <label for="confirm-password" class="form-label">Confirm Password <span class="required">*</span></label>
                                                <input type="password" class="form-control" id="confirm-password" name="confirm_password" >
                                            </div>
                                        </div>
                                        <div class="col-md-12 login-fields">
                                            <div class="mt-4">
                                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                                    <input type="checkbox" class="form-check-input" id="own-data-visible" name="own_data_visible" value="1">
                                                    <label class="form-check-label" for="own-data-visible">Own Data Show</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="hstack gap-2 justify-content-start">
                                                <button type="submit" class="btn btn-primary">Register</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- <div class="mb-3"> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>

@stop
@section('bottom')
<script>
    $.ajaxForm('#employee-add-form');
    $('#create-login-detail').change(function(){
        check_login_field();
    });
    function check_login_field(){
        if ($('#create-login-detail').is(':checked')) {
            $('.login-fields').show();
        }
        else {
            $('.login-fields').hide();
        }
    }
    check_login_field()
</script>
@stop
