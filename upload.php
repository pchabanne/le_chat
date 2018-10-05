<?php
session_start();
require_once('php/fonctions.php');
require_once ('src/Message.php');


if($_SESSION["name"]) {
    if (isset($_FILES["upload"])) {
        $validextensions = array("jpeg", "jpg", "png", "gif");
        $temporary = explode(".", $_FILES["upload"]["name"]);
        $file_extension = end($temporary);
        if ((($_FILES["upload"]["type"] == "image/png") || ($_FILES["upload"]["type"] == "image/jpg") || ($_FILES["upload"]["type"] == "image/jpeg") || ($_FILES["upload"]["type"] == "image/gif")
            ) && ($_FILES["upload"]["size"] < 2000000)//Approx. 100kb files can be uploaded.
            && in_array($file_extension, $validextensions)) {
            if ($_FILES["upload"]["error"] > 0) {

            } else {
                $sourcePath = $_FILES['upload']['tmp_name'];
                $targetPath = "upload/" . $_FILES['upload']['name'];
                $targetPath = "upload/" . time() . rand(0, 100) . "." . $file_extension;
                move_uploaded_file($sourcePath, $targetPath);

                $message = new Message();
                $message->setText("<a target=\"_blank\" href='".$targetPath."'><img class='image'src='".$targetPath."'></a>");
                $message->setDate(time());
                $message->setExpediteur($_SESSION["name"]);
                $em = getEm();
                $em->persist($message);
                $em->flush();

            }
		} else {
            echo "Erreur: mauvaise extension (jpeg, jpg et png seulement sont autorisés) ou fichier trop volumineux (2Mo environ maximum)";
        }
    }
}
?>
