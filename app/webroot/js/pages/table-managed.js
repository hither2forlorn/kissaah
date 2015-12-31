var TableManaged = function () {

    var ManageAccounts = function () {

        var table = $('#accounts_index');

        // begin first table
        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "No entries found",
                "infoFiltered": "(filtered1 from _MAX_ total entries)",
                "lengthMenu": "Show _MENU_ entries",
                "search": "Search:",
                "zeroRecords": "No matching records found"
            },

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "columns": [
                        {"orderable": true}, 
                        {"orderable": true}, 
                        {"orderable": false}, 
                        {"orderable": false}, 
                        {"orderable": false}, 
                        {"orderable": true}, 
                        {"orderable": true}, 
                        {"orderable": true}, 
                        {"orderable": false}
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 25,            
            "pagingType": "bootstrap_full_number",
            "language": {
                "search": "My search: ",
                "lengthMenu": "  _MENU_ records",
                "paginate": {
                    "previous":"Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },
            "columnDefs": [{  // set default column settings
                'orderable': false,
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });
    }

    var ManageTransactions = function () {

        var table = $('#transactions_index');

        // begin first table
        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "No entries found",
                "infoFiltered": "(filtered1 from _MAX_ total entries)",
                "lengthMenu": "Show _MENU_ entries",
                "search": "Search:",
                "zeroRecords": "No matching records found"
            },

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "columns": [
                        {"orderable": true}, 
                        {"orderable": true}, 
                        {"orderable": false}, 
                        {"orderable": false}, 
                        {"orderable": false}, 
                        {"orderable": true}, 
                        {"orderable": true}, 
                        {"orderable": true}, 
                        {"orderable": true}, 
                        {"orderable": false}
            ],
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 25,            
            "pagingType": "bootstrap_full_number",
            "language": {
                "search": "My search: ",
                "lengthMenu": "  _MENU_ records",
                "paginate": {
                    "previous":"Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },
            "columnDefs": [{  // set default column settings
                'orderable': false,
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [1, "asc"]
            ] // set first column as a default sort by asc
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }
            ManageAccounts();
            ManageTransactions();
        }
    };
}();