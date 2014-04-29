<?php
    $title = 'Artistes';
?><h1><span class="icone">l</span> Artistes</h1>
<ul>
<?php
	$premier_ul = true;
	$artiste_actuel = null;
    
	$requete_morceaux = $sqlite->query('SELECT DISTINCT album,artist FROM morceaux WHERE user_id=' . $sqlite->quote($_SESSION['id']) . ' ORDER BY artist ASC');
	while($album = $requete_morceaux->fetch()){
		if($album['artist'] != $artiste_actuel){
		    $artiste_actuel = $album['artist'];
		    if($premier_ul){
			echo '<li>' . $album['artist'] . ' <a title="Obtenir le fichier M3U" class="m3u icone" target="_blank" href="m3u.php?username=' . $_SESSION['uname'] . '&artist_name=' . urlencode($album['artist']) . '">v</a> <span title="Écouter ' . $album['artist'] . '" class="ecouter icone" onclick="charger_playlist(\'' . urlencode($album['artist']) . '\', null, null, 0);">a</span></li><ul>';
			$premier_ul = false;
		    }
		    else{
			echo '</ul><li>' . $album['artist'] . ' <a title="Obtenir le fichier M3U" class="m3u icone" target="_blank" href="m3u.php?username=' . $_SESSION['uname'] . '&artist_name=' . urlencode($album['artist']) . '">v</a> <span title="Écouter ' . $album['artist'] . '" class="ecouter icone" onclick="charger_playlist(\'' . urlencode($album['artist']) . '\', null, null, 0);">a</span></li><ul>';			}
		}
		if(file_exists('data/' . $_SESSION['uname'] . '/pictures/' . md5($album['album']) . '.png'))
			echo '<li><a class="ajax" href="?p=album&album_name=' . urlencode($album['album']) . '&artist_name=' . urlencode($album['artist']) . '"><img src="data/' . $_SESSION['uname'] . '/pictures/' . md5($album['album']) . '.png" />' . $album['album'] . '</a></li>';
		else
			echo '<li><a class="ajax" href="?p=album&album_name=' . urlencode($album['album']) . '&artist_name=' . urlencode($album['artist']) . '"><img src="theme/images/inconnu.png" />' . $album['album'] . '</a></li>';
	}
	
	if($premier_ul == true && $artiste_actuel == null) // Si il n'y a aucun artiste
	    echo '<p>Rien n\'a été trouvé. Pourquoi ne pas importer de la musique?</p>';
?>
</ul></ul>