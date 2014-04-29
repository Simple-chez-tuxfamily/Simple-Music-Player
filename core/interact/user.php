<?php
    $sqlite = new PDO('sqlite:private/data.db');
    if(isset($_POST['pwd1'], $_POST['pwd2'], $_POST['pwd3'], $_SESSION['uname'])){
        $pass = $sqlite->quote(sha1($_SESSION['uname'] . $_POST['pwd1'] . $_SESSION['uname']));
        
        $query = $sqlite->query('SELECT id FROM users WHERE password=' . $pass);        
        $cpwd = $query->fetch();
        
        if($_POST['pwd2'] == $_POST['pwd3'] && isset($cpwd['id'])){
            $pass = $sqlite->quote(sha1($_SESSION['uname'] . $_POST['pwd2'] . $_SESSION['uname']));            
            $sqlite->query('UPDATE users SET password=' . $pass . ' WHERE id="' . $_SESSION['id'] . '"');
            
            header('Location: ../index.php?p=parametres&page=compte&msg=3');
        }
        else
            header('Location: ../index.php?p=parametres&page=compte&msg=4');
    }
    else
        header('Location: ../index.php?p=parametres&page=compte&msg=2');
?>
