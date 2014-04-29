<?php
    $sqlite = new PDO('sqlite:private/data.db');
    if(!isset($_GET['url']) or empty($_GET['url'])) die('Mauvaise utilisation!');
    
    $nom_fichier = str_replace('data/' . $_SESSION['uname'] . '/songs/', '', $_GET['url']);
    $requete_infos = $sqlite->query('SELECT title, artist FROM morceaux WHERE filename=' . $sqlite->quote($nom_fichier) . ' AND user_id=' . $sqlite->quote($_SESSION['id']));
    $infos = $requete_infos->fetchAll();
    echo $infos[0]['title'] . ' par ' . $infos[0]['artist'];
?>