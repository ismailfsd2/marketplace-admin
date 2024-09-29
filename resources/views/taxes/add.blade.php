<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="InitModalgridLabel">Add New Tax</h5>
    </div>
    <div class="modal-body">
        <form action="{{ route('taxes.add') }}" id="tax-add-form" method="post">
            @csrf
            <div class="row g-3">
                <div class="col-xxl-12">
                    <div>
                        <label for="tax-name" class="form-label">Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="tax-name" name="name" placeholder="Enter Tax Name">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="tax-code" class="form-label">Code <span class="required">*</span></label>
                        <input type="text" class="form-control" id="tax-code" name="code" placeholder="Enter Tax Code">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="tax-type" class="form-label">Type <span class="required">*</span></label>
                        <select name="type" id="tax-type" class="form-control">
                            <option value="percentage">Percentage</option>
                            <option value="fixed" selected >Fixed</option>
                        </select>
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="tax-rate" class="form-label">Rate <span class="required">*</span></label>
                        <input type="text" class="form-control" id="tax-rate" name="rate" placeholder="Enter Tax Rate">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="tax-detail" class="form-label">Detail</label>
                        <textarea name="detail" id="tax-detail" class="form-control" height="100"></textarea>
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
    $.modalForm('#tax-add-form');
</script>