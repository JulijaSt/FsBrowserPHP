<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/scss/components/reset.css">
    <link rel="stylesheet" href="assets/dist/css/main.min.css">
    <title>FsBrowserPHP</title>
</head>
<body>

    <h1 class="directory">Directory contents: <?php print($_SERVER['REQUEST_URI']) ?></h1>

    <table class="file">
        <thead class="file__head">
            <tr class="file__row">
                <th class="file__column">Type</th>
                <th class="file__column">Name</th>
                <th class="file__column">Actions</th>
            </tr>
        </thead> 
        <tbody class="file__body">
            <?php
            $dir = 'C:/Program Files/Ampps/www/FsBrowserPHP/';
            $scanned_directory = array_slice(scandir($dir), 2);
            print_r($scanned_directory);

            foreach ($scanned_directory as $file) {
                print("<tr class='file__body-row'>");
                print("<td class='file__column'>");
                if (is_dir($file)) {
                    print("Directory");
                } elseif (exif_imagetype($file)) {
                    print("Image");
                } elseif (is_file($file)) {
                    print("File");
                }
                print("</td>");
                print("<td class='file__column'>");
                if (is_dir($file)) {
                    print("<a class='file__link' href='?path=/$file'>$file</a>");
                } else {
                    print($file);
                }
                print("</td>");
                print("</td>");
                print("<td class='file__column'>");
                if (is_file($file)) {
                    print("<button class='btn btn--delete'>Delete</button>");
                }
                print("</td>");
                print("</tr>");
            }
            ?>
        <tbody>
    </table>

    

</body>
</html>