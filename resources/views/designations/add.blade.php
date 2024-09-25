<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="InitModalgridLabel">Add New Designation</h5>
    </div>
    <div class="modal-body">
        <form action="{{ route('designations.add') }}" id="designation-add-form" method="post">
            @csrf
            <div class="row g-3">
                <div class="col-xxl-12">
                    <div>
                        <label for="designation-name" class="form-label">Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="designation-name" name="name" placeholder="Enter Desinations Name">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="designation-detail" class="form-label">Detail</label>
                        <textarea name="details" id="designation-detail" class="form-control" height="100"></textarea>
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
    $.modalForm('#designation-add-form');
</script>