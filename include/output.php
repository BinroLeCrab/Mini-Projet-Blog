<?php

function formConnexion() {
    $reponse= "";
    
    $reponse.="<form action=\"index.php?log\" method=\"post\">\n";
    $reponse.=" <label for=\"login\">Login :</label><br>\n";
    $reponse.=" <input type=\"text\" id=\"login\" name=\"login\"/><br>\n";
    $reponse.=" <label for=\"mdp\">Mot de passe :</label><br>\n";
    $reponse.=" <input type=\"password\" id=\"mdp\" name=\"mdp\"/><br>\n";
    $reponse.=" <input type=\"submit\" value=\"Se connecter\"/><br>\n";
    $reponse.="</form>\n";
    
    return $reponse;
}

function formBillet() {
    $reponse= "";
    
    $reponse.="<form action=\"index.php?AddBi\" method=\"post\">\n";
    $reponse.=" <label for=\"titre\">Titre de votre billet :</label><br>\n";
    $reponse.=" <input type=\"text\" id=\"titre\" name=\"titre\"/><br>\n";
    $reponse.=" <label for=\"content_bi\">Que souhaitez vous dire ?</label><br>\n";
    $reponse.=" <textarea id=\"content_bi\" name=\"content\"></textarea>\n";
    $reponse.=" <input type=\"submit\" value=\"Publier\"/><br>\n";
    $reponse.="</form>\n";
    
    return $reponse;
}

function echoListeBillet() {
    $reponse= "";
    $reponse.= "<section>\n";
    $billets = billetListe();
    foreach ($billets as $billet) {
        $reponse.=sprintf("    <a class=\"BilletCards\" href=\"index.php?id_billet=%s\">\n", $billet['id_billet']);
        $reponse.=sprintf("        <h2>%s</h2>\n", $billet['titre_billet']);
        $reponse.=sprintf("        <p>%s</p>\n", $billet['pitch']);
        $reponse.= "    </a>\n";
    }
    $reponse.= "    <a href=\"index.php?newBi\">Ajouter un billet</a>\n";
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

    $reponse.= "</section>\n";

    return $reponse;
}

?>