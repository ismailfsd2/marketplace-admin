$.modalForm = function (selector, method = 'POST') {
    $(selector).submit(function(e){
        e.preventDefault();
        var url = $(this).attr('action');
        var btn_loading = '<span class="d-flex align-items-center"><span class="spinner-grow flex-shrink-0" role="status"><span class="visually-hidden">Loading...</span></span><span class="flex-grow-1 ms-2">Submitting...</span></span>';
        $(this).find('button[type="submit"]').attr('disabled', 'disabled').html(btn_loading);
        $(this).find('button').attr('disabled', 'disabled');
        $.ajax({
            url: url, 
            type: method, 
            data: new FormData(this), 
            contentType: false,
            cache:false,
            processData: false,
            success: function (res) {
                if(res.status){
                    $.alertShow(res.message,'success');
                    $('#modalInit').modal('hide');
                    $datatable.refresh();
                }
                else{
                    $.alertShow(res.message,'danger');
                }
            },
            error: function(jqXHR, textStatus){
                $(selector).find('button[type="submit"]').removeAttr('disabled').html('Submit');
                $(selector).find('button').removeAttr('disabled');
                var errorStatus = jqXHR.status;
                if(errorStatus == 422){
                    var errors = jqXHR.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        $.each(messages, function(index, message) {
                            $.alertShow(message,'danger');
                        });
                    });
                }
                else{
                    $.alertShow('Something wrong!','danger');
                }
            }
        });
    });
}

$.ajaxForm = function (selector, method = 'POST') {
    $(selector).submit(function(e){
        e.preventDefault();
        var url = $(this).attr('action');
        var btn_loading = '<span class="d-flex align-items-center"><span class="spinner-grow flex-shrink-0" role="status"><span class="visually-hidden">Loading...</span></span><span class="flex-grow-1 ms-2">Submitting...</span></span>';
        $(this).find('button[type="submit"]').attr('disabled', 'disabled').html(btn_loading);
        $.ajax({
            url: url, 
            type: method, 
            data: new FormData(this), 
            contentType: false,
            cache:false,
            processData: false,
            success: function (res) {
                if(res.status){
                    $.alertShow(res.message,'success');
                    if(res.redirect){
                        window.location.href = res.redirect;
                    }
                    else{
                        location.reload();
                    }
                }
                else{
                    $.alertShow(res.message,'danger');
                    $(selector).find('button[type="submit"]').removeAttr('disabled').html('Submit');
                }
            },
            error: function(jqXHR, textStatus){
                $(selector).find('button[type="submit"]').removeAttr('disabled').html('Submit');
                var errorStatus = jqXHR.status;
                if(errorStatus == 422){
                    var errors = jqXHR.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        $.each(messages, function(index, message) {
                            $.alertShow(message,'danger');
                        });
                    });
                }
                else{
                    $.alertShow('Something wrong!','danger');
                }
            }
        });
    });
}

$.deleteRecord = function(selector){
    $(document).on('click',selector,function(e){
        e.preventDefault();
        Swal.fire({
            customClass: {
                cancelButton: "btn btn-success",
                confirmButton: "btn btn-danger"
            },
            title: "Do you want to delete the record?",
            icon: "info",
            showCancelButton: true,
            confirmButtonText: "Yes, Delete it!",
            cancelButtonText: "No, cancel!",
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                try {
                    var url = $(this).attr('href');
                    const response = await fetch(url);
                    if (!response.ok) {
                      return Swal.showValidationMessage(`
                        ${JSON.stringify(await response.json())}
                      `);
                    }
                    return response.json();
                  } catch (error) {
                    Swal.showValidationMessage(`Request failed`);
                  }
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            console.log(result);
            if (result.isConfirmed) {
                Swal.fire(result.value.message, "success");
                $datatable.refresh();
            }
        });
    });

}

$.alertShow = function(message, type = "primary"){
    var option = {}
    option['text'] = message;
    option['gravity'] = "top";
    option['position'] = "right";
    option['className'] = "error";
    option['duration'] = 3000;
    option['close'] = true;
    option['style'] = {};
    if(type == "success"){
        option['style']['background'] = '#0ab39c'; // Success
    }
    else if(type == "warning"){
        option['style']['background'] = '#f7b84b'; // Warning
    }
    else if(type == "danger"){
        option['style']['background'] = '#cc563d'; // Danger
    }
    else{
        option['style']['background'] = '#405189'; // Primary
    }

    Toastify(option).showToast();
}

$.ajaxSelect2 = function(selector, parent_selector = false, $default_value = false){
    var url  = $(selector).data('url');
    var parent = false;
    if(parent_selector){
        parent = $(parent_selector).val();
    }
    $(selector).select2({
        allowClear: false,
        ajax: {
            url:url,
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    parent:parent,
                    _token: $('meta[name="csrf-token"]').attr('content')
                };
            },
            processResults: function (data) {
                if(data.status){
                    return {
                        results: $.map(data.items, function (item) {
                            return {
                                id: item.id,
                                text: item.name 
                            }
                        })
                    };
                }
                else{
                    return {
                        results: []
                    }
                }
            },
            cache: true 
        }
    });
    if($(selector).data('default_value')){
        $.ajax({
            url: url,
            type: 'json',
            method: 'GET',
            data: {
                default_value: $(selector).data('default_value'),
                parent:parent,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.status) {
                    var defaultOption = new Option(data.items[0].name, data.items[0].id, true, true);
                    $(selector).append(defaultOption).trigger('change');
                }
            }
        });
    }
}
$.ajaxSelect2(".designations-select");
$.ajaxSelect2(".departments-select");
$.ajaxSelect2(".countries-select");
$.ajaxSelect2(".states-select", ".countries-select");
$.ajaxSelect2(".cities-select", ".states-select");
