<?php
    session_start();

    require_once("include/CommSQL.php");
    require_once("include/output.php");
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Mini Projet Blog</title>
        <link rel="stylesheet" type="text/css" href="style/style.css"/>
        <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    </head>
    <body>
        <h1>Le blog !</h1>
        <?php
            // $mdpHash = password_hash("toto01", PASSWORD_DEFAULT);
            // echo $mdpHash;

            if (isset($_GET["log"])) {
                
                header(traitelogin($_POST["login"], $_POST["mdp"]));

            } else if (isset($_GET["conn"])) {

                echo formConnexion();

            } else if (isset($_GET["logerr"])) {

                echo 'les problèmes ...';

            } else if (isset($_GET["deco"])) {

                $_SESSION = array();
                session_destroy();
                header('location:index.php');

            } else if (isset($_GET['AddBi'])){

                echo "<p>Votre billet va être publié !</p>\n";

                header(traitebillet($_POST['titre'], $_POST['content'], $_SESSION['user']['id']));

            } else if (isset($_GET['AddCom'])){

                echo "<p>Votre commentaire va être publié !</p>\n";

                header(traitecomment($_GET['id_billet'], $_POST['content'], $_SESSION['user']['id']));

            } else {
                
                if (isset($_SESSION["user"])) {

                echo "<h2>Bonjour ".$_SESSION["user"]["nom"]."</h2>\n";
                echo "<a href=\"index.php?deco\">Se déconnecter</a>\n";

                } else {

                echo "<a href=\"index.php?conn\">Se connecter</a>\n";

                }

                if (isset($_GET['newBi']) && isset($_SESSION["user"])){

                    echo formBillet();

                } else if (isset($_GET['newBi'])) {
                    echo "<p>connecter vous pour publier un billet</p>\n";
                }else if (isset($_GET['id_billet'])) {

                    echo echoBillet($_GET['id_billet']);

                } else {
                    echo echoListeBillet();
                }

            }
        ?>

    <script>
        tinymce.init({
            selector: '#content_bi'
        });
    </script>
    </body>
</html>

<!-- 
     _____     _____
    |  _  |   |  _  |
   -| | | |---| | | |-
    |_____| 7 |_____|  ~B!nro~
    
-->

<!-- tinymce -->

<!-- $test = ['coucou' => 'test', 'blabla' => 'ça marche'];
echo $test['coucou'];
echo $test['blabla']; -->