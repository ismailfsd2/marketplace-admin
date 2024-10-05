<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="InitModalgridLabel">Add New Brand</h5>
    </div>
    <div class="modal-body">
        <form action="{{ route('brands.add') }}" id="brand-add-form" method="post">
            @csrf
            <div class="row g-3">
                <div class="col-xxl-12">
                    <div>
                        <label for="brand-logo" class="form-label">Logo </label>
                        <input type="file" class="form-control" id="brand-logo" name="logo">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="brand-name" class="form-label">Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="brand-name" name="name" placeholder="Enter Brand Name">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="brand-slug" class="form-label">Slug <span class="required">*</span></label>
                        <input type="text" class="form-control" id="brand-slug" name="slug" placeholder="Enter Brand Slug">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="brand-detail" class="form-label">Detail</label>
                        <textarea name="detail" id="brand-detail" class="form-control" height="100"></textarea>
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
    $.modalForm('#brand-add-form');
</script>