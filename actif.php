<?php
session_start();
require_once("php/fonctions.php");
require_once('src/Auteur.php');
require_once ('src/Message.php');


if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > tempsDinactiviteMax) && isset($_SESSION['name'])) {
    logout();
}
if (isset($_SESSION['name'])) {
    if (isset($_POST['actif'])) {
        if (time() - $_SESSION['LAST_ACTIVITY'] > 0) {
            $_SESSION['LAST_ACTIVITY'] = time();
            $em = getEm();
            $auteur = $em->getRepository('Auteur')->findOneBy(array("pseudo"=>$_SESSION['name']));
            $auteur->setDerniereActivite($_SESSION['LAST_ACTIVITY']);
            $em->persist($auteur);
            $em->flush();

        }
    }
}
