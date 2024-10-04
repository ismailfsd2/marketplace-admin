<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="InitModalgridLabel">Edit Unit</h5>
    </div>
    <div class="modal-body">
        <form action="{{ route('units.edit', $unit->id) }}" id="unit-edit-form" method="post">
            @csrf
            <div class="row g-3">
                <div class="col-xxl-12">
                    <div>
                        <label for="unit-name" class="form-label">Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="unit-name" name="name" placeholder="Enter Desinations Name" value="{{ $unit->name }}">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="unit-code" class="form-label">Code <span class="required">*</span></label>
                        <input type="text" class="form-control" id="unit-code" name="code" placeholder="Enter Tax Code" value="{{ $unit->code }}">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="unit-detail" class="form-label">Detail</label>
                        <textarea name="detail" id="unit-detail" class="form-control" height="100">{{ $unit->detail }}</textarea>
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="unit-status" class="form-label">Status <span class="required">*</span></label>
                        <select name="status" id="unit-status" class="form-control">
                            <option value="1" @if($unit->status == 1) selected @endif >Active</option>
                            <option value="0" @if($unit->status == 0) selected @endif >Deactive</option>
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
    $.modalForm('#unit-edit-form');
</script>