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
    <?php
        include 'function.php';
        $base = "C:/Program Files/Ampps/www/FsBrowserPHP";
        $url = $_SERVER['REQUEST_URI'];
        $url_components = parse_url($url);
        $path = "";
        $backUrl = $url;
        $mainDirectory = "/FsBrowserPHP/";

        if ($url_components['query']) {
            parse_str($url_components['query'], $params);
            if ($params['path']) {
                $mainDirectory = "/FsBrowserPHP";
                $path = $params['path'];
                $splitUrl = explode("/", $url, -1);
                $backUrl = join("/", $splitUrl);
            }
        }

        $fullFolderPath = $base.$path;

        if (!endsWith($fullFolderPath, "/")) {
            $fullFolderPath .= "/";
        }

        if (isset($_POST["directory"])) {
            $directory_name = $_POST["directory"];
            if (!file_exists($fullFolderPath . $directory_name)) {
                @mkdir($fullFolderPath . $directory_name, 0777);
            }
        }

        if (isset($_POST["delete_file"])) {
            $file_name = $_POST["file_name"];
            unlink($fullFolderPath . $file_name);
        }

        $scanned_directory = array_slice(scandir($fullFolderPath), 2);
    ?>

    <div class="body-wrapper">
        <h1 class="directory">Directory contents: <?php print($mainDirectory.$path) ?></h1>
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
                foreach ($scanned_directory as $file) {
                    $fullFilePath = $fullFolderPath.$file;
                    print("<tr class='file__body-row'>");
                    print("<td class='file__column'>");
                    if (is_dir($fullFilePath)) {
                        print("Directory");
                    } elseif (exif_imagetype($fullFilePath)) {
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
                        print("<form method='post' action=''>");
                        print("<input type='hidden' name='file_name' value='" . $file . "'>");
                        print("<input type='submit' name='delete_file' class='btn' value='Delete'>");
                        print("</form>");
                    }
                    print("</td>");
                    print("</tr>");
                }
                ?>
            <tbody>
        </table>
        <div class="bottom-wrapper">
            <a href="<?php print($backUrl); ?>"><button class="btn btn--back">Back</button></a>
            <form action="" method="POST" name="createDirectory" class="directory-form">
                <input type="text" placeholder="Name of new directory" class="directory-form__text" name="directory">
                <input type="submit" class="btn btn--create" value="Create">
            </form>
        </div>
    </div>
</body>
</html>