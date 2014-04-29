<?php
    $title = 'Changer de mot de passe';
?>
<h1><span class="icone">q</span> Changer mon mot de passe</h1>
<form id="formulaire" action="core/interact.php?action=user&token=<?php echo $_SESSION['token']; ?>" method="POST">
    <input type="password" placeholder="Mot de passe actuel..." name="pwd1" required /><br />
    <input type="password" placeholder="Nouveau mot de passe..." name="pwd2" required /><br />
    <input type="password" placeholder="Nouveau mot de passe (encore)..." name="pwd3" required /><br />
    <input name="nothing" type="submit" value="Changer mon mot de passe" />
</form>