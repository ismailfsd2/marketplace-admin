$.modalInit = function (selector, size = 'md') {
    $(document).on('click',selector,function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        $('#modalInit .modal-dialog').html(initHtml());
        var opInit = new bootstrap.Modal(document.getElementById('modalInit'), {
            backdrop: 'static', // Disable close on background click
            keyboard: false     // Disable close on Escape key press
          });
        $('#modalInit').modal('show');
        $.ajax({
            url: url,
            method: 'GET',
            success: function (resp) {
                if(resp.status){
                    $('#modalInit .modal-dialog').html(resp.body);
                }
                else{
                    $('#modalInit').modal('hide');
                    $.alertShow(resp.message,'danger');
                }
            },
            error: function(jqXHR, textStatus){
                $('#modalInit').modal('hide');
                $.alertShow('Something wrong!','danger');
            }
        });
    });
}
function initHtml(){
    var html = "";
    html += '<div class="modal-content">';
        html += '<div class="modal-header">';
            html += '<h5 class="modal-title" id="InitModalgridLabel">Loading..</h5>';
            html += '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        html += '</div>';
        html += '<div class="modal-body">';
            html += '<span class="d-flex align-items-center">';
                html += '<span class="spinner-border flex-shrink-0" role="status">';
                    html += '<span class="visually-hidden">Loading...</span>';
                html += '</span>';
                html += '<span class="flex-grow-1 ms-2">';
                    html += 'Loading...';
                html += '</span>';
            html += '</span>';
        html += '</div>';
    html += '</div>';
    return html;
}