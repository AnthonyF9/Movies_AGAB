<?php
    session_destroy();
    setcookie('auth', '', time()-3600, '/', 'localhost', false, true);
    header('Location: ./index.php');
?>
