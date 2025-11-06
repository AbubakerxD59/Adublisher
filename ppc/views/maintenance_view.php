<!DOCTYPE html>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Maintenance</title>

    <style>
        body {
            width: 500px;
            margin: 0 auto;
            text-align: center;
            color: blue;
        }
    </style>
</head>

<body>
    <img src="<?php echo ASSETURL . 'images/logo.svg'; ?>" alt="Logo" style="margin-top: 20px;">
    <h1>
        <p>Sorry for the inconvenience.</p>
        <p>Please revisit shortly</p>
    </h1>
</body>

</html>
<?php
header('HTTP/1.1 503 Service Temporarily Unavailable');
header('Status: 503 Service Temporarily Unavailable');
header('Retry-After: 3600');
?>