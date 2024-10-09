<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="InitModalgridLabel">Edit New POC</h5>
    </div>
    <div class="modal-body">
        <form action="{{ route('point_of_contacts.edit', $poc->id) }}" id="poc-edit-form" method="post">
            @csrf
            <div class="row g-3">
                <div class="col-xxl-12">
                    <div>
                        <label for="name" class="form-label">Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ $poc->name }}">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="designation" class="form-label">Designation <span class="required">*</span></label>
                        <input type="text" class="form-control" id="designation" name="designation" placeholder="Enter Desinations" value="{{ $poc->designation }}">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="phone_number" class="form-label">Phone Number <span class="required">*</span></label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter Phone Number" value="{{ $poc->phone_number }}">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ $poc->email }}">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="detail" class="form-label">Detail</label>
                        <textarea name="detail" id="detail" class="form-control" height="100">{{ $poc->detail }}</textarea>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light modal-close" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-load">Submit</button>
                    </div>
                </div>
            </div><!--end row-->
        </form>
    </div>
</div>

<script>
    $.modalForm('#poc-edit-form');
</script>