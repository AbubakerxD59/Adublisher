<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Error Logs</title>
</head>
<body>

<div class="container-fluid">
    <h1><a href="<?php echo base_url();?>">Go Back to Website</a></h1>
    <br>
    <table id="error_logs_table" class="table table-striped table-hover">
        <thead>
        <tr>
            <th>UserId</th>
            <th>Full Name</th>
            <th>User Name</th>
            <th>Type</th>
            <th>Channel Name</th>
            <th>Status</th>
            <th>Date</th>
            <th>Error</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>

<!-- <script>
    $(document).ready(function() {
      
        $('#error_logs_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {                
                "url": "<?php echo SITEURL; ?>error_logs_api",
                "type": "GET"
            },
            "columns": [
                { "data": "user_id" },
                { "data": "first_name" },
                { "data": "error_channel" },
                { "data": "channel_name" },
                { "data": "error" },
                { "data": "date_time" }
            ]
        });
    });
</script> -->

<script>
    $(document).ready(function() {
      
        $('#error_logs_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {                
                "url": "<?php echo SITEURL; ?>error_logs_api",
                "type": "GET"
            },
            "columns": [
                { "data": "user_id" },
                { 
                    "data": "first_name",
                    "render": function (data, type, row) {
                        return data + ' ' + row.last_name;
                    }
                },
                { "data": "uname" },
                { 
                    "data": "error_channel",
                    "render": function (data, type, row) {
                        switch(data) {
                            case "pinterest_error":
                                return "Pinterest";
                            case "facebook_page_error":
                                return "Facebook";
                            case "instagram_error":
                                return "Instagram";
                            case "facebook_group_error":
                                return "Group";
                            default:
                                return data;
                        }
                    }
                },
                { "data": "channel_name" },
                { 
                    "data": "status",
                    "render": function (data, type, row) {
                        return data == 1 ? 'Solved' : 'Pending';
                    }
                },
                { "data": "date_time" },
                { "data": "error" }
            ]
        });
    });
</script>

</body>
</html>
