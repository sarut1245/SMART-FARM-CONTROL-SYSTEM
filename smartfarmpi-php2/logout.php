<?php
    session_start();
    session_destroy();

    $expired_time = time() -1;
    setcookie('user_id', 0, $expired_time);
    setcookie('member_id', 0, $expired_time);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<style type="text/css">
body {
	color:#000;
	background-image: url(../images/images.jpg);
}
</style>
<body>
<script>alert('ออกจากระบบแล้ว')</script>
<script>window.location='index.php'</script>
</body>
</html>

