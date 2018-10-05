<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
define("tempsDinactiviteMax", 600);
define("tailleSmiley", 50);
global $em;
$em = $entityManager;

function getEm(){
    require_once "vendor/autoload.php";

    $isDevMode = true;
    $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/src"), $isDevMode);


    $conn = array(
        'dbname' => 'le_chat',
        'user' => 'root',
        'password' => 'toto',
        'host' => '127.0.0.1',
        'port' => '3306',
        'driver' => 'pdo_mysql',
    );

// obtaining the entity manager
    $entityManager = EntityManager::create($conn, $config);
    return $entityManager;
}

function logout()
{
    if (isset($_SESSION["name"])) {
        $em = getEm();
        $utilisateur = $em->getRepository('Auteur')->findby(array("pseudo"=>$_SESSION["name"]));
        $em->remove($utilisateur[0]);
        $em->flush();

        $message = new Message();
        $message->setText("<div class='msgln'><i>" . $_SESSION['name'] . " est parti(e)</i></div>\r\n");
        $message->setDate(time());
        $em->persist($message);
        $em->flush();

    }
    unset($_SESSION["name"]);
    session_unset();
    header("Location: index.php");
}

function loginForm()
{
    echo '
    <div id="loginform" class="center-align col s12 m12 l12">
    <form action="index.php" method="post">
        <p>Veuillez entrer un pseudo valide pour continuer.
            <ul>
                <li>Le pseudo doit contenir entre 3 et 12 caractères</li>
                <li>Le pseudo doit contenir seulement des lettres (majuscules ou minuscules), des chiffres ainsi que ces caractères spéciaux: - _</li>
                <li>Le pseudo doit commencer par une lettre</li>
            </ul>
        </p>
        <label for="name">Pseudo:</label>
        <input type="text" name="name" id="name" autocomplete="off" />
        <input type="submit" name="enter" id="enter" value="Entrer" />
    </form>
    </div>
    <script type="application/javascript" src="js/onload.js"></script>

    ';
}


function remplacerSmiley($text)
{
    $mots = explode(" ", $text);
    foreach ($mots as $mot){
        if(strpos($text, "youtube.com/watch?v=") !== false){
            if(substr_count($text, $mot)>1){
                $text = "";
            }else{
                $data = file_get_contents("https://www.youtube.com/oembed?url=".$mot."&format=json");
                $donnes = json_decode($data, true);
                $text = str_replace($mot, '<a target="_blank" href="'.$mot.'">
            <span class="card horizontal">
                <div class="card-image">
                    <img src="'.$donnes["thumbnail_url"].'">
                </div>
                <div class="card-stacked">
                    <span class="title">'.$donnes['title'].'</span>
                </div>
            </span>
</a>', $text);
            }
        }
        elseif($mot[0] =="h"&&$mot[1]=="t"&&$mot[2]=="t"&&$mot[3]=="p"&&$mot[4]==":"&&$mot[5]=="/"){
            $text = str_replace($mot, "<a target='_blank' href='".$mot."'>".$mot."</a>", $text);
        }
        elseif ($mot[0] =="h"&&$mot[1]=="t"&&$mot[2]=="t"&&$mot[3]=="p"&&$mot[4]=="s"&&$mot[5]==":"&&$mot[6]=="/"){
            $text = str_replace($mot, "<a target='_blank' href='".$mot."'>".$mot."</a>", $text);
        }
        elseif ($mot[0] =="w"&&$mot[1]=="w"&&$mot[2]=="w"&&$mot[3]=="."){
            $text = str_replace($mot, "<a target='_blank' href='http://".$mot."'>".$mot."</a>", $text);
        }

    }


    //$text = str_replace("@".$_SESSION["name"], '<ds class="adress">@'.$_SESSION["name"].'</ds>', $text);
    $text = str_replace(":)", '<img src="images/smiley.png" alt="smiley" width="' . tailleSmiley . '" height="' . tailleSmiley . '">', $text);
    $text = str_replace("=)", '<img src="images/images.png" alt="smiley" width="' . tailleSmiley . '" height="' . tailleSmiley . '">', $text);
    $text = str_replace(":-)", '<img src="images/smiley.jpg" alt="smiley" width="' . tailleSmiley . '" height="' . tailleSmiley . '">', $text);
    $text = str_replace(":(", '<img src="images/smileytriste.png" alt="smiley" width="' . tailleSmiley . '" height="' . tailleSmiley . '">', $text);
    $text = str_replace(":-(", '<img src="images/smileytriste2.jpg" alt="smiley" width="' . tailleSmiley . '" height="' . tailleSmiley . '">', $text);
    $text = str_replace(":o", '<img src="images/etonne.jpg" alt="smiley" width="' . tailleSmiley . '" height="' . tailleSmiley . '">', $text);
    $text = str_replace(":tchin:", '<img src="images/tchin.jpg" alt="smiley" width="' . tailleSmiley . '" height="' . tailleSmiley . '">', $text);
    $text = str_replace(":yeah:", '<img src="images/yeah.png" alt="smiley" width="' . tailleSmiley . '" height="' . tailleSmiley . '">', $text);
    $text = str_replace(":sun:", '<img src="images/vacances.jpg" alt="smiley" width="' . tailleSmiley . '" height="' . tailleSmiley . '">', $text);
    $text = str_replace(":evil:", '<img src="images/evil.jpg" alt="smiley" width="' . tailleSmiley . '" height="' . tailleSmiley . '">', $text);
    $text = str_replace(":music:", '<img src="images/music.jpg" alt="smiley" width="300" height="300">', $text);
    $text = str_replace("^^", '<img src="images/cute.png" alt="smiley" width="' . tailleSmiley . '" height="' . tailleSmiley . '">', $text);
    $text = str_replace("salut", "suce", $text);
    $text = str_replace("cc", '<img src="images/smiley.png" alt="smiley" width="' . tailleSmiley . '" height="' . tailleSmiley . '">', $text);
    $text = str_replace("pognon", '<img src="images/pognon.jpg" alt="smiley" width="' . tailleSmiley . '" height="' . tailleSmiley . '">', $text);
    $text = str_replace(":p", '<img src="images/langue.jpg" alt="smiley" width="' . tailleSmiley . '" height="' . tailleSmiley . '">', $text);
    $text = str_replace(":fat:", '<img src="images/grod.png" alt="smiley" width="' . tailleSmiley . '" height="' . tailleSmiley . '">', $text);

    return $text;
}


function insererBalises($pseudo)
{
    $pseudo = '<div class="utilisateurs">' . $pseudo . '<br></div>' . "\r\n";
    return $pseudo;
}
