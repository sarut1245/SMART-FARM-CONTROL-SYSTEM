<?php
	require_once('config.php');

  $login_error = false;

  if ($_POST['mode'] == 'login')
  {
    $username = trim( $_REQUEST['username'] );
    $password = encrypt_password( trim( $_REQUEST['password'] ) );

    $res = DynDb_SelectTable("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' ", true);
    if (count($res) > 0)
    {
      setcookie('user_id', $res['user_id'], time() + 36000);
      header('Location: index.php');
    }
    else
    {
      $login_error = true;
    }
  }

  require('header.php');

?>

<div class="row">
  <div class="col-md-offset-3 col-md-6">
      <div class="panel panel-default" style="margin-top: 80px">
	  <div class="panel-heading">
			<h3 class="panel-title">เข้าสู่ระบบ</h3>
	  </div>
	  <div class="panel-body">
			<form method="post" class="form-horizontal">
      <input type="hidden" name="mode" value="login" />

    <?php if ($login_error) : ?>
    <div class="alert alert-danger">
      ไม่สามารถเข้าสู่ระบบได้ เนื่องจาก ชื่อผู้ใช้งานผิดพลาด หรือ รหัสผิดพลาด
    </div>
    <?php endif;?>

  		<p class="">
  			<label>ผู้ใช้งาน:</label>
  			<input class="form-control" placeholder="Username" name="username" type="text">
  		</p>
  		<p class="">
  			<label>รหัสผ่าน:</label>
  			<input class="form-control" placeholder="Password" name="password" type="password" value="">
  		</p>

        <p class="text-center">
            <button class="btn btn-sm btn-primary btn-lg text-center" type="submit" value="Login">
                เข้าสู่ระบบ
            </button>
        </p>
  	</form>
	  </div>
      </div>

  	

  </div>
</div>



<?php
    require('footer.php');
?>