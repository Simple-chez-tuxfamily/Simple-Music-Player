<?php

    $nombre_fichiers = count($_FILES['sons']['name']);
    
    include 'private/getid3/getid3.php';
    
    $getID3 = new getID3;
    $sqlite = new PDO('sqlite:private/data.db');
    
    $url_serveur = 'http://' . $_SERVER['HTTP_HOST'];
    $chemin_script_explose = explode('/', $_SERVER['REQUEST_URI']);
    $taille_cse = count($chemin_script_explose) - 1;

    for($i = 0; $i < $taille_cse; $i++)
        $url_serveur .= $chemin_script_explose[$i] . '/';
    
    for($i = 0; $i < $nombre_fichiers; $i++){

        if($_FILES['sons']['error'][$i]) {     
              switch ($_FILES['sons']['error'][$i]){     
                       case 1: // UPLOAD_ERR_INI_SIZE     
                        die('Le fichier dépasse la limite autorisée par le serveur!');     
                        break;
                    
                       case 2: // UPLOAD_ERR_FORM_SIZE     
                        die('Le fichier dépasse la limite autorisée dans le formulaire!'); 
                        break;
                    
                       case 3: // UPLOAD_ERR_PARTIAL     
                        die('L\'envoi du fichier a été interrompu pendant le transfert!');     
                        break;
                    
                       case 4: // UPLOAD_ERR_NO_FILE     
                        die('Le fichier que vous avez envoyé a une taille nulle !'); 
                        break;     
              }     
        }
        else{
            $song_file = md5(strtolower($_FILES['sons']['name'][$i])) . '.' . substr(strrchr($_FILES['sons']['name'][$i], '.'), 1);
            $original_name = strtolower($_FILES['sons']['name'][$i]);
            
            if(file_exists(ROOT.'data/' . $_SESSION['uname'] . '/songs/' . $song_file))
                die('Le fichier existe déjà!');
                
            move_uploaded_file($_FILES['sons']['tmp_name'][$i], ROOT.'data/' . $_SESSION['uname'] . '/songs/' . $song_file);
            
            include 'interact/scan.php';
            
        }
    }
    
    header('Location: ../index.php');
?>
