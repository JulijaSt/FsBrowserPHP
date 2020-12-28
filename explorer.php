<?php
    include 'function.php';
    $base = getcwd();
    $url = $_SERVER['REQUEST_URI'];
    $url_components = parse_url($url);
    $path = "";
    $mainDirectory = "/" . basename(getcwd()) . "/";
    $backUrl = $url;
    

    if ($url_components['query']) {
        parse_str($url_components['query'], $params);
        if ($params['path']) {
            $mainDirectory = "/" . basename(getcwd());
            $path = $params['path'];
            $splitUrl = explode("%", $url, -1);
            $backUrl = join("%", $splitUrl);
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

    if (isset($_GET["file_name"]) and isset($_GET["path"])) {
        $file_name = $_GET["file_name"];
        if (file_exists($fullFolderPath . $file_name)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: 0");
            header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
            header('Content-Length: ' . filesize($file_name));
            header('Pragma: public');
            flush();
            readfile($file_name);
            die();
        } else {
            print("File does not exist.");
        }
    }

    $scanned_directory = array_slice(scandir($fullFolderPath), 2); 
?>

<div class="body-wrapper">
    <h1 class="directory">Directory contents: <?php print($mainDirectory.$path) ?></h1>
    <table class="file">
        <thead class="file__head">
            <tr class="file__row">
                <th class="file__column file__column--head">Type</th>
                <th class="file__column file__column--head">Name</th>
                <th class="file__column file__column--head">Actions</th>
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
                    print("<a class='file__link' href='?path=" . urlencode($nextLink) . "'>$file</a>");   
                } else {
                    print($file);
                }
                print("</td>");
                print("<td class='file__column action'>");
                if (is_file($fullFilePath)) {
                    print("<form method='post' action='' class='file-action'>");
                    print("<input type='hidden' name='file_name' value='" . $file . "'>");
                    print("<input type='submit' name='delete_file' class='btn' value='Delete'>");
                    print("</form>");
                    print("<form method='get' action='' class='file-action'>");
                    print("<input type='hidden' name='file_name' value='" . $file . "'>");
                    print("<input type='hidden' name='path' value='" . $path . "'>");
                    print("<input type='submit' name='download_file' class='btn' value='Download'>");
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
        <p class="logout">Click here to <a href = "index.php?action=logout"> logout.</a></p>
    </div>
</div>