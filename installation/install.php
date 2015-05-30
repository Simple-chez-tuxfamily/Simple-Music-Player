<?php
    if(!empty($_POST['pseudo']) AND !empty($_POST['pwd1']) AND !empty($_POST['pwd2'])){
        if($_POST['pwd1'] == $_POST['pwd2']){
			// On charge la base de données
            $sqlite = new PDO('sqlite:../core/private/data.db');
        
			// On sanitize l'entrée utilisateur
		    $user = $sqlite->quote($_POST['pseudo']);
            $pass = $sqlite->quote(sha1($_POST['pseudo'] . $_POST['pwd1'] . $_POST['pseudo']));
			
			// On vide la table « users » puis on créé un premier utilisateur
			$sqlite->query('DELETE FROM users');
            $sqlite->query('INSERT INTO users (username, password, admin) VALUES(' . $user . ',' . $pass . ', "1")');
            
			// On créé les dossiers de l'utilisateur
			mkdir('../data');
			mkdir('../data/' . $_POST['pseudo']);
		    mkdir('../data/' . $_POST['pseudo'] . '/pictures');
			mkdir('../data/' . $_POST['pseudo'] . '/songs');
			
			// On supprime les fichiers et le dossier d'installation
			unlink('./index.php');
			unlink('./install.php');
			rmdir('../installation');
			
			// On redirige l'utilisateur vers la page de connexion
            header('Location: ../index.php');
        }
        else
            header('Location: index.php?err');
    }
    else
        header('Location: index.php?err');
?>