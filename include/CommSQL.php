<?php

// session_start();
require_once("./log/log.php");

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
                'login' => $resulCom['login'],
                'autority' => $resulCom['autority']
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

function traitebillet($titre, $content, $pitch, $id_user) {

    //ouvrir
    try
    {
        $db = new PDO(dsn, user, pwd);
    }
    catch (PDOException $e)
    {
        die("Erreur à l'ouverture ! :".$e->getmessage());
    }

    //requeter
    $stmt = $db->prepare("INSERT INTO billets (id_user, titre_billet, content_billet, pitch) VALUES (:user, :tit, :cont, :pitch);");
    $stmt->bindValue(':user',$id_user);
    $stmt->bindValue(':tit',$titre);
    $stmt->bindValue(':cont',$content);
    $stmt->bindValue(':pitch',$pitch);

    $stmt->execute();

    //fermer
    $db = null;

    return 'location:index.php';
}

function traitecomment($id_billet, $content, $id_user) {

    if ($content != "") {
        //ouvrir
        try
        {
            $db = new PDO(dsn, user, pwd);
        }
        catch (PDOException $e)
        {
            die("Erreur à l'ouverture ! :".$e->getmessage());
        }

        //requeter
        $stmt = $db->prepare("INSERT INTO commentaires (id_user, id_billet, content_comment) VALUES (:user, :bi, :cont);");
        $stmt->bindValue(':user',$id_user);
        $stmt->bindValue(':bi',$id_billet);
        $stmt->bindValue(':cont',$content);

        $stmt->execute();

        //fermer
        $db = null;
    }

    return 'location:index.php?id_billet='.$id_billet;   
}

function traiteinscription($login, $mdp, $name, $mail, $mdpclair) {

    try
    {
        $db = new PDO(dsn, user, pwd);
    }
    catch (PDOException $e)
    {
        die("Erreur à l'ouverture ! :".$e->getmessage());
    }

    $stmt=$db->prepare('SELECT * FROM utilisateurs WHERE login = :logi /*and mot_de_passe = :mdp*/;');
    $stmt->bindValue(':logi', $login);
    // $stmt->bindValue(':mdp', $mdp);

    $stmt->execute();

    if($stmt->rowCount()){
        return 'location:index.php?newuser&errlog='.$login;

    } else {
        
        $add = $db->prepare("INSERT INTO utilisateurs (login, mail, motpass, nom) VALUES (:log, :mail, :mdp, :name);");
        $add->bindValue(':log',$login);
        $add->bindValue(':mail',$mail);
        $add->bindValue(':mdp',$mdp);
        $add->bindValue(':name',$name);

        $add->execute();

        //fermer
        $db = null;
    }

    return traitelogin($login, $mdpclair);   
}

function supprBillet($id_billet, $org) {

    try
    {
        $db = new PDO(dsn, user, pwd);
    }
    catch (PDOException $e)
    {
        die("Erreur à l'ouverture ! :".$e->getmessage());
    }

    //requeter
    $stmt = $db->prepare("DELETE FROM billets WHERE id_billet = :id; DELETE FROM commentaires WHERE id_billet = :id;");
    $stmt->bindValue(':id',$id_billet);

    $stmt->execute();

    //fermer
    $db = null;

    if ($org != 0){
        return 'location:index.php'; 
    } else {
        return 'location:index?adminPan';
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

    } else {
        header('location:index.php');
    }
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

    $stmt=$db->prepare('SELECT * FROM billets ORDER BY date DESC;');

    $stmt->execute();

    $resulCom=$stmt->fetchAll();

    //fermer
	$db = null;

    if (count($resulCom)>0)
    {
        return $resulCom;
    };
}

function billetListeAcc() {

    try
    {
        $db = new PDO(dsn, user, pwd);
    }
    catch (PDOException $e)
    {
        die("Erreur à l'ouverture ! :".$e->getmessage());
    }

    $stmt=$db->prepare('SELECT * FROM billets ORDER BY date DESC LIMIT 3;');

    $stmt->execute();

    $resulCom=$stmt->fetchAll();

    //fermer
	$db = null;

    if (count($resulCom)>0)
    {
        return $resulCom;
    };
}

function adminPan() {

    try
    {
        $db = new PDO(dsn, user, pwd);
    }
    catch (PDOException $e)
    {
        die("Erreur à l'ouverture ! :".$e->getmessage());
    }

    $bil=$db->prepare('SELECT * FROM billets AS bi INNER JOIN utilisateurs AS us ON bi.id_user = us.id ORDER BY date DESC;');
    $bil->execute();
    $resulCom['billet']=$bil->fetchAll();

    $user=$db->prepare('SELECT * FROM utilisateurs;');
    $user->execute();
    $resulCom['user']=$user->fetchAll();

    $com=$db->prepare('SELECT * FROM commentaires AS co INNER JOIN utilisateurs AS us ON co.id_user = us.id INNER JOIN billets AS bi ON bi.id_billet = co.id_billet ORDER BY date_comment DESC;');
    $com->execute();
    $resulCom['commentaire']=$com->fetchAll();

    //fermer
	$db = null;

    if (count($resulCom)>0)
    {
        return $resulCom;
    };
}

function commentaires ($id_billet) {

    try
    {
        $db = new PDO(dsn, user, pwd);
    }
    catch (PDOException $e)
    {
        die("Erreur à l'ouverture ! :".$e->getmessage());
    }

    $stmt=$db->prepare('SELECT * FROM commentaires AS co INNER JOIN utilisateurs AS us ON co.id_user = us.id WHERE co.id_billet = :id;');
    $stmt->bindValue(':id', $id_billet);

    $stmt->execute();

    $resulCom=$stmt->fetchAll();

    //fermer
	$db = null;

    return $resulCom;

}

function getCom ($id) {

    try
    {
        $db = new PDO(dsn, user, pwd);
    }
    catch (PDOException $e)
    {
        die("Erreur à l'ouverture ! :".$e->getmessage());
    }

    $stmt=$db->prepare('SELECT * FROM commentaires AS co INNER JOIN utilisateurs AS us ON co.id_user = us.id WHERE co.id_comment = :id;');
    $stmt->bindValue(':id', $id);

    $stmt->execute();

    $resulCom=$stmt->fetchAll();

    //fermer
	$db = null;

    if (count($resulCom)==1)
    {
        return $resulCom[0];
    } else {
        header('location:index.php');
    }

}

function supprComment($id_comment, $org) {

    try
    {
        $db = new PDO(dsn, user, pwd);
    }
    catch (PDOException $e)
    {
        die("Erreur à l'ouverture ! :".$e->getmessage());
    }

    //requeter
    $stmt = $db->prepare("DELETE FROM commentaires WHERE id_comment = :id;");
    $stmt->bindValue(':id',$id_comment);

    $stmt->execute();

    //fermer
    $db = null;

    if ($org != 0){
        return 'location:index.php?id_billet='.$org;
    } else {
        return 'location:index?adminPan';
    }
    
}

function supprUser($id) {

    try
    {
        $db = new PDO(dsn, user, pwd);
    }
    catch (PDOException $e)
    {
        die("Erreur à l'ouverture ! :".$e->getmessage());
    }

    //requeter
    $stmt = $db->prepare("DELETE FROM utilisateurs WHERE id = :id;");
    $stmt->bindValue(':id',$id);

    $stmt->execute();

    //fermer
    $db = null;
    return 'location:index?adminPan';
}

?>

<!-- $cnxDB = new PDO($this->dsn, $this->user, $this->pwd); -->

<!-- $db = new PDO('mysql:host=localhost;dbname=tp_ident;port3306', 'root', ''); -->

<!-- $stmt=$db->prepare('SELECT * FROM utilisateurs WHERE login = :logi /*and mot_de_passe = :mdp*/;'); -->
<!-- $stmt->bindValue(':logi', $_GET['login']); -->