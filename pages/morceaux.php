<?php
    $title = 'Morceaux';
    
    function tueur_daccents($texte){
        
        $texte = str_replace(array(' ', '(', ')', '"', '«' , '»', '\''), '', $texte);
        
        $texte = htmlentities($texte, ENT_NOQUOTES);
    
        $texte = preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $texte);
        $texte = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $texte); // pour les ligatures e.g. '&oelig;'
        $texte = preg_replace('#&[^;]+;#', '', $texte); // supprime les autres caractères
        
        $texte = strtolower($texte);
            
        return $texte;
    }
?><h1><span class="icone">k</span> Morceaux</h1></h1><?php
    $sons = array();

    $requete_morceaux = $sqlite->query('SELECT * FROM morceaux WHERE user_id=' . $sqlite->quote($_SESSION['id']) . ' ORDER BY title ASC');
    while($morceau = $requete_morceaux->fetch()){
        $sons[tueur_daccents($morceau['title'])] = $morceau;
    }
    
    ksort($sons);
    
    if(count($sons) > 0){
        echo '<a class="bouton" href="#" id="suppression">Supprimer des morceaux</a>
            <a class="bouton" href="#" id="suppression2">Supprimer les morceaux sélectionnés</a>
            <a class="bouton" href="m3u.php?username=' . $_SESSION['uname'] . '" target="_blank">Obtenir le fichier M3U</a>
            <a class="bouton" onclick="charger_playlist(null, null, null, 0);">Tout écouter</a>
        <table>';
        
        $lettre_actuelle = null;
        
        foreach($sons as $nettoye => $morceau){
            if($lettre_actuelle !== $nettoye[0]){
                $lettre_actuelle = $nettoye[0];
                echo '<tr class="titre"><th colspan="5">' . strtoupper($lettre_actuelle) . '</th></tr>';
            }
            
            echo '<tr class="chanson" onclick="charger_playlist(null, null, \'' . $morceau['filename'] . '\');"><td>' . $morceau['title'] . '</td><td>' . $morceau['artist'] . '</td><td>' . $morceau['album'] . '</td><td>' . gmdate('i:s', $morceau['duration']) . '</td><td class="supprzone"><input name="i' . $morceau['id'] . '" type="checkbox" /></td></tr>';
        }
    }
    else
        echo '<p>Rien n\'a été trouvé. Pourquoi ne pas importer de la musique?</p>';
?></table>