<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="InitModalgridLabel">Edit Field</h5>
    </div>
    <div class="modal-body">
        <form action="{{ route('field_groups.fields.edit', $field->id) }}" id="field-edit-form" method="post">
            @csrf
            <div class="row g-3">
                <div class="col-xxl-12">
                    <div>
                        <label for="field-label" class="form-label">Label <span class="required">*</span></label>
                        <input type="text" class="form-control" id="field-label" name="label" placeholder="Enter Field Label" value="{{ $field->label }}">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="field-machine-name" class="form-label">Machine Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="field-machine-name" name="machine_name" placeholder="Enter Machine Name" value="{{ $field->machine_name }}">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="field-type" class="form-label">Type <span class="required">*</span></label>
                        <select name="type" id="field-type" class="form-control">
                            <option value="text" @if($field->type == "text") selected @endif >Text</option>
                            <option value="select" @if($field->type == "select") selected @endif >Select</option>
                            <option value="checkbox" @if($field->type == "checkbox") selected @endif >Checkbox</option>
                        </select>
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="field-placeholder" class="form-label">Placeholder</label>
                        <input type="text" class="form-control" id="field-placeholder" name="placeholder" placeholder="Enter Placeholder" value="{{ $field->placeholder }}">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="field-required" class="form-label">Required <span class="required">*</span></label>
                        <select name="required" id="field-required" class="form-control">
                            <option value="no" @if($field->required == "no") selected @endif >No</option>
                            <option value="yes" @if($field->required == "yes") selected @endif >Yes</option>
                        </select>
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div class="mb-3">
                        <label for="field-options" class="form-label">Options</label>
                        @php
                            $options = json_decode($field->options, true);
                            $options_values = array_column($options,'value');
                            $options_val = implode('~,~', $options_values);
                        @endphp
                        <input class="form-control custom-text-unique" id="field-options" type="text" value="{{ $options_val }}" name="options" />
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
    $.modalForm('#field-edit-form');
    var textUniqueVals = new Choices('.custom-text-unique', {
        delimiter: '~,~',
        removeItemButton: true,
        paste: false,
        duplicateItemsAllowed: false,
        editItems: true,
    });
</script>