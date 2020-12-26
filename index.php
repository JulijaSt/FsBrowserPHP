<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FsBrowserPHP</title>
</head>
<body>

    <?php
        $dir = 'C:\Program Files\Ampps\www\FsBrowserPHP';
        $scanned_directory = array_slice(scandir($dir), 2);
        print_r($scanned_directory);
    ?>

</body>
</html>