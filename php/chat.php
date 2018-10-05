<!DOCTYPE html>
<head>
    <title>Chat</title>
    <link rel="stylesheet" href="jquery-ui/jquery-ui.min.css">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"/>
    <link type="text/css" rel="stylesheet" href="css/style.css"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="row loginform">
    <div class="col s12 m12 l9">
        <div class="valign-wrapper">
    <?php
    if (!isset($_SESSION['name']) || $_SESSION['name'] == null) {
        $_SESSION['connected'] = false;
        loginForm();
    }
    if (isset($_SESSION['name'])){
        if (!$_SESSION['connected']) {

            $message = new Message();
            $message->setText("<div class='msgln'><i>" . $_SESSION['name'] . " est connecté(e)</i></div>\r\n");
            $message->setDate(time());
            $em->persist($message);
            $em->flush();

            $_SESSION['connected'] = true;
        }
    ?>
</div>
</div>
</div>

<div class="row">
    <div class="col s12 m12 l9">
        <hr/>

        <div id="chatbox" class="ombre"></div>

    <div class="test">
        <div class="row">
            <div class="col s10 m10 l10">
                <form name="message" id="message" action="">
                    <input name="usermsg" type="text" id="usermsg" class="ombre" autocomplete="off"/>
                    <input name="submitmsg" type="submit" id="submitmsg" style="visibility:hidden; width:0px;height:0px;"/>
                </form>
            </div>
            <div class="col s2 m2 l2">
                <a onclick="envoyerMessage()" class="custom-button"> <i class="material-icons">send</i></a>
                <form id="formupload" action="" method="post" enctype="multipart/form-data" class="">
                    <label for="upload" class="custom-button">
                        <i class="material-icons">add_a_photo</i>
                    </label>
                    <input id="upload" name="upload" type="file" style="visibility:hidden; width:0px;height:0px;"/>
                </form>
                <div id="compteur"></div>
            </div>
        </div>
    </div>
    </div>

    <div class="test row col s12 m12 l3">
        <div class="utilisateurs col s12 m12 l12">
            <hr/>
            Liste des utilisateurs <b><span id="btnMasquerAfficher" class="right-align"> - </span></b>
            <div id="users" class="ombre">

            </div>
        </div>
        <div id="boutons" class="boutons col s12 m12 l12">
            <hr/>
            <img class="bouton"src="images/note.png" id="bruit" alt="smiley">
            <img class="bouton"src="images/lune.png" id="nuit" alt="smiley">
            <a class="modal-trigger"href="#modal1"><img class="bouton"src="images/grod.png" id="nuit" alt="smiley"></a>

            <img class="bouton"src="images/croix.png" id="exit" alt="smiley">
        </div>
    </div>

    <div id="modal1" class="modal">
        <?php include("smiley.html"); ?>
    </div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="jquery-ui/jquery-ui.min.js"></script>
<script type="application/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<?php
}
?>
</body>
</html>
