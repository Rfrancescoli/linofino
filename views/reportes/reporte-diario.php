<?php require_once '../header.php' ?>


<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

<script>
    $(document).ready(function() {
        $('#clientsTable').DataTable({
            "ajax": {
                "url": "../../app/controllers/Cliente.controller.php?operation=listaClientes", // Adjust this path
                "dataSrc": ""
            },
            "columns": [{
                    "data": "id"
                },
                {
                    "data": "first_name"
                },
                {
                    "data": "last_name"
                },
                {
                    "data": "email"
                },
                {
                    "data": "gender"
                },
                {
                    "data": "phone"
                }
            ]
        });
    });
</script>
</head>

<body>

    <div class="container">
        <h2>Clients List</h2>
        <table id="clientsTable" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated here by DataTables -->
            </tbody>
        </table>
    </div>

    <?php require_once '../footer.php' ?>