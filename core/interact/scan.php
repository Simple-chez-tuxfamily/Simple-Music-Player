<?php
    if(!isset($song_file, $_SESSION['uname']) or (!file_exists(ROOT.'data/' . $_SESSION['uname'] . '/songs/' . $song_file)))
        die('Fichier inexistant');
    
    $song_id3 = $getID3->analyze(ROOT.'data/' . $_SESSION['uname'] . '/songs/' . $song_file);
    
    $filename = utf8_encode($song_id3['filename']);
    $filetype = utf8_encode($song_id3['fileformat']);
    
    if(isset($song_id3['id3v1']['comments']['title'][0]))
        $title = utf8_encode($song_id3['id3v1']['comments']['title'][0]);
        
    elseif(isset($song_id3['id3v2']['comments']['title'][0]))
        $title = utf8_encode($song_id3['id3v2']['comments']['title'][0]);
        
    elseif(isset($original_name))
        $title = utf8_encode($original_name);
        
    else
        $title = $filename;
        
    if(isset($song_id3['id3v1']['comments']['artist'][0]))
        $artist = utf8_encode($song_id3['id3v1']['comments']['artist'][0]);
        
    elseif(isset($song_id3['id3v2']['comments']['artist'][0]))
        $artist = utf8_encode($song_id3['id3v2']['comments']['artist'][0]);
        
    else
        $artist = '(artiste inconnu)';
        
    if(isset($song_id3['id3v1']['comments']['album'][0]))
        $album = utf8_encode($song_id3['id3v1']['comments']['album'][0]);
        
    elseif(isset($song_id3['id3v2']['comments']['album'][0]))
        $album = utf8_encode($song_id3['id3v2']['comments']['artist'][0]);
        
    else
        $album = '(album inconnu)';
    
    if(isset($song_id3['comments']['picture'][0]['data']) && !file_exists(ROOT.'data/' . $_SESSION['uname'] . '/pictures/' . md5($album) . '.png') && $album != '(album inconnu)')
        file_put_contents(ROOT.'data/' . $_SESSION['uname'] . '/pictures/' . md5($album) . '.png', $song_id3['comments']['picture'][0]['data']);
        
    $duration = ceil($song_id3['playtime_seconds']);
    
    $verif_doublon = $sqlite->query('SELECT id FROM morceaux WHERE user_id=' . $sqlite->quote($_SESSION['id']) . ' AND title=' . $sqlite->quote($title) . ' AND artist=' . $sqlite->quote($artist) . ' AND album=' . $sqlite->quote($album) . ' AND duration=' . $sqlite->quote($duration));
    $result = $verif_doublon->fetch();
    
    if(!isset($result['id']) && $duration > 0)        
        $sqlite->query('INSERT INTO morceaux (user_id, filename, filetype, title, artist, album, duration) VALUES (' . $sqlite->quote($_SESSION['id']) . ',' . $sqlite->quote($filename) . ',' . $sqlite->quote($filetype) . ',' . $sqlite->quote($title) . ',' . $sqlite->quote($artist) . ',' . $sqlite->quote($album) . ',' . $sqlite->quote($duration) . ')');
?>
