<?php
    /*
     * js.php est le *SEUL* fichier js à charger. Il s'occupe d'inclure tout les scripts js présents dans javascript/ + du thème utilisateur et de les minifier légèrement
    */
    
    ob_start('ob_gzhandler'); // Compression GZIP
        session_start();
	
        if(!isset($_SESSION['token']))
	    $_SESSION['token'] = '';
	
	if(!isset($_SESSION['uname']))
	    $_SESSION['uname'] = '';
        
        $javascript = file_get_contents('javascript/jquery.js');
        
        $repertoire = opendir('javascript');
        while($contenu = readdir($repertoire)){
            if(!is_dir($contenu) && $contenu != 'jquery.js')
                $javascript .= file_get_contents('javascript/' . $contenu);
        }
        closedir($repertoire);
        
        if(file_exists('../theme/template.js'))
            $javascript .= file_get_contents('../themes/' . $_SESSION['theme'] . '/template.js');
        
  	header('Content-type: text/javascript; charset=utf-8'); // Encodage

        // On empeche le cache
        $ts = gmdate('D, d M Y H:i:s') . ' GMT';
        header('Expires: ' . $ts);
        header('Last-Modified: ' . $ts);
        header('Pragma: no-cache');
        header('Cache-Control: no-cache, must-revalidate');
        
        echo str_replace('[PHP_ADD_TOKEN]', $_SESSION['token'], str_replace('[PHP_ADD_USERNAME]', $_SESSION['uname'], $javascript));
	
    ob_end_flush();
?>
