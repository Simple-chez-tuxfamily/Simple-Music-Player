<?php        
    $sqlite = new PDO('sqlite:private/data.db');
    
    function tueur_daccents($texte){
        $texte = str_replace(array(' ', '(', ')', '"', '«' , '»', '\''), '', $texte);
        
        $texte = htmlentities($texte, ENT_NOQUOTES);
    
        $texte = preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $texte);
        $texte = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $texte); // pour les ligatures e.g. '&oelig;'
        $texte = preg_replace('#&[^;]+;#', '', $texte); // supprime les autres caractères
        
        $texte = strtolower($texte);
            
        return $texte;
    }
    
    // Si l'utilisateur demande un album
    if(isset($_GET['artist_name'], $_GET['album_name'])){
        $requete_morceaux = $sqlite->query('SELECT * FROM morceaux WHERE user_id=' . $sqlite->quote($_SESSION['id']) . ' AND artist=' . $sqlite->quote(urldecode($_GET['artist_name'])) . ' AND album=' . $sqlite->quote(urldecode($_GET['album_name'])) . ' ORDER BY title ASC');
        while($morceau = $requete_morceaux->fetch())
            echo 'data/' . $_SESSION['uname'] . '/songs/' .  $morceau['filename'] . ',;,';
    }
    
    // Si l'utilisateur demande un artiste
    elseif(isset($_GET['artist_name'])){
        $requete_morceaux = $sqlite->query('SELECT * FROM morceaux WHERE user_id=' . $sqlite->quote($_SESSION['id']) . ' AND artist=' . $sqlite->quote(urldecode($_GET['artist_name'])) . ' ORDER BY title ASC');
        while($morceau = $requete_morceaux->fetch())
            echo 'data/' . $_SESSION['uname'] . '/songs/' .  $morceau['filename'] . ',;,';
    }
    
    // Sinon, c'est que l'utilisateur demande toute sa bibliothèque 
    else{
        $sons = array();
        $requete_morceaux = $sqlite->query('SELECT * FROM morceaux WHERE user_id=' . $sqlite->quote($_SESSION['id']) . ' ORDER BY title ASC');
        while($morceau = $requete_morceaux->fetch()){
            $sons[tueur_daccents($morceau['title'])] = $morceau;
        }
        ksort($sons);        
        foreach($sons as $nettoye => $morceau)            
            echo 'data/' . $_SESSION['uname'] . '/songs/' .  $morceau['filename'] . ',;,';
    }

?>