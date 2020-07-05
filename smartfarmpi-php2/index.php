<?php
	require('config.php');

    if (!$User)
    {
        header('Location: login.php');
        exit;
    }

   
    header('Location: main.php');
    exit;

?>