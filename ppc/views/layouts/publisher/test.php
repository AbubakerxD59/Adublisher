<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php echo SITEURL. "s3bucket" ?>" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" id="file">
        <input type="submit" value="submit">
    </form>
    
</body>
</html>