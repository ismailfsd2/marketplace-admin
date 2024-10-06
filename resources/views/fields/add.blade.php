<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="InitModalgridLabel">Add New Field</h5>
    </div>
    <div class="modal-body">
        <form action="{{ route('field_groups.fields.add',$field_group_id) }}" id="field-add-form" method="post">
            @csrf
            <div class="row g-3">
                <div class="col-xxl-12">
                    <div>
                        <label for="field-label" class="form-label">Label <span class="required">*</span></label>
                        <input type="text" class="form-control" id="field-label" name="label" placeholder="Enter Field Label">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="field-machine-name" class="form-label">Machine Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="field-machine-name" name="machine_name" placeholder="Enter Machine Name">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="field-type" class="form-label">Type <span class="required">*</span></label>
                        <select name="type" id="field-type" class="form-control">
                            <option value="text" selected>Text</option>
                            <option value="select">Select</option>
                            <option value="checkbox">Checkbox</option>
                        </select>
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="field-placeholder" class="form-label">Placeholder</label>
                        <input type="text" class="form-control" id="field-placeholder" name="placeholder" placeholder="Enter Placeholder">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="field-required" class="form-label">Required <span class="required">*</span></label>
                        <select name="required" id="field-required" class="form-control">
                            <option value="no" selected>No</option>
                            <option value="yes">Yes</option>
                        </select>
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div class="mb-3">
                        <label for="field-options" class="form-label">Options</label>
                        <input class="form-control custom-text-unique" id="field-options" type="text" value="" name="options" />
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
    $.modalForm('#field-add-form');
    var textUniqueVals = new Choices('.custom-text-unique', {
        delimiter: '~,~',
        removeItemButton: true,
        paste: false,
        duplicateItemsAllowed: false,
        editItems: true,
    });
</script>