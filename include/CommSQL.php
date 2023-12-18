<?php

// session_start();

const db = "tp_mini_projet_blog";
const host = "localhost";
const user = "root";
const pwd = "";
const dsn = "mysql:host=".host.";dbname=".db;

function coucou() {
    $_SESSION["test"] = 'bleu';
    echo "coucou";
}

function traitelogin($log, $mdp) {
    echo $log;
    echo $mdp;

    //ouvrir
    try
    {
        $db = new PDO(dsn, user, pwd);
    }
    catch (PDOException $e)
    {
        die("Erreur à l'ouverture ! :".$e->getmessage());
    }

    $stmt=$db->prepare('SELECT * FROM utilisateurs WHERE login = :logi /*and mot_de_passe = :mdp*/;');
    $stmt->bindValue(':logi', $log);
    // $stmt->bindValue(':mdp', $mdp);

    $stmt->execute();

    if($stmt->rowCount()){
        $resulCom=$stmt->fetch();

        if (password_verify($mdp, $resulCom['motpass'])){

            $_SESSION['user'] = [
                'id' => $resulCom['id'],
                'nom' => $resulCom['nom'],
                'login' => $resulCom['login']
            ];

            header('location:index.php');

        } else {
            header('location:index.php?logerr');
        }

    } else {
        header('location:index.php?logerr');
    }

    //fermer
	$db = null;

}

            

?>

<!-- $cnxDB = new PDO($this->dsn, $this->user, $this->pwd); -->

<!-- $db = new PDO('mysql:host=localhost;dbname=tp_ident;port3306', 'root', ''); -->

<!-- $stmt=$db->prepare('SELECT * FROM utilisateurs WHERE login = :logi /*and mot_de_passe = :mdp*/;'); -->
<!-- $stmt->bindValue(':logi', $_GET['login']); -->