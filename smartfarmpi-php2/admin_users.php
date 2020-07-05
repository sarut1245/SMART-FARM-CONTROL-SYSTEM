<?php
	require('config.php');

    $PageTitle = "จัดการผู้ใช้งานระบบ";
    
    $TablePage = "?page=users";
    $EditPage = "?page=user_edit";

    $TbName = 'users';
    $TbPrimaryKey = 'user_id';

    if (!$User) 
        die('please login');

    $Tx = $_REQUEST;

	$res = 0;
	
	$Id = trim( $_REQUEST['id'] );
    $mode = $_REQUEST['mode'];

	if ($Id > 0)
	{
		switch ($mode) {
			case 'admin':
				$res = DynDb_Update($TbName, array('user_type', 'admin', "WHERE {$TbPrimaryKey} = {$Id}"));
				break;
			case 'del':
				$res = DynDb_Delete($TbName, "WHERE {$TbPrimaryKey} = {$Id}");
				break;
		}
	}

    $S = trim( $Tx['s'] );
    $type = $Tx['type'];

    $Where = '';
    $Conds = array();
    if ($S != '')
        $Conds[] = "(username LIKE '%{$S}%')";
    if ($type != '')
        $Conds[] = "(user_type = '$type')";

    if (count($Conds) > 0)
        $Where = "WHERE " . implode(' AND ', $Conds);

    $Tb = DynDb_SelectTable("SELECT * FROM `{$TbName}` $Where ORDER BY {$TbPrimaryKey} ");


?>

<div class="panel panel-primary">
    <div class="panel-heading">
  	<h2 class="panel-title"><?php echo $PageTitle; ?> </h2>
    </div>
    <div class="panel-body">
        <a href="<?php echo $EditPage ?>" class="btn btn-primary pull-right">สร้างใหม่</a>
        
    <?php if ($res > 0) : ?>
    <div class="alert alert-success">
      ทำการอัพเดทรายการเรียบร้อยแล้ว
    </div>
    <?php endif;?>
        
    <form class="form-horizontal" method="get" action="#" enctype="multipart/form-data">
    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
	<div class="form-group">
		<label class="col-sm-2 control-label" for="s" >ประเภท</label>
		<div class="col-sm-2">
			<?php
            echo MakeSelect('type', $UserTypes, $Tx['type']);
            ?>
		</div>
		<label class="col-sm-1 control-label" for="s" >ค้นหา</label>
		<div class="col-sm-3">
			<input type="text" class="form-control" id="s" name="s" placeholder="" value="<?php echo $Tx['s'] ?>">
		</div>
		<div class="col-xs-2">
			<button type="submit" class="btn btn-primary">ค้นหา</button>
        </div>
	</div>
	</form>
        

    <table class="table table-condensed table-striped">
        <thead>
        <tr><th>Username</th>
            <th>ชื่อ-สกุล</th>
            <th>Email</th>
            <th>ประเภท</th>
            <!--<th>การจัดการ</th>-->
        </tr>
        </thead>
        <tbody>
    <?php foreach ($Tb as $Tr) : ?>
    <tr>
        <td><a href="<?php echo "{$EditPage}&id={$Tr[$TbPrimaryKey]}" ?>"><?php echo $Tr['username'] ?> </a></td>
        <td><a href="<?php echo "{$EditPage}&id={$Tr[$TbPrimaryKey]}" ?>"><?php echo $Tr['title'] ?></a></td>
        <td><?php echo $Tr['email'] ?></td>
        <td><?php echo $UserTypes[ $Tr['user_type'] ] ?></td>
        <!--<td>
            <a href="<?php echo "{$EditPage}&id={$Tr[$TbPrimaryKey]}" ?>">แก้ไข</a> |
            <a href="<?php echo "{$TablePage}&id={$Tr[$TbPrimaryKey]}&mode=del" ?>"
               class="confirm"
               onclick="return confirm('ต้องการลบรายการนี้ ?')">ลบ</a>
        </td>-->
    </tr>

    <?php endforeach; ?>
        </tbody>
    </table>
  </div>
</div>
