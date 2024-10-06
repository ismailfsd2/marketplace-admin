<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="InitModalgridLabel">Add New Currency</h5>
    </div>
    <div class="modal-body">
        <form action="{{ route('currencies.add') }}" id="currency-add-form" method="post">
            @csrf
            <div class="row g-3">
                <div class="col-xxl-12">
                    <div>
                        <label for="currency-name" class="form-label">Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="currency-name" name="name" placeholder="Enter Currency Name">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="currency-code" class="form-label">Code <span class="required">*</span></label>
                        <input type="text" class="form-control" id="currency-code" name="code" placeholder="Enter Currency Code">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="currency-symbol" class="form-label">Symbol <span class="required">*</span></label>
                        <input type="text" class="form-control" id="currency-symbol" name="symbol" placeholder="Enter Currency Symbol">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="currency-detail" class="form-label">Detail</label>
                        <textarea name="detail" id="currency-detail" class="form-control" height="100"></textarea>
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
    $.modalForm('#currency-add-form');
</script>