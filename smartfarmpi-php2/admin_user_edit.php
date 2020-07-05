<?php
    require_once('config.php');

    $PageTitle = "จัดการผู้ใช้งานระบบ";
    
    $TablePage = "?page=users";
    $EditPage = "?page=user_edit";

    $TbName = 'users';
    $TbPrimaryKey = 'user_id';

    if ($User == null)
        die('Please login');

	$res = 0;
	

    $func = $_REQUEST['func'];
    $mode = $_REQUEST['mode'];
    $Id = intval($_REQUEST['id']);

    if ($func == 'submit')
    {
        $user_type = $_REQUEST['type'];
        $title = trim( $_REQUEST['title'] );
        $username = trim( $_REQUEST['username'] );
        $email = trim( $_REQUEST['email'] );
        $password = trim( $_REQUEST['password'] );
        $password2 = trim( $_REQUEST['password2'] );
        $first_name = trim( $_REQUEST['first_name'] );
        $last_name = trim( $_REQUEST['last_name'] );
        
        if ($first_name == '')
            $errors[] = "โปรดใส่ ชื่อ-สกุล";
        
        $title = $first_name . ' ' . $last_name;
        if ($title == '')
            $title = $username;
        
        if ($username == '')
            $errors[] = "โปรดใส่ Username ที่ใช้เข้าระบบ";
        if (filter_var($email, FILTER_VALIDATE_EMAIL) == false)
            $errors[] = "โปรดใส่ E-mail ให้ถูกต้อง";
        if ($user_type == '')
            $errors[] = "โปรดเลือกประเภทผู้เข้าใช้งาน";
        
        if ($password != '' && $password != $password2)
            $errors[] = "โปรดยืนยันรหัสผ่านให้้ตรงกัน";        
        
        if (($password != '') && (!$IsAdmin))
        {
            if (strlen($password) < 4) {
                $errors[] = "รหัสผ่านต้องมีตัวอักษรมากกว่า 4 ตัวอักษร";
            }           
        }
        
        $A = array(
            'title', $title,
            'email', $email,            
            'username', $username,
            'user_type', $user_type,     
            'card_id', trim( $_REQUEST['card_id'] ),
            'telephone', trim( $_REQUEST['telephone'] ),         
            'first_name', $first_name,
            'last_name', $last_name
        );
        
        $password = trim( $_REQUEST['password'] );
        if ($password != '')
        {
            $A[] = 'password';
            $A[] = encrypt_password($password);
            
            $email_notify = ($_REQUEST['notify'] != '');
        }
        
        if (count($errors) == 0) 
        {              
            
            /*
            $Files = Get_UploadedFiles('picture');
            if (count($Files) > 0) 
            {            
                $Pictures = Save_UploadedFiles($Files, date('U'));            
                $A[] = 'pictures';
                $A[] = implode(',', $Pictures);
            } */       

            if ($mode == 'update')
            {
                $A[] = "WHERE {$TbPrimaryKey} = {$Id}";
                $res = DynDb_Update($TbName, $A);
            }

            if ($mode == '')
            {
                $res = DynDb_Insert($TbName, $A);
                if ($res > 0)
                    $Id = $res;
            }
        }
	}

    if ($func == 'delete') 
    {
        $res = DynDb_Delete($TbName, " {$TbPrimaryKey} = {$Id} ");
        if ($res)
        {
            echo "<script>window.location = '{$TablePage}'</script>";
            exit;
        }
    }




    if ($Id > 0)
    {
        $Tr = DynDb_SelectTable("SELECT * FROM {$TbName} WHERE {$TbPrimaryKey} = {$Id}", true);
        if (count($Tr) > 0)
        {
            $Tx = $Tr;
            $mode = 'update';
            $password = '';
        }
    }

    $TbFaculty = DynDb_SelectTable("SELECT * FROM `faculty` ");

    $PageTitleMode = ($mode == 'update') ? "แก้ไขรายการ" : "เพิ่มรายการใหม่";

?>

<div class="panel panel-primary">
    <div class="panel-heading">
  	<h2 class="panel-title"><?php echo "$PageTitle - $PageTitleMode" ?></h2>
    </div>
    <div class="panel-body">

    <?php if ($mail_res === true) : ?>
    <div class="alert alert-success">
      ได้ทำการส่งข้อมูลไปยัง Email เรียบร้อยแล้ว
    </div>
    <?php elseif ($mail_res === false): ?>
    <div class="alert alert-warning">
      Mail Error: <?php echo $mail_res ?>
    </div>
    <?php endif;?>
        
    <?php if (($mode == '') && ($res > 0)) : ?>
    <div class="alert alert-success">
      ทำการเพิ่มรายการเรียบร้อยแล้ว
    </div>
    <?php endif;?>
        
    <?php if (($mode == 'update') && ($res > 0)) : ?>
    <div class="alert alert-success">
      ทำการอัพเดทรายการเรียบร้อยแล้ว
    </div>
    <?php endif;?>
        
    <?php if (count($errors)) : ?>
    <div class="alert alert-warning">
        <?php foreach($errors as $error) : ?>
        <li><?php echo $error ?></li>
        <?php endforeach ?>
    </div>
    <?php endif;?>    

    <form class="form-horizontal" method="post" enctype="multipart/form-data">
	<input type="hidden" value="submit" name="func" />
	<input type="hidden" value="<?php echo $mode ?>" name="mode" />
	<input type="hidden" value="<?php echo $Id ?>" name="id" />
        
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
		<label class="col-sm-3 control-label" for="first_name" >ชื่อ<span class="required">*</span></label>
		<div class="col-sm-3">
			<input type="text" class="form-control" id="first_name" name="first_name" placeholder="" value="<?php echo $Tx['first_name'] ?>">
		</div>
		<label class="col-sm-1 control-label" for="last_name" >สกุล</label>
		<div class="col-sm-3">
			<input type="text" class="form-control" id="last_name" name="last_name" placeholder="" value="<?php echo $Tx['last_name'] ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="card_id" >รหัสประจำตัว <span class="required">*</span></label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="card_id" name="card_id" data-type="number" placeholder="" value="<?php echo $Tx['card_id'] ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="telephone" >โทรศัพท์</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" id="telephone" name="telephone" data-type="number" placeholder="" value="<?php echo $Tx['telephone'] ?>" maxlength="10">
		</div>
	</div>
        
	<div class="form-group">
		<label class="col-sm-3 control-label" for="email" >Email <span class="required">*</span></label>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="email" name="email" placeholder="" data-type="email"  value="<?php echo $Tx['email'] ?>">
		</div>
	</div>
        
	<div class="form-group">
		<label class="col-sm-3 control-label" for="type">ประเภท <span class="required">*</span></label>
		<div class="col-sm-4">
            <?php
            echo MakeSelect("type", $UserTypes, $Tx['user_type']);
            ?>
		</div>
	</div>
        
	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9">
			<button type="submit" name="func" value="submit" class="btn btn-primary" onclick="return confirm('ยืนยันข้อมูลทั้งหมด ?')">บันทึก</button>
            <a href="<?php echo $TablePage ?>" class="btn btn-warning">ยกเลิก</a>            
			<button type="submit" name="func" value="delete" class="btn btn-danger" onclick="return confirm('ยืนยันการลบข้อมูลทั้งหมด ?')">ลบรายการ</button>
  
		</div>
	</div>
	</form>


</div>
</div>

