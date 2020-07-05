<?php
	require('config.php');

    if (count($User) <= 0)
        die('Please login');

    $res = 0;
	
    $Tx = $User;

    $func = $_REQUEST['func'];
    $mode = $_REQUEST['mode'];
    $Id = intval($User['user_id']);

    if ($func == 'submit')
    {
        $username = trim( $_REQUEST['username'] );
        $password = trim( $_REQUEST['password'] );
        $password2 = trim( $_REQUEST['password2'] );
        $email = trim( $_REQUEST['email'] );
        $title = trim( $_REQUEST['title'] );
        $telephone = trim( $_REQUEST['telephone'] );
        $address = trim( $_REQUEST['address'] );
        if ($title == '')
            $title = $username;
        
        if (filter_var($email, FILTER_VALIDATE_EMAIL) == false)
            $errors[] = "โปรดใส่ E-mail ให้ถูกต้อง";
        
        if ($password != '' && $password != $password2)
            $errors[] = "โปรดยืนยันรหัสผ่านให้้ตรงกัน";    
        
        if (($password != '') && (!$IsAdmin))
        {
            if (strlen($password) < 6) {
                $errors[] = "รหัสผ่านต้องมีตัวอักษรมากกว่า 6 ตัวอักษร";
            }
            
        }
        
        $A = array(
            'title', $title,
            'email', $email,
            'username', $username,
            'address', $address,
            'telephone', $telephone
        );
        
        $password = trim( $_REQUEST['password'] );
        if ($password != '')
        {
            $A[] = 'password';
            $A[] = encrypt_password($password);
        }
        
        $A[] = " WHERE user_id = {$Id}";
        
        if (count($errors) == 0) 
        {              
            $res = DynDb_Update('users', $A);
            if ($res > 0)
            {
                $Id = $res;
            }
        }
	}

    require('header.php');

?>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        
        <div class="panel panel-default">
            <div class="panel-heading">
      	         <h2 class="panel-title">แก้ไขข้อมูลสมาชิก</h2>
            </div>
            <div class="panel-body">
                
                <p>โปรดกรอกข้อมูลสมาชิกให้ถูกต้องเพื่อประโยชน์ของท่าน</p>
                
                <?php if (($mode == '') && ($res > 0)) : ?>
                <div class="alert alert-success">
                  ได้ทำการแก้ไขข้อมูลเรียบร้อยแล้ว
                </div>
                
                <p class="text-center">
                    <a href="index.php" class="btn btn-warning">ย้อนกลับ</a>
                </p>
                
                <?php else: ?>
                
                <?php if (count($errors)) : ?>
                <div class="alert alert-warning">
                    <?php foreach($errors as $error) : ?>
                    <li><?php echo $error ?></li>
                    <?php endforeach ?>
                </div>
                <?php endif;?>    
                
                <form class="form-horizontal" method="post" action="#">
                <input type="hidden" value="submit" name="func" />
                <h3></h3>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="title" >ชื่อแสดง <span class="required">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="title" name="title" placeholder="" value="<?php echo $Tx['title'] ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="email" >Email <span class="required">*</span> </label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="email" name="email" data-type="email" placeholder="" value="<?php echo $Tx['email'] ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="telephone" >โทรศัพท์</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="telephone" name="telephone" data-type="number" placeholder="" value="<?php echo $Tx['telephone'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="address" >ที่อยู่</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="address" name="address" placeholder=""><?php echo $Tx['address'] ?></textarea>
                    </div>
                </div>
                    
                    
                <hr/>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="username" >Username <span class="required">*</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="username" name="username" placeholder="" value="<?php echo $Tx['username'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="password" >ตั้งรหัสผ่าน <span class="required">*</span></label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" id="password" name="password" placeholder="" value="<?php echo $password ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="password2" >ยืนยันรหัสผ่าน <span class="required">*</span></label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" id="password2" name="password2" placeholder="" value="<?php echo $password ?>">
                    </div>
                </div>

                <hr/>
                <div class="form-group">
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-primary" onclick="">บันทึก</button>
                        <a href="#" class="btn btn-warning" onclick="history.back();">ยกเลิก</a>
                    </div>
                </div>
                </form>
            </div>
        </div>

        
    <?php endif;?>        
  </div>
    
</div>
<?php require('footer.php') ?>