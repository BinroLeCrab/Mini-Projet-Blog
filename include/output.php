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

function echoListeBillet() {
    $reponse= "";
    $reponse.= "<section>\n";
    $billets = billetListe();
    foreach ($billets as $billet) {
        $reponse.=sprintf("    <a href=\"index.php?id_billet=%s\">\n", $billet['id_billet']);
        $reponse.=sprintf("        <h2>%s</h2>\n", $billet['titre_billet']);
        $reponse.=sprintf("        <p>%s</p>\n", $billet['content_billet']);
        $reponse.= "    </a>\n";
    }
    $reponse.= "</section>\n";

    return $reponse;
}

function echoBillet($id) {
    $reponse= "";
    $reponse.= "<section>\n";
    $billet = billet($id);
    
    $reponse.=sprintf(" <h1>%s</h1>\n", $billet['titre_billet']);
    $reponse.=sprintf(" <p>%s</p>\n", $billet["nom"]);
    $reponse.=sprintf(" <p>%s</p>\n", $billet['content_billet']);

    $reponse.= "</section>\n";

    return $reponse;
}

?>