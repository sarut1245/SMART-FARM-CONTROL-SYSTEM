<?php if (empty($header)) : ?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $Title ?></title>
    <meta name="keywords" content="" />
	<meta name="description" content="" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/main.css?v=11" rel="stylesheet">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.mask.min.js"></script>
    <script type="text/javascript" src="js/validator.js"></script>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" media="print" href="css/print.css?v=1" type="text/css">
  </head>
<body>    
    <div class="container wrapper">            
        
    <nav class="navbar raised main-navbar navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!--<a class="navbar-brand" href="index.php"><img src="images/logo.png" /></a>-->
            <a class="navbar-brand" href="index.php"><?php echo $Title ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="#" class="dropdown-toggle" data-toggle="dropdown">เมนูหลัก</a>
                        <ul class="dropdown-menu">
                            <li><a href="index.php">หน้าหลัก</a></li>                    
                            <li><a href="setuptimer.php">ตั้งค่าเวลา</a></li>
                            <li><a href="reports.php">รายงาน</a></li>
                            
                            <?php if ($IsAdmin) : ?>
                            <li><a href="admin.php">จัดการผู้ใช้งาน</a></li>
                            <?php endif ?>
                        </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if ($User_Id <= 0) : ?>
                    <!--<li><a href="register.php"><i class="glyphicon glyphicon-pencil"></i> ลงทะเบียน</a></li>-->
                    <li><a href="login.php"><i class="glyphicon glyphicon-log-in"></i> เข้าสู่ระบบ</a></li>
                <?php else: ?>
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $User['title'] ?> (<?php echo $UserTypes[ $User['user_type'] ] ?>) <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="user_edit.php">แก้ไขข้อมูลสมาชิก</a></li>                    
                            <li><a href="logout.php">ออกจากระบบ</a></li>                    
                        </ul>
                    </li>                           
                    
                <?php endif; ?>                
            </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>  
    <div class="navbar-fixed-padding"></div>
        
        <div class="content">
<?php 
   $header = true;
   endif; 
?>