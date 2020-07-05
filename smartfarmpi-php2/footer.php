    </div>
</div>

<?php if (empty($footer)) : ?>
    <footer class="footer row clear">
        <div class="container">
            
          <div class="pull-left;">
              <a href="#"><?php echo $Title ?></a>
          </div>
          <div class="pull-right">
              <a href="http://imk.site" class="hide">imk.site</a>        
          </div>        
        </div>
    </footer>
<?php $footer = true; 
	endif;
?>

<!--
<link href="modules/datetimepickerth/bootstrap-datepicker.css" rel="stylesheet" />
<script src="modules/datetimepickerth/bootstrap-datepicker.th.js"></script>
<script src="modules/datetimepickerth/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>
<script src="modules/datetimepickerth/bootstrap-datepicker-text.js"></script>
<script>
(function($){ $(function(){
    
    $('[data-type=date]').datepicker({
        format: 'dd/mm/yyyy',
        todayBtn: true,
        language: 'th',             
        thaiyear: true              
    }).datepicker("setDate", "0");
    
});})(jQuery);    
</script>
-->

<link rel="stylesheet" type="text/css" href="modules/datatable/datatables.min.css"/>
<script type="text/javascript" src="modules/datatable/datatables.min.js"></script>    
<script>
    (function($){ $(function(){
       $('.table').DataTable({
           "language": { "url": "modules/datatable/thai.json" },           
           //"dom": '<"row col-sm-12"t><"col-sm-4"l><"col-sm-2"i><"col-sm-6"p>',
           "dom": '<"row col-sm-12"t><"col-sm-4"><"col-sm-2"i><"col-sm-6"p>',
           "pageLength": 50,
           "order": []
       });
    });})(jQuery);
</script>
</body>
</html>
