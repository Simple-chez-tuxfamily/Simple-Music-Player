<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title; ?> - Simple Music Player</title>
		<meta charset="utf-8" />
		<link rel="shortcut icon" type="image/png" href="theme/images/favicon.png" />
		<link type="text/css" rel="stylesheet" href="core/css.php" />
		<!-- Balises pour les mobiles -->
		<link rel="apple-touch-icon" href="theme/images/favicon.png" />
		<meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
		<!-- Balises pour l'intégration à Windows 8.1 -->
		<meta name="application-name" content="Simple Music Player" />
		<meta name="msapplication-TileColor" content="#894081" />
		<meta name="msapplication-square70x70logo" content="theme/images/w_70.png" />
		<meta name="msapplication-square150x150logo" content="theme/images/w_1150.png" />
		<meta name="msapplication-wide310x150logo" content="theme/images/w_3150.png" />
		<meta name="msapplication-square310x310logo" content="theme/images/w_310.png" />
	</head>
	<body>
	    <nav>
			<ul id="menu">
				<li>Ma bibliothèque</li>
				
					<ul>
						<li><a class="ajax" href="?p=morceaux"><span class="icone illustration lienajax">k</span>Morceaux</a></li>
						<li><a class="ajax" href="?p=albums"><span class="icone illustration lienajax">p</span>Albums</a></li>
						<li><a class="ajax" href="?p=artistes"><span class="icone illustration lienajax">l</span>Artistes</a></li>
					</ul>
				
				<!--Sans doutes implémenté dans la prochaine version \o/-->
				<!--<li>Mes playlists</li>
					<ul>
						<li><a class="ajax" href="?p=playlist&id=1"><span class="icone illustration">k</span>Ma première playlist</a></li>
						<li><a class="ajax" href="?p=nouvelle_playlist" id="nouvelle_playlist"><span class="icone illustration">j</span>Nouvelle playlist...</a></li>
					</ul>-->
				
				<li>Mon compte</li>
					<ul>
						<li><a class="ajax" href="?p=importer"><span class="icone illustration lienajax">m</span>Importer de la musique</a></li>
						<li><a class="ajax" href="?p=motdepasse"><span class="icone illustration lienajax">q</span>Changer de mot de passe</a></li>
						<li><a href="?p=deconnexion"><span class="icone illustration">o</span>Déconnexion</a></li>
					</ul>
				
			</ul>
			
			<div id="jplayer"></div>
		</nav>
			
			<div id="player">
				<div id="infos_lecture">En attente de l'utilisateur...</div>
				<div id="slider"></div>				
				<div class="infosboutons">
					<div id="actuel">--:--</div>
					<div id="shuffle" class="icone">i</div>
					<div id="precedent" class="icone ">h</div>
					<div id="playpause" class="icone">a</div>
					<div id="suivant" class="icone">g</div>
					<div id="repeat" class="icone">f<div id="mode">1</div></div>
					<div id="total">--:--</div>
				</div>
			</div>

	    <div class="clear"></div>
		<div id="content"><?php echo $content; ?></div>
		<div id="notification"></div>
		<script type="text/javascript" src="core/js.php"></script>
		<script>masquer_message();</script>
		<?php
			if(isset($afficher_message_maj) && $afficher_message_maj == true){
				$afficher_message_maj = false;
				
				echo '<script>afficher_message(\'Une mise à jour est disponible. Pour la télécharger, <a href="https://github.com/quent1-fr/Simple-Music-Player/archive/master.zip">cliquez ici</a>.\', 0, 1);</script>';
			}
		?>
	</body>
</html>
