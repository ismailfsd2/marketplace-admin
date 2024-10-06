<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="InitModalgridLabel">Edit Currency</h5>
    </div>
    <div class="modal-body">
        <form action="{{ route('currencies.edit', $currency->id) }}" id="currency-edit-form" method="post">
            @csrf
            <div class="row g-3">
                <div class="col-xxl-12">
                    <div>
                        <label for="currency-name" class="form-label">Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="currency-name" name="name" placeholder="Enter Desinations Name" value="{{ $currency->name }}">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="currency-code" class="form-label">Code <span class="required">*</span></label>
                        <input type="text" class="form-control" id="currency-code" name="code" placeholder="Enter Currency Code" value="{{ $currency->code }}">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="currency-symbol" class="form-label">Symbol <span class="required">*</span></label>
                        <input type="text" class="form-control" id="currency-symbol" name="symbol" placeholder="Enter Currency Symbol" value="{{ $currency->symbol }}">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="currency-detail" class="form-label">Detail</label>
                        <textarea name="detail" id="currency-detail" class="form-control" height="100">{{ $currency->detail }}</textarea>
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="currency-status" class="form-label">Status <span class="required">*</span></label>
                        <select name="status" id="currency-status" class="form-control">
                            <option value="1" @if($currency->status == 1) selected @endif >Active</option>
                            <option value="0" @if($currency->status == 0) selected @endif >Deactive</option>
                        </select>
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
    $.modalForm('#currency-edit-form');
</script>