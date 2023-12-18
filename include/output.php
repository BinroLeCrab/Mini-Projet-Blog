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

?>