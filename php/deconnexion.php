<?php
session_start();

require_once("fonctions.php");
if (isset($_SESSION['name']) && isset($_POST["deconnexion"]) && $_POST['deconnexion'] == true) {
    logout();
} else {
    echo "lol";
}
