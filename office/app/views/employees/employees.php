<script>
let dataTable;
let id, employeeCode, name, gender, mobile, email, emergencyContact, bloodGroup, company, department, designation, supervisor, employeeType, joiningDate, status;

$(document).ready(function () {

    // fix- dropdown control access after jquery dialog
    $(".dropdown-toggle").dropdown();

    // data table configuration
    dataTable = $("#employee").DataTable({

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
            url: "<?php echo URLROOT; ?>/index.php?url=api/get_employees/",
            dataSrc: ""
        },

        columns: [
            {
                data: "employeeCode",
                render: function (data, type, service) {
                    employeeCode = data;
                    return data;
                }
            },
            {
                data: "name",
                render: function (data, type, service) {
                    name = data;
                    return data;
                }
            },
            {
                data: "gender",
                render: function (data, type, service) {
                    gender = data;
                    return data;
                }
            },
            {
                data: "mobile",
                render: function (data, type, service) {
                    mobile = data;
                    return data;
                }
            },
            {
                data: "email",
                render: function (data, type, service) {
                    email = data;
                    return data;
                }
            },
            {
                data: "emergencyContact",
                render: function (data, type, service) {
                    emergencyContact = data;
                    return data;
                }
            },
            {
                data: "bloodGroup",
                render: function (data, type, service) {
                    bloodGroup = data;
                    return data;
                }
            },
            {
                data: "company",
                render: function (data, type, service) {
                    company = data;
                    return data;
                }
            },
            {
                data: "department",
                render: function (data, type, service) {
                    department = data;
                    return data;
                }
            },
            {
                data: "designation",
                render: function (data, type, service) {
                    designation = data;
                    return data;
                }
            },
            {
                data: "supervisor",
                render: function (data, type, service) {
                    supervisor = data;
                    return data;
                }
            },
            {
                data: "type",
                render: function (data, type, service) {
                    employeeType = data;
                    return data;
                }
            },
            {
                data: "joiningDate",
                render: function (data, type, service) {
                    joiningDate = data;
                    return data;
                }
            },
            {
                data: "status",
                render: function (data, type, service) {
                    status = data;
                    return data;
                }
            },
            {
                data: "id",
                render: function (data, type, service) {
                    var editBtn, applications_btn, form;
                    id = data;

                    idField = '<input type="hidden" name="id" value="' + id + '"/>';
                    employeeCodeField = '<input type="hidden" name="employee_code" value="' + employeeCode + '"/>';
                    nameField = '<input type="hidden" name="name" value="' + name + '"/>';
                    genderField = '<input type="hidden" name="gender" value="' + gender + '"/>';
                    mobileField = '<input type="hidden" name="mobile" value="' + mobile + '"/>';
                    emailField = '<input type="hidden" name="email" value="' + email + '"/>';
                    emergencyContactField = '<input type="hidden" name="emergency_contact" value="' + emergencyContact + '"/>';
                    bloodGroupField = '<input type="hidden" name="blood_group" value="' + bloodGroup + '"/>';
                    companyField = '<input type="hidden" name="company" value="' + company + '"/>';
                    departmentField = '<input type="hidden" name="department" value="' + department + '"/>';
                    designationField = '<input type="hidden" name="designation" value="' + designation + '"/>';
                    supervisorField = '<input type="hidden" name="supervisor" value="' + supervisor + '"/>';
                    typeField = '<input type="hidden" name="type" value="' + employeeType + '"/>';
                    joiningDateField = '<input type="hidden" name="joining_date" value="' + joiningDate + '"/>';
                    statusField = '<input type="hidden" name="status" value="' + status + '"/>';

                    editBtn = '<button type="submit" class="btn btn-primary mt-2 mr-2"><i class="far fa-edit"></i> Edit Information</button>';
                    form = '<form style="display: inline; float: left;" method="post" action="<?php echo URLROOT; ?>/index.php?url=hr/employee_form">' + idField + employeeCodeField + nameField + genderField + mobileField + emailField + emergencyContactField + bloodGroupField + companyField + departmentField + designationField + supervisorField + typeField + joiningDateField + statusField + editBtn + '</form>';
                    
                    activities_btn = '<a style="text-decoration: none; float: left;" class="btn btn-info mt-2" href="<?php echo URLROOT; ?>/index.php?url=employees/activities/' + id + '"><i class="far fa-folder-open"></i> View Activities</a>';
                    
                    return form + activities_btn;
                }
            }
        ],

        "language": {
            searchPlaceholder: "Search anything ...",
            "lengthMenu": "Display _MENU_ rows",
            "infoFiltered": ""
        },

        "order": [[ 0, "asc" ]]
    });

});
</script>