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
            include 'function.php';
            $base = "C:/Program Files/Ampps/www/FsBrowserPHP/";
            $url = $_SERVER['REQUEST_URI'];
            $url_components = parse_url($url);
            $path = "";

            if ($url_components['query']) {
                parse_str($url_components['query'], $params);
                if ($params['path']) {
                    $path = $params['path'];
                }
            }
            $fullFolderPath = $base.$path;

            if (!endsWith($fullFolderPath, "/")) {
                $fullFolderPath .= "/";
            }
            $scanned_directory = array_slice(scandir($fullFolderPath), 2);

            foreach ($scanned_directory as $file) {
                $fullFilePath = $fullFolderPath.$file;
                print("<tr class='file__body-row'>");
                print("<td class='file__column'>");
                if (is_dir($fullFilePath)) {
                    print("Directory");
                } elseif (exif_imagetype( $fullFilePath)) {
                    print("Image");
                } elseif (is_file($fullFilePath)) {
                    print("File");
                }
                print("</td>");
                print("<td class='file__column'>");
                if (is_dir($fullFilePath)) {
                    $nextLink = $path."/".$file;
                    print("<a class='file__link' href='?path=$nextLink'>$file</a>");   
                } else {
                    print($file);
                }
                print("</td>");
                print("<td class='file__column'>");
                if (is_file($fullFilePath)) {
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