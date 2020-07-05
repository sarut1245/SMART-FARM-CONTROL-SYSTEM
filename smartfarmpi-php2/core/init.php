<?php
	require_once("dynutils.php");
	require_once("dynformat.php");

    if (!function_exists('mysql_pconnect'))
        require_once('dyndatabasei.php');
    else
        require_once("dyndatabase.php");

	require_once("dynuserfile.php");
	require_once("dynenc.php");

    if (file_exists('modules/mailer/init.php'))
    {
        require_once("modules/mailer/init.php");
        require_once("mail.php");
    }

    if (file_exists('modules/sms/init.php'))
    {
        require_once("modules/sms/init.php");
    }

    error_reporting(E_ERROR | E_PARSE | E_WARNING);
    date_default_timezone_set('Asia/Bangkok');
	
    DynDb_Setup( $Configs );
	DynDb_Connect();

?>