<script>
var dataTable;

$(document).ready(function () {

    // fix- dropdown control access after jquery dialog
    $(".dropdown-toggle").dropdown();

    // data table configuration
    dataTable = $("#supervisor_inbox").DataTable({

        dom:
            "<'row'<'col-sm-7'B><'col-sm-5'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5 mt-1'i><'col-sm-2 mt-3'l><'col-sm-5 mt-2'p>>",

        //dom: 'Bfrtip',

        responsive: true,

        stateSave: false,

        'iDisplayLength': 10, // num of rows in a page by default

        "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]], // number of rows to show

        "pagingType": "first_last_numbers", // numbers, simple, simple_numbers, full, full_numbers, first_last_numbers

        // defining the nature of columns
        // 'columnDefs': [
        //     { 'targets': [5], 'className': 'text-center', 'sortable': false, 'searchable': false }
        // ],

        buttons: [

            { extend: 'print', text: '<i class="fas fa-print"></i> Print' },
            { extend: 'copy', text: '<i class="far fa-copy"></i> Copy' },
            { extend: 'excel', text: '<i class="far fa-file-excel"></i> Excel', filename: 'Employee Record', exportOptions: { modifier: { page: 'all' } } },
            // { extend: 'pdf', text: '<i class="far fa-file-pdf"></i> PDF', filename: 'Employee Record', orientation: 'Portrait', pageSize: 'LEGAL', exportOptions: { modifier: { page: 'all' } } },
            // { extend: 'colvis', text: '<i class="fas fa-columns"></i> Columns' }

        ],

        ajax: {
            url: "<?php echo URLROOT; ?>/index.php?url=api/get_applications_for_supervisor/<?php echo $data_array['id']; ?>",
            dataSrc: ""
        },

        columns: [
            {
                data: "id",
            },
            {
                data: "leaveType",
            },
            {
                data: "applicant",
            },
            {
                data: "fromDate",
            },
            {
                data: "toDate",
            },
            {
                data: "status",
                render: function (data, type, service) {
                    if( data == 'Pending' ) {
                        return '<p class="text-info">' + data + '</p>';
                    }
                    else if( data == 'Delegated' ) {
                        return '<p class="text-primary">' + data + '</p>';
                    }
                    else if( data == 'Declined' ) {
                        return '<p class="text-danger">' + data + '</p>';
                    }
                    else if( data == 'Accepted' ) {
                        return '<p class="text-success">' + data + '</p>';
                    }
                    else if( data == 'Reclaimed' ) {
                        return '<p class="text-secondary"><strong>' + data + '</strong></p>';
                    }
                }
            },
            // {
            //     data: "delegate",
            // },
            {
                data: "id",
                render: function (data, type, service) {
                    var btn = "<a style='float: left;' class='btn btn-primary' href='<?php echo URLROOT; ?>/index.php?url=applications/details/" + data + "'>Details</a>";
                    return btn;
                }
            }
        ],

        "language": {
            searchPlaceholder: "Search anything ...",
            "lengthMenu": "Display _MENU_ rows",
            "infoFiltered": ""
        },

        "order": [[ 0, "desc" ]]
    });

});
</script>