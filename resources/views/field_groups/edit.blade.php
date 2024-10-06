<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="InitModalgridLabel">Edit Unit</h5>
    </div>
    <div class="modal-body">
        <form action="{{ route('field_groups.edit', $field_group->id) }}" id="field-groups-edit-form" method="post">
            @csrf
            <div class="row g-3">
                <div class="col-xxl-12">
                    <div>
                        <label for="field-groups-name" class="form-label">Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="field-groups-name" name="name" placeholder="Enter Desinations Name" value="{{ $field_group->name }}">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="field-groups-detail" class="form-label">Detail</label>
                        <textarea name="detail" id="field-groups-detail" class="form-control" height="100">{{ $field_group->detail }}</textarea>
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
    $.modalForm('#field-groups-edit-form');
</script>