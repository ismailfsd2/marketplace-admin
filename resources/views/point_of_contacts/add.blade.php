<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="InitModalgridLabel">Add New POC</h5>
    </div>
    <div class="modal-body">
        <form action="{{ route('point_of_contacts.add', $supplier->id) }}" id="point-of-contacts-add-form" method="post">
            @csrf
            <div class="row g-3">
                <div class="col-xxl-12">
                    <div>
                        <label for="name" class="form-label">Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="designation" class="form-label">Designation <span class="required">*</span></label>
                        <input type="text" class="form-control" id="designation" name="designation" placeholder="Enter Desinations">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="phone_number" class="form-label">Phone Number <span class="required">*</span></label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter Phone Number">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="detail" class="form-label">Detail</label>
                        <textarea name="detail" id="detail" class="form-control" height="100"></textarea>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light modal-close" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-load">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $.modalForm('#point-of-contacts-add-form');
</script>