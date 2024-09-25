$.tableInit = function (selector, url, option = {}) {
    let currentRequest = null; // This will store the current AJAX request
    var toption = {
        dom: "Bfrtip",
        buttons: ["copy", "csv", "excel", "print", "pdf"],
        processing: true,
        serverSide: true,
        order: [[0, 'desc']],
        ajax: function (data, callback, settings) {
            data['_token'] = $('meta[name="csrf-token"]').attr('content');
            // Abort the current request if it exists and is still ongoing
            if (currentRequest) {
                currentRequest.abort();
            }
            // Start a new request
            currentRequest = $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function (resp) {
                    callback(resp);
                },
                complete: function () {
                    currentRequest = null; // Clear the current request on completion
                }
            });
        },
        // scrollX: !0
    }
    if(option.columns){
        toption['columns'] = option.columns;
    }
    let table = new DataTable(selector, toption);
    return {
        table: table,
        refresh: function() {
            table.ajax.reload(); // Refresh the table by re-fetching data from the server
        }
    };
}