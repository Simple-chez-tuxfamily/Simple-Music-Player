<?php
	if (!defined('ROOT')) {
        define('DS', DIRECTORY_SEPARATOR);
        define('ROOT', str_replace(array('/core','/installation'),'',dirname(__FILE__)).DS);
    }
    if(!empty($_POST['pseudo']) AND !empty($_POST['pwd1']) AND !empty($_POST['pwd2'])){
        if($_POST['pwd1'] == $_POST['pwd2']){
            $sqlite = new PDO('sqlite:../core/private/data.db');
            $user = $sqlite->quote($_POST['pseudo']);
            $pass = $sqlite->quote(sha1($_POST['pseudo'] . $_POST['pwd1'] . $_POST['pseudo']));
	    	$sqlite->query('DELETE FROM users');
            $sqlite->query('INSERT INTO users (username, password, admin) VALUES(' . $user . ',' . $pass . ', "1")');
            

			if(mkdir(ROOT.'data/' . $_POST['pseudo'] . '/pictures',0755,true)) {
				if(mkdir(ROOT.'data/' . $_POST['pseudo'] . '/songs',0755,true)) {
			    	header('Location: index.php?ok');
			    }
			    else {
			    	header('Location: index.php?err');
			    }
		    } 
		    else {
		    	header('Location: index.php?err');
		    }
        }
        else{
            header('Location: index.php?err');
        }
    }
    else{
        header('Location: index.php?err');
    }
?>