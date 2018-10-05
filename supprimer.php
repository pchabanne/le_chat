<?php
require_once("php/fonctions.php");
require_once ('src/Message.php');

session_start();
if(isset($_POST['supprimer'])&&$_SESSION['name']=="pablito"){

    $em = getEm();
    $messages = $em->getRepository("Message")->findAll();
    foreach ($messages as $mes){
        $em->remove($mes);
    }
    $em->flush();
    $nouvMessage = new Message();
    $nouvMessage->setText("<h1>Bienvenue</h1>");
    $nouvMessage->setDate(time());
    $em->persist($nouvMessage);
    $em->flush();


    $json = file_get_contents("json/conversations.json");
    $parsed_json = json_decode($json, true);
    $parsed_json['nbmessage'] = 0;
    $messages = array();
    $parsed_json['messages'] = $messages;



}
 ?>
