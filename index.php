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

                if (isset($_POST['titre']) && isset($_POST['pitch']) && (isset($_SESSION["user"]) && ($_SESSION['user']['autority'] == 317))) {

                    echo "<p>Votre billet va être publié !</p>\n";
                    header(traitebillet($_POST['titre'], $_POST['content'], $_POST['pitch'], $_SESSION['user']['id']));

                } else {
                    header('location:index.php');
                }

            } else if (isset($_GET['SuprrCom']) && isset($_GET['id_comm']) && isset($_SESSION['user'])){

                $comm = getCom($_GET['id_comm']);

                if (($_SESSION['user']['id'] == $comm['id']) || ($_SESSION['user']['autority'] == 317)) {
                    echo "<p>le commentaire ".$comm['id_comment']."</p>\n";
                    if (isset($_GET['Admin'])){
                        header(supprComment($_GET['id_comm'], 0));
                    } else {
                        header(supprComment($_GET['id_comm'], $comm['id_billet']));
                    }
                } else {
                    header('location:index.php');
                }

            } else if (isset($_GET['SuprrBi']) && isset($_GET['id_billet']) && isset($_SESSION['user'])){

                $billet = billet($_GET['id_billet']);

                if (($_SESSION['user']['id'] == $billet['id']) || ($_SESSION['user']['autority'] == 317)) {
                    echo "<p>le billet ".$billet['id_billet']."</p>\n";

                    if (isset($_GET['Admin'])){
                        header(supprBillet($_GET['id_billet'], 0));
                    } else {
                        header(supprBillet($_GET['id_billet'], 1));
                    }
                } else {
                    header('location:index.php');
                }

            } else if (isset($_GET['AddCom'])){

                echo "<p>Votre commentaire va être publié !</p>\n";

                header(traitecomment($_GET['id_billet'], htmlspecialchars($_POST['content']), $_SESSION['user']['id']));

            } else if (isset($_GET['adminPan'])){

                if (isset($_SESSION['user']) && ($_SESSION['user']['autority'] == 317)) {
                    echo adminPannel();
                } else {
                    header('location:index.php');
                }

            } else {
                
                if (isset($_SESSION["user"])) {

                    echo "<h2>Bonjour ".$_SESSION["user"]["nom"]."</h2>\n";
                    echo "<a href=\"index.php?deco\">Se déconnecter</a>\n";

                    if ($_SESSION['user']['autority'] == 317) {
                        echo "<a href=\"index.php?adminPan\">Admin pannel</a>\n";
                    }

                } else {

                    echo "<a href=\"index.php?conn\">Se connecter</a>\n";

                }

                if (isset($_GET['newBi']) && (isset($_SESSION["user"]) && ($_SESSION['user']['autority'] == 317))){

                    echo formBillet();

                } else if (isset($_GET['newBi'])) {

                    header('location:index.php');

                } else if (isset($_GET['id_billet'])) {

                    echo echoBillet($_GET['id_billet']);

                } else if (isset($_GET['archive'])) {

                    echo "<a href=\"index.php\">Retour à l'accueil</a>\n";
                    echo echoArchive();

                } else {
                    
                    echo "<a href=\"index.php?archive\">Archives</a>\n";
                    echo echoListeBillet();
                }

            }
        ?>

        <script>
            tinymce.init({
                selector: '#content_bi'
            });
        </script>
        <script type="text/javascript" src="js/script.js"></script>
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

