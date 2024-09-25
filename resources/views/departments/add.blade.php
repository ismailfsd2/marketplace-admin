<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="InitModalgridLabel">Add New Department</h5>
    </div>
    <div class="modal-body">
        <form action="{{ route('departments.add') }}" id="department-add-form" method="post">
            @csrf
            <div class="row g-3">
                <div class="col-xxl-12">
                    <div>
                        <label for="department-name" class="form-label">Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="department-name" name="name" placeholder="Enter Desinations Name">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="department-detail" class="form-label">Detail</label>
                        <textarea name="detail" id="department-detail" class="form-control" height="100"></textarea>
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
    $.modalForm('#department-add-form');
</script>