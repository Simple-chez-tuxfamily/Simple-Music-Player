<?php
    if(!isset($_GET['album_name'], $_GET['artist_name']))
	die('Album inexistant!');
    
    $requete_morceaux = $sqlite->query('SELECT * FROM morceaux WHERE user_id=' . $sqlite->quote($_SESSION['id']) . ' AND album=' . $sqlite->quote(urldecode($_GET['album_name'])) . ' AND artist=' . $sqlite->quote(urldecode($_GET['artist_name'])));
    
    $title = urldecode($_GET['album_name']) . ' par ' . urldecode($_GET['artist_name']);
	
?><h1><span class="icone">p</span> <em><?php echo urldecode($_GET['album_name']) . '</em> par ' . urldecode($_GET['artist_name']); ?></h1>

<table>
    <a class="bouton" href="#" onclick="charger_playlist('<?php echo $_GET['artist_name']; ?>', '<?php echo $_GET['album_name']; ?>', null, 0);">Écouter l'album</a>
    <a class="bouton" href="m3u.php?username=<?php echo $_SESSION['uname']; ?>&artist_name=<?php echo urlencode($_GET['artist_name']); ?>&album_name=<?php echo urlencode($_GET['album_name']); ?>" target="_blank">Obtenir le fichier M3U</a>
    <tr class="titre">
	<th colspan="4">Titres disponibles</th>
    </tr>
    <?php
	$nombre_titres = 0;
	
	while($morceaux = $requete_morceaux->fetch()){
	    $nombre_titres++;
	    echo '<tr class="chanson" onclick="charger_playlist(\'' . $_GET['artist_name'] . '\', \'' . $_GET['album_name'] . '\',\'' . $morceaux['filename'] . '\');"><td>' . $morceaux['title'] . '</td><td>' . $morceaux['artist'] . '</td><td>' . $morceaux['album'] . '</td><td>' . gmdate('i:s', $morceaux['duration']) . '</td></tr>';
	}
	
	if($nombre_titres == 0)
	    die('Album inexistant!');
    ?>
</table>
