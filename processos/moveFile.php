<?php

if (isset($_FILES['myFile'])) {
    move_uploaded_file($_FILES['myFile']['tmp_name'], "../files/" . $_FILES['myFile']['name']);
}
?>

