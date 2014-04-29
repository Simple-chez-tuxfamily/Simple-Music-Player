<?php
    $title = 'Importer de la musique';
?>
<h1><span class="icone">m</span> Importer de la musique (maximum <?php echo ini_get('post_max_size'); ?>o)</h1>
<form method="post" action="core/interact.php?action=upload&token=<?php echo $_SESSION['token']; ?>" enctype="multipart/form-data">
    <input type="file" name="sons[]" multiple />
    <input type="submit" value="Valider l'importation" />
</form>