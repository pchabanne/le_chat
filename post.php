<?php
require_once("php/fonctions.php");
require_once ('src/Message.php');

session_start();
if (isset($_SESSION['name']) && $_SESSION['name'] != "" && isset($_POST['text'])) {
    if ((time() - $_SESSION['LAST_ACTIVITY']) > tempsDinactiviteMax) {
        logout();
    } else if ($_SESSION["time"] + 2 > time() || strlen($_POST['text']) > 250 || $_POST['text'] == null || $_POST['text'] == "" || $_POST['text'][0] == " ") {

    } else {
        $espace = false;
        foreach ($_POST['text'] as $c) {
            if ($c == ' ') {
                if ($espace) {
                    $c = "";
                }
                $espace = true;
            } else {
                $espace = false;
            }
        }



        $_SESSION["time"] = time();


        $text = htmlspecialchars($_POST['text']);
        $text = remplacerSmiley($text);


        $message = new Message();
        $message->setDate(time());
        $message->setText($text);
        $message->setExpediteur($_SESSION["name"]);

        $em = getEm();
        $em->persist($message);
        $em->flush();
    }
}

