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
            preConfirm: async (login) => {
                try {
                    var url = $(this).attr('href');
                    var data = {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }
                    console.log(data);
                    $.ajax({
                        url: url, 
                        type: "POST",
                        data: data,
                        success: function (res) {
                            if(res.status){
                                return Swal.showValidationMessage(res.message);
                            }
                            else{
                                $.alertShow(res.message,'danger');
                            }
                        },
                        error: function(jqXHR, textStatus){
                            Swal.showValidationMessage('Something Wrong!');
                        }
                    });
                }
                catch (error) {
                    Swal.showValidationMessage(`
                        Request failed: ${error}
                    `);
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