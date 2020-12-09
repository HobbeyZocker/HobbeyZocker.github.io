<?php
include('header.php');
?>
<form enctype="multipart/form-data" method="POST">
    <input type="text" name="directory" placeholder="Pfad eingeben"/>
    <input type="hidden" name="MAX_FILE_SIZE" value="41943040" />
    Diese Datei hochladen: <input name="userfile" type="file" /><br>
    <input type="submit" name="upload" value="Hochladen" />
</form>
<?php
if (filter_input(INPUT_POST, "upload")) {
    $dir = filter_input(INPUT_POST, "directory", FILTER_SANITIZE_STRING) ?? "";
    $file = $dir . basename($_FILES["userfile"]["name"]);

    echo '<pre>';
    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $file)) {
        echo "Datei ist valide und wurde erfolgreich hochgeladen.\n";
    } else {
        echo "Möglicherweise eine Dateiupload-Attacke!\n";
    }

    echo 'Weitere Debugging Informationen:';
    print_r($_FILES);
    //test
    print "</pre>";
}
include('footer.php');
