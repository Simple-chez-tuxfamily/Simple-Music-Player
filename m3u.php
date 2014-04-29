<?php
    if(!isset($_GET['username']))
        die('Nom d\'utilisateur non défini!');
        
    $sqlite = new PDO('sqlite:core/private/data.db');
    
    $test_existence_utilsateur = $sqlite->query('SELECT id FROM users WHERE username=' . $sqlite->quote($_GET['username']));
    $resultat_test = $test_existence_utilsateur->fetch();
    if(!isset($resultat_test['id']) or !is_numeric($resultat_test['id']))
        die('Nom d\'utilisateur incorrect!');
        
    $nom_fichier = $_GET['username'] . '_';
    if(isset($_GET['artist_name'], $_GET['album_name']))
        $nom_fichier .= $_GET['artist_name'] . '_' . $_GET['album_name'];
    elseif(isset($_GET['artist_name']))
        $nom_fichier .= $_GET['artist_name'];
    else
        $nom_fichier .= 'bibliotheque';
    
    header('Content-Type: audio/x-mpegurl; charset=utf-8'); // On déclare que c'est un fichier m3u à l'encodage utf-8
    header('Content-Disposition: attachment; filename="' . urlencode($nom_fichier) . '.m3u"'); // Juste histoire d'empêcher la mise en cache...
    
    $url_serveur = 'http://' . $_SERVER['HTTP_HOST'];
    $chemin_script_explose = explode('/', $_SERVER['REQUEST_URI']);
    $taille_cse = count($chemin_script_explose) - 1;

    for($i = 0; $i < $taille_cse; $i++)
        $url_serveur .= $chemin_script_explose[$i] . '/';
    
    echo '#EXTM3U' . "\n";    
    
    // Si l'utilisateur demande un album
    if(isset($_GET['artist_name'], $_GET['album_name'])){
        $requete_morceaux = $sqlite->query('SELECT * FROM morceaux WHERE user_id=' . $sqlite->quote($resultat_test['id']) . ' AND artist=' . $sqlite->quote(urldecode($_GET['artist_name'])) . ' AND album=' . $sqlite->quote(urldecode($_GET['album_name'])) . ' ORDER BY title ASC');
        while($morceau = $requete_morceaux->fetch()){            
            echo '#EXTINF:' . $morceau['duration'] . ',' . $morceau['artist'] . ' - ' . $morceau['title'] . "\n";
            echo $url_serveur . 'data/' . $_GET['username'] . '/songs/' .  $morceau['filename'] . "\n";
        }
    }
    
    // Si l'utilisateur demande un artiste
    elseif(isset($_GET['artist_name'])){
        $requete_morceaux = $sqlite->query('SELECT * FROM morceaux WHERE user_id=' . $sqlite->quote($resultat_test['id']) . ' AND artist=' . $sqlite->quote(urldecode($_GET['artist_name'])) . ' ORDER BY title ASC');
        while($morceau = $requete_morceaux->fetch()){            
            echo '#EXTINF:' . $morceau['duration'] . ',' . $morceau['artist'] . ' - ' . $morceau['title'] . "\n";
            echo $url_serveur . 'data/' . $_GET['username'] . '/songs/' .  $morceau['filename'] . "\n";
        }
    }
    
    // Sinon, c'est que l'utilisateur demande toute sa bibliothèque 
    else{
        $requete_morceaux = $sqlite->query('SELECT * FROM morceaux WHERE user_id=' . $sqlite->quote($resultat_test['id']) . ' ORDER BY title ASC');
        while($morceau = $requete_morceaux->fetch()){            
            echo '#EXTINF:' . $morceau['duration'] . ',' . $morceau['artist'] . ' - ' . $morceau['title'] . "\n";
            echo $url_serveur . 'data/' . $_GET['username'] . '/songs/' .  $morceau['filename'] . "\n";
        }
    }

?>