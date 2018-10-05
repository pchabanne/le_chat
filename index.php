<?php
session_start();
require_once("php/fonctions.php");
require_once('src/Auteur.php');
require_once ('src/Message.php');
$em  = getEm();

if (isset($_SESSION['name'])) {
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > tempsDinactiviteMax)) {
        logout();
    }


    if (isset($_GET['logout'])) {
        logout();
    }
}
$_SESSION['LAST_ACTIVITY'] = time();

if (isset($_POST['enter']) && !isset($_SESSION['name']) && isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] < tempsDinactiviteMax)) {
    if ($_POST['name'] != "" && preg_match("/^[a-zA-Z][a-zA-Z0-9_-]*$/", $_POST['name']) && strlen($_POST['name']) >= 3 && strlen($_POST['name']) <= 12) {
        $pseudoValide = true;
        $pseudo = stripslashes(htmlspecialchars($_POST['name']));
        $testAuteur = $em->getRepository('Auteur')->findby(array("pseudo"=>$pseudo));

        if(count($testAuteur)>0){
            $pseudoValide = false;
            echo '<span class="error">Ce pseudo est déjà pris.</span>';
        }

        if ($pseudoValide) {
            $_SESSION['name'] = $pseudo;
            $_SESSION['time'] = time() - 2;

            $auteur = new Auteur();
            $auteur->setPseudo($_SESSION['name']);
            $auteur->setDerniereActivite($_SESSION['time']);

            $em->persist($auteur);
            $em->flush();

        }
    } else {
        echo '<span class="error">Veuillez entrer un pseudo valide.</span>';
    }
}
include("php/chat.php");
