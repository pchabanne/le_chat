<?php
session_start();
require_once('php/fonctions.php');
require_once ('src/Message.php');


if (isset($_SESSION['name'])) {


    $em = getEm();

    $repository = $em->getRepository("Message");
    $queryCount = $repository->createQueryBuilder("e")->select("count(e.id)")->getQuery();
    $nbmessage = $queryCount->getSingleResult();

    $queryMessage = $repository->createQueryBuilder("m")->select("m")->orderBy("m.id", "desc")->setMaxResults(40)->getQuery();
    $messages = $queryMessage->getArrayResult();
    $messages = array_reverse($messages);
    $json = json_encode($messages);

    echo $json;
}