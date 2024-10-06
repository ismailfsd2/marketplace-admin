<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="InitModalgridLabel">Edit Unit</h5>
    </div>
    <div class="modal-body">
        <form action="{{ route('categories.edit', $category->id) }}" id="category-edit-form" method="post">
            @csrf
            <div class="row g-3">
                <div class="col-xxl-12">
                    <div>
                        <label for="category-thumbnail" class="form-label">Thumbnail </label>
                        <input type="file" class="form-control" id="category-thumbnail" name="thumbnail">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="category-icon" class="form-label">Icon </label>
                        <input type="file" class="form-control" id="category-icon" name="icon">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="category-name" class="form-label">Name <span class="required">*</span></label>
                        <input type="text" class="form-control" id="category-name" name="name" placeholder="Enter category Name" value="{{ $category->name }}">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="category-slug" class="form-label">Slug <span class="required">*</span></label>
                        <input type="text" class="form-control" id="category-slug" name="slug" placeholder="Enter Tax Slug" value="{{ $category->slug }}">
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="parent_category" class="form-label">Parent Category <span class="required">*</span></label>
                        <select class="form-control parent-category-select" id="parent_category" name="parent_category" required data-url="{{ route('categories.select') }}" data-default_value="{{ $category->parent_category }}">
                            <option value="0" selected >No Parent Category</option>
                        </select>
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="fields_group" class="form-label">Fields Group <span class="required">*</span></label>
                        <select class="form-control fields-group-select" id="fields_group" name="fields_group" required data-url="{{ route('field_groups.select') }}" data-default_value="{{ $category->field_group_id }}">
                            <option value="0" selected >No Fields Group</option>
                        </select>
                    </div>
                </div>
                <div class="col-xxl-12">
                    <div>
                        <label for="field-status" class="form-label">Status <span class="required">*</span></label>
                        <select name="status" id="field-status" class="form-control">
                            <option value="1" @if($category->status == 1) selected @endif >Active</option>
                            <option value="0" @if($category->status == 0) selected @endif >Deactive</option>
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
    $.modalForm('#category-edit-form');
    $.ajaxSelect2(".parent-category-select",{
        first_option: {
            id: "0",
            text: "No Parent Category"

        }
    });
    $.ajaxSelect2(".fields-group-select",{
        first_option: {
            id: "0",
            text: "No Fields Group"

        }
    });
</script>