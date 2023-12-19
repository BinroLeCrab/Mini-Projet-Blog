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

            //fermer
            $db = null;     
            return 'location:index.php';

        } else {
            //fermer
            $db = null;
            return 'location:index.php?logerr';
        }

    } else {
        //fermer
        $db = null;
        return 'location:index.php?logerr';
    }

}

function billet($id) {
    try
    {
        $db = new PDO(dsn, user, pwd);
    }
    catch (PDOException $e)
    {
        die("Erreur à l'ouverture ! :".$e->getmessage());
    }

    $stmt=$db->prepare('SELECT * FROM billets AS bi INNER JOIN utilisateurs AS us ON bi.id_user = us.id WHERE bi.id_billet = :id;');
    $stmt->bindValue(':id', $id);

    $stmt->execute();

    $resulCom=$stmt->fetchAll();

    //fermer
	$db = null;

    if (count($resulCom)==1)
    {
        return $resulCom[0];
    };
}

function billetListe() {

    try
    {
        $db = new PDO(dsn, user, pwd);
    }
    catch (PDOException $e)
    {
        die("Erreur à l'ouverture ! :".$e->getmessage());
    }

    $stmt=$db->prepare('SELECT * FROM billets ;');

    $stmt->execute();

    $resulCom=$stmt->fetchAll();

    //fermer
	$db = null;

    if (count($resulCom)>0)
    {
        return $resulCom;
    };
}

            

?>

<!-- $cnxDB = new PDO($this->dsn, $this->user, $this->pwd); -->

<!-- $db = new PDO('mysql:host=localhost;dbname=tp_ident;port3306', 'root', ''); -->

<!-- $stmt=$db->prepare('SELECT * FROM utilisateurs WHERE login = :logi /*and mot_de_passe = :mdp*/;'); -->
<!-- $stmt->bindValue(':logi', $_GET['login']); -->