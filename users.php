<?php
session_start();
require_once("php/fonctions.php");
require_once ('src/Auteur.php');





if (isset($_SESSION['name'])) {

    $em = getEm();
    $users = $em->getRepository("Auteur")->findAll();
    echo json_encode($users);
}