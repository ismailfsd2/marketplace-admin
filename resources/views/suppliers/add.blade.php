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
                                <a class="nav-link active" data-bs-toggle="tab" href="#supplier-detail-panel" role="tab" aria-selected="true">
                                    <i class="fas fa-home"></i> Supplier Details
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <div class="tab-pane active" id="supplier-detail-panel" role="tabpanel">
                                <form action="{{ route('suppliers.add') }}" method="post" id="supplier-add-form" autocomplete="off" >
                                    @csrf
                                    <div class="row gy-4">
                                        <div class="col-md-6">
                                            <div>
                                                <label for="supplier-name" class="form-label">Name <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="supplier-name" name="name" required >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="supplier-phone-number" class="form-label">Phone Number <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="supplier-phone-number" name="phone_number" required >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="supplier-email" class="form-label">Email </label>
                                                <input type="email" class="form-control" id="supplier-email" name="email" autocomplete="off">
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
                                                <label for="supplier-postal-code" class="form-label">Pastal Code <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="supplier-postal-code" name="postal_code" required >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="supplier-address" class="form-label">Address <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="supplier-address" name="address" required >
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mt-4">
                                                        <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                                            <input type="checkbox" class="form-check-input" id="register-status" name="register_status" value="1">
                                                            <label class="form-check-label" for="register-status">Supplier Register?</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 register-fields">
                                                    <div class="mt-4">
                                                        <div>
                                                            <label for="supplier-register-number" class="form-label">Register Number <span class="required">*</span></label>
                                                            <input type="text" class="form-control" id="supplier-register-number" name="register_number" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div>
                                                <label for="supplier-detail" class="form-label">Detail</label>
                                                <textarea name="detail" id="supplier-detail" class="form-control" height="200"></textarea>
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
                                        <div class="col-lg-12">
                                            <div class="hstack gap-2 justify-content-start">
                                                <button type="submit" class="btn btn-primary">Register</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
    $.ajaxForm('#supplier-add-form');
    $('#create-login-detail').change(function(){
        check_login_field();
    });
    $('#register-status').change(function(){
        check_register_field();
    });
    $('#supplier-email').change(function(){
        if($('#supplier-email').val() == ""){
            $('#create-login-detail').prop('checked', false);
            $('.login-fields').hide();
        }
    });
    function check_login_field(){
        if ($('#create-login-detail').is(':checked')) {
            if($('#supplier-email').val() == ""){
                $('#create-login-detail').prop('checked', false);
                $.alertShow('Please enter email','danger');
            }
            else{
                $('.login-fields').show();
            }
        }
        else {
            $('.login-fields').hide();
        }
    }
    function check_register_field(){
        if ($('#register-status').is(':checked')) {
            $('.register-fields').show();
        }
        else {
            $('.register-fields').hide();
        }
    }
    check_login_field()
    check_register_field()
</script>
@stop
