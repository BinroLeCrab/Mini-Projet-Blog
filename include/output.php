<?php

function formConnexion() {
    $reponse= "";
    
    $reponse.="<form action=\"index.php?log\" method=\"post\">\n";
    $reponse.=" <label for=\"login\">Login :</label><br>\n";
    $reponse.=" <input type=\"text\" id=\"login\" name=\"login\" required/><br>\n";
    $reponse.=" <label for=\"mdp\">Mot de passe :</label><br>\n";
    $reponse.=" <input type=\"password\" id=\"mdp\" name=\"mdp\" required/><br>\n";
    $reponse.=" <input type=\"submit\" value=\"Se connecter\"/><br>\n";
    $reponse.="</form>\n";
    $reponse.="<a href=\"index.php?newuser\">Créer un compte</a>\n";
    
    return $reponse;
}

function formInscription() {
    $reponse= "";
    
    $reponse.="<form action=\"index.php?incription\" method=\"post\">\n";
    $reponse.=" <label for=\"name\">Votre nom d'utilisateur :</label><br>\n";
    $reponse.=" <input type=\"text\" id=\"name\" name=\"name\" required/><br>\n";
    $reponse.=" <label for=\"mail\">Votre adresse mail :</label><br>\n";
    $reponse.=" <input type=\"text\" id=\"mail\" name=\"mail\" required/><br>\n";
    $reponse.=" <label for=\"login\">Votre login :</label><br>\n";
    $reponse.=" <input type=\"text\" id=\"login\" name=\"login\" required/><br>\n";
    $reponse.=" <label for=\"mdp\">Votre mot de passe :</label><br>\n";
    $reponse.=" <input type=\"password\" id=\"mdp\" name=\"mdp\" required/><br>\n";
    $reponse.=" <input type=\"submit\" value=\"Créer un compte\"/><br>\n";
    $reponse.="</form>\n";
    
    return $reponse;
}

function formBillet() {
    $reponse= "";
    
    $reponse.="<form action=\"index.php?AddBi\" method=\"post\">\n";
    $reponse.=" <label for=\"titre\">Titre de votre billet :</label><br>\n";
    $reponse.=" <input type=\"text\" id=\"titre\" name=\"titre\" required/><br>\n";
    $reponse.=" <label for=\"pitch\">Une description ?</label><br>\n";
    $reponse.=" <input type=\"text\" id=\"pitch\" name=\"pitch\" required/><br>\n";
    $reponse.=" <label for=\"content_bi\">Que souhaitez vous dire ?</label><br>\n";
    $reponse.=" <textarea id=\"content_bi\" name=\"content\"></textarea>\n";
    $reponse.=" <input type=\"submit\" value=\"Publier\"/><br>\n";
    $reponse.="</form>\n";
    
    return $reponse;
}

function formulaireComm($id) {
    $reponse= "";
    
    $reponse.=sprintf("<form action=\"index.php?AddCom&id_billet=%s\" method=\"post\">\n", $id);
    $reponse.=" <label for=\"content_com\">Que souhaitez vous dire ?</label><br>\n";
    $reponse.=" <textarea id=\"content_com\" name=\"content\" required></textarea>\n";
    $reponse.=" <input type=\"submit\" value=\"Publier le commentaire\"/><br>\n";
    $reponse.="</form>\n";
    
    return $reponse;
}

function echoListeBillet() {
    $reponse= "";
    $reponse.= "<p>Les 3 derniers billets publiés :</p>\n";
    $reponse.= "<section>\n";
    $billets = billetListeAcc();
    foreach ($billets as $billet) {
        $reponse.=sprintf("    <a class=\"BilletCards\" href=\"index.php?id_billet=%s\">\n", $billet['id_billet']);
        $reponse.=sprintf("        <h2>%s</h2>\n", $billet['titre_billet']);
        $reponse.=sprintf("        <p>%s</p>\n", $billet['pitch']);
        $reponse.= "    </a>\n";
    }

    if (isset($_SESSION["user"]) && ($_SESSION['user']['autority'] == 317)) {
        $reponse.= "    <a href=\"index.php?newBi\">Ajouter un billet</a>\n";
    }

    $reponse.= "</section>\n";
    $reponse.= "<a href=\"index.php?archive\">Voir tout les billets</a>\n";

    return $reponse;
}

function echoArchive() {
    $reponse= "";
    $reponse.= "<h1>Archives</h1>\n";
    $reponse.= "<p>Les billets du plus récent au plus ancien.</p>\n";
    $reponse.= "<section>\n";
    $billets = billetListe();
    foreach ($billets as $billet) {
        $reponse.=sprintf("    <a class=\"BilletCards\" href=\"index.php?id_billet=%s\">\n", $billet['id_billet']);
        $reponse.=sprintf("        <h2>%s</h2>\n", $billet['titre_billet']);
        $reponse.=sprintf("        <p>%s</p>\n", $billet['pitch']);
        $reponse.= "    </a>\n";
    }

    if (isset($_SESSION["user"]) && ($_SESSION['user']['autority'] == 317)) {
        $reponse.= "    <a href=\"index.php?newBi\">Ajouter un billet</a>\n";
    }

    $reponse.= "</section>\n";

    return $reponse;
}

function echoBillet($id) {
    $reponse= "";
    $reponse.= "<a href=\"index.php\">Retour à l'accueil</a>\n";
    $reponse.= "<section class=\"Billet\">\n";
    $billet = billet($id);
    
    $reponse.=sprintf(" <h1>%s</h1>\n", $billet['titre_billet']);
    $reponse.=sprintf(" <p>Par %s le %s</p>\n", $billet["nom"], date('d/m - H:i', strtotime($billet['date'])));
    $reponse.=sprintf(" <p>%s</p>\n", $billet['pitch']);
    $reponse.=sprintf(" <p>%s</p>\n", $billet['content_billet']);

    if (isset($_SESSION['user']) && (($_SESSION['user']['autority'] == 317) || ($_SESSION['user']['id'] == $billet['id']))){
        $reponse.=sprintf(" <a href=\"index.php?SuprrBi&id_billet=%s\">Supprimer</a>\n", $id);
    }
    $reponse.= "</section>\n";

    $comments = commentaires($id);
    $reponse.= "<section class=\"commentaires\">\n";
    if (count($comments)>0) {

        $reponse.= "<button class=\"\" type=\"button\" id=\"show\">Voir les commentaires</button>\n";

        $reponse.= "<article id=\"comment\">\n";

        foreach ($comments as $comment) {
            $reponse.=" <div>\n";
            $reponse.=sprintf("     <p>Par %s le %s</p>\n", $comment["nom"], date('d/m - H:i', strtotime($comment['date_comment'])));
            $reponse.=sprintf("     <p>%s</p>\n", $comment['content_comment']);

            if (isset($_SESSION['user']) && (($_SESSION['user']['autority'] == 317) || ($_SESSION['user']['id'] == $comment['id']))){
                $reponse.=sprintf("     <a href=\"index.php?SuprrCom&id_comm=%s\">Supprimer</a>\n", $comment['id_comment']);
            }

            $reponse.=" </div>\n";
        }

        $reponse.= "</article>\n";
        
    } else {
        $reponse.= "    <p>Il n'y a pas encore de commentaires pour ce billet</p>\n";
        // $reponse.= "    <a href=\"index.php#comment?AddCom\">Ajouter un comentaires</a>\n";
    }

    if (isset($_SESSION["user"])) {

        $reponse.= formulaireComm($id);

    } else {
        $reponse.="<p>Vous devez être <a href=\"index.php?conn\">connecter</a> pour commenter ce Billet</p>\n";
    }

    $reponse.= "</section>\n";

    return $reponse;
}

function adminPannel(){
    
    $reponse = "";

    $BD = adminPan();

    $reponse.= "    <h1>Admin Pannel</h1>\n";
    $reponse.=sprintf("     <p>Bienvenu sur votre pannel administrateur %s</p>\n", $_SESSION['user']['nom']);
    $reponse.= "    <section>\n";
    $reponse.= "        <a href=\"index.php\">Retour à l'accueil</a>\n";
    $reponse.="         <br>\n";

    $reponse.="         <article>\n";
    $reponse.="             <h3>Utilisateurs</h3>\n";
    $reponse.="             <table>\n";
    $reponse.="                 <thead>\n";
    $reponse.="                     <tr>\n";
    $reponse.="                         <th>Id User</th>\n";
    $reponse.="                         <th>Login</th>\n";
    $reponse.="                         <th>Nom</th>\n";
    $reponse.="                         <th>Mail</th>\n";
    $reponse.="                         <th>Mots de passe</th>\n";
    $reponse.="                         <th>Autorité</th>\n";
    $reponse.="                     </tr>\n";
    $reponse.="                 </thead>\n";
    $reponse.="                 <tbody>\n";

    foreach ($BD['user'] as $value) {
        $reponse.= "                        <tr>\n";
        $reponse.=sprintf("                            <td>%s</td>\n", $value["id"]);
        $reponse.=sprintf("                            <td>%s</td>\n", $value["login"]);
        $reponse.=sprintf("                            <td>%s</td>\n", $value["nom"]);
        $reponse.=sprintf("                            <td>%s</td>\n", $value["mail"]);
        $reponse.=sprintf("                            <td>%s</td>\n", $value["motpass"]);
        $reponse.=sprintf("                            <td>%s</td>\n", $value["autority"]);
        if ($value["autority"] != 317) {
            $reponse.=sprintf("                            <td><a href=\"index.php?SuprrUs&id_us=%s\">Supprimer</a></td>\n", $value["id"]);
        }

        $reponse.= "                        </tr>\n";
    }

    $reponse.="                 </tbody>\n";
    $reponse.="             </table>\n";
    $reponse.="         </article>\n";

    $reponse.="         <article>\n";
    $reponse.="             <h3>Billets</h3>\n";
    $reponse.="             <table>\n";
    $reponse.="                 <thead>\n";
    $reponse.="                     <tr>\n";
    $reponse.="                         <th>Id</th>\n";
    $reponse.="                         <th>Nom de l'auteur</th>\n";
    $reponse.="                         <th>Date</th>\n";
    $reponse.="                         <th>Titre</th>\n";
    $reponse.="                         <th>Pitch</th>\n";
    $reponse.="                         <th>Contenu</th>\n";
    $reponse.="                         <th></th>\n";
    $reponse.="                     </tr>\n";
    $reponse.="                 </thead>\n";
    $reponse.="                 <tbody>\n";

    foreach ($BD['billet'] as $value) {
        $reponse.= "                        <tr>\n";
        $reponse.=sprintf("                            <td>%s</td>\n", $value["id_billet"]);
        $reponse.=sprintf("                            <td>%s</td>\n", $value["nom"]);
        $reponse.=sprintf("                            <td>%s</td>\n", date("d/m/Y - H:i", strtotime($value["date"])));
        $reponse.=sprintf("                            <td>%s</td>\n", $value["titre_billet"]);
        $reponse.=sprintf("                            <td>%s</td>\n", substr($value["pitch"], 0, 100));
        $reponse.=sprintf("                            <td>%s</td>\n", substr($value["content_billet"], 0, 300));
        $reponse.=sprintf("                            <td><a href=\"index.php?SuprrBi&id_billet=%s&Admin\">Supprimer</a></td>\n", $value["id_billet"]);
        $reponse.= "                        </tr>\n";
    }

    $reponse.="                 </tbody>\n";
    $reponse.="             </table>\n";
    $reponse.="         </article>\n";

    $reponse.="         <article>\n";
    $reponse.="             <h3>Commentaires</h3>\n";
    $reponse.="             <table>\n";
    $reponse.="                 <thead>\n";
    $reponse.="                     <tr>\n";
    $reponse.="                         <th>Id</th>\n";
    $reponse.="                         <th>Nom de l'auteur</th>\n";
    $reponse.="                         <th>Date</th>\n";
    $reponse.="                         <th>Titre du billet</th>\n";
    $reponse.="                         <th>Contenu</th>\n";
    $reponse.="                         <th></th>\n";
    $reponse.="                     </tr>\n";
    $reponse.="                 </thead>\n";
    $reponse.="                 <tbody>\n";

    foreach ($BD['commentaire'] as $value) {
        $reponse.= "                        <tr>\n";
        $reponse.=sprintf("                            <td>%s</td>\n", $value["id_comment"]);
        $reponse.=sprintf("                            <td>%s</td>\n", $value["nom"]);
        $reponse.=sprintf("                            <td>%s</td>\n", date("d/m/Y - H:i", strtotime($value["date_comment"])));
        $reponse.=sprintf("                            <td>%s</td>\n", $value["titre_billet"]);
        $reponse.=sprintf("                            <td>%s</td>\n", $value["content_comment"]);
        $reponse.=sprintf("                            <td><a href=\"index.php?SuprrCom&id_comm=%s&Admin\">Supprimer</a></td>\n", $value["id_comment"]);
        $reponse.= "                        </tr>\n";
    }

    $reponse.="                 </tbody>\n";
    $reponse.="             </table>\n";
    $reponse.="         </article>\n";

    $reponse.= "    </section>\n";

    return $reponse;
}

?>

<!-- substr('abcdef', 0, 8) -->

<!-- echo password_hash("", PASSWORD_DEFAULT); -->