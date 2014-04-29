<!DOCTYPE html>
<html>
    <head>
        <title>Installation - Simple Music Player</title>
	<link type="text/css" rel="stylesheet" href="../core/css.php" />
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
    </head>
    <body id="bg_connexion">
            <?php
                if(isset($_GET['ok']))
                    echo '<div id="notification" style="border-top:4px solid #8BB548">Simple Music Player a été installé avec succès! Supprimez le dossier "installation" pour continuer.</div>';
                elseif(isset($_GET['err']))
                    echo '<div id="notification" style="border-top:4px solid #D63535">Simple Music Player a rencontré une erreur lors de l\'installation! Merci de réessayer.</div>';
                else
                    echo '<div id="notification" style="border-top:4px solid #8BB548">Pour installer Simple Music Player, complétez le formulaire ci-dessous.</div>';
            ?>
	    
	    <div id="connexion">
		<h1>Merci d'avoir choisi Simple Music Player</h1>
		<form id="formulaire" action="install.php" method="post">
		    <input type="text" name="pseudo" placeholder="Nom d'utilisateur..." />
		    <input type="password" name="pwd1" placeholder="Mot de passe..." />
		    <input type="password" name="pwd2" placeholder="Mot de passe (encore)..." />
		    <input type="submit" value="Créer mon compte" />
		</form>
	    </div>
    </body>
</html>