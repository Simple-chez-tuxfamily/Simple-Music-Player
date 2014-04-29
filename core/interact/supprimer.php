<?php
    if(isset($_GET['ids'])){
        $ids_a_supprimer = explode(',', substr($_GET['ids'], 0, -1));
        
        $sqlite = new PDO('sqlite:private/data.db');
        
        foreach($ids_a_supprimer as $id){
            $requete_chanson = $sqlite->query('SELECT filename FROM morceaux WHERE user_id=' . $sqlite->quote($_SESSION['id']) . ' AND id=' . $sqlite->quote($id));
            $chanson = $requete_chanson->fetch();
            
            if(count($chanson) > 0){
                $requete_chanson = $sqlite->query('DELETE FROM morceaux WHERE user_id=' . $sqlite->quote($_SESSION['id']) . ' AND id=' . $sqlite->quote($id));
                unlink('../data/' . $_SESSION['uname'] . '/songs/' . $chanson['filename']);
            }
        }
    }
    
    header('Location: ../index.php?p=morceaux');
?>