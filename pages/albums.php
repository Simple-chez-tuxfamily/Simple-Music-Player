<?php
    $title = 'Albums';
    
    function tueur_daccents($texte){
        
        $texte = str_replace(array(' ', '(', ')', '"', '«' , '»', '\''), '', $texte);
        
        $texte = htmlentities($texte, ENT_NOQUOTES);
    
        $texte = preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $texte);
        $texte = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $texte); // pour les ligatures e.g. '&oelig;'
        $texte = preg_replace('#&[^;]+;#', '', $texte); // supprime les autres caractères
        
        $texte = strtolower($texte);
            
        return $texte;
    }
?><h1><span class="icone">p</span> Albums</h1>
<ul>
<?php
	$albums = array();

	$requete_morceaux = $sqlite->query('SELECT DISTINCT album,artist FROM morceaux WHERE user_id=' . $sqlite->quote($_SESSION['id']) . ' ORDER BY album ASC');
	while($album = $requete_morceaux->fetch()){
	    $albums[tueur_daccents($album['album'])] = $album;
	}
	
	ksort($albums);
	
	if(count($albums) > 0){
		$lettre_actuelle = null;
		$premier_ul = true;
	
		foreach($albums as $nettoye => $album){
			if($lettre_actuelle !== $nettoye[0]){
				$lettre_actuelle = $nettoye[0];
			    
				if($premier_ul){
					echo '<li>' . strtoupper($lettre_actuelle) . '</li><ul>';
					$premier_ul = false;
				}
				else{
					echo '</ul><li>' . strtoupper($lettre_actuelle) . '</li><ul>';
				}
			}
			
			if(file_exists('data/' . $_SESSION['uname'] . '/pictures/' . md5($album['album']) . '.png'))
				echo '<li><a class="ajax" href="?p=album&album_name=' . urlencode($album['album']) . '&artist_name=' . urlencode($album['artist']) . '"><img src="data/' . $_SESSION['uname'] . '/pictures/' . md5($album['album']) . '.png" /><span class="titrealbum">' . $album['album'] . '</span> de ' . $album['artist'] . '</a></li>';
			else
				echo '<li><a class="ajax" href="?p=album&album_name=' . urlencode($album['album']) . '&artist_name=' . urlencode($album['artist']) . '"><img src="theme/images/inconnu.png" /><span class="titrealbum">' . $album['album'] . '</span> de ' . $album['artist'] . '</a></li>';
		}
	}
	else
		echo '<p>Rien n\'a été trouvé. Pourquoi ne pas importer de la musique?</p>';
?>
</ul>
