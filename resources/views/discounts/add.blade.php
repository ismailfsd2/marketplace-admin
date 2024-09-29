<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="InitModalgridLabel">Add New Discount</h5>
    </div>
    <div class="modal-body">
        <form action="{{ route('discounts.add') }}" id="discount-add-form" method="post">
            @csrf
            <div class="row g-3">
                <div class="col-xxl-12">
                    <div>
                        <label for="discount-name" class="form-label">Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="discount-name" name="name" placeholder="Enter Discount Name">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="discount-code" class="form-label">Code <span class="required">*</span></label>
                        <input type="text" class="form-control" id="discount-code" name="code" placeholder="Enter Discount Code">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="discount-type" class="form-label">Type <span class="required">*</span></label>
                        <select name="type" id="discount-type" class="form-control">
                            <option value="percentage">Percentage</option>
                            <option value="fixed" selected >Fixed</option>
                        </select>
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="discount-rate" class="form-label">Rate <span class="required">*</span></label>
                        <input type="text" class="form-control" id="discount-rate" name="rate" placeholder="Enter Discount Rate">
                    </div>
                </div>
                <div class="col-lg-12">
                    <div>
                        <label class="form-label mb-0" for="discount-start-date-time">Start Date & Time</label>
                        <input type="text" class="form-control" id="discount-start-date-time" name="start_date" >
                    </div>
                </div>
                <div class="col-lg-12">
                    <div>
                        <label class="form-label mb-0" for="discount-end-date-time">End Date & Time</label>
                        <input type="text" class="form-control" id="discount-end-date-time" name="end_date" >
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="discount-detail" class="form-label">Detail</label>
                        <textarea name="detail" id="discount-detail" class="form-control" height="100"></textarea>
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
    $.modalForm('#discount-add-form');
    flatpickr("#discount-start-date-time", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });
    flatpickr("#discount-end-date-time", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });
</script>