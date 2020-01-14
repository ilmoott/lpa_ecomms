<?PHP
  $authChk = true;
  require('app-lib.php');
  isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  if(!$action) {
    isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  }
  isset($_POST['txtSearch'])? $txtSearch = $_POST['txtSearch'] : $txtSearch = "";
  if(!$txtSearch) {
    isset($_REQUEST['txtSearch'])? $txtSearch = $_REQUEST['txtSearch'] : $txtSearch = "";
  }
  build_header($displayName);
?>
  <?PHP build_navBlock(); ?>
  <div id="content">
    <div class="PageTitle">Sales Management Search</div>
 
  <!-- Search Section Start -->
    <form name="frmSearchSales" method="post"
          id="frmSearchSales"
          action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
      <div class="displayPane">
        <div class="displayPaneCaption">Search:</div>
        <div>
          <input name="txtSearch" id="txtSearch" placeholder="Search Sales"
          style="width: calc(100% - 115px)" value="<?PHP echo $txtSearch; ?>">
          <button type="button" id="btnSearch">Search</button>
          <button type="button" id="btnAddRec">Add</button>
        </div>
      </div>
      <input type="hidden" name="a" value="listSales">
    </form>
    <!-- Search Section End -->
    <!-- Search Section List Start -->
<?PHP
if($action == "listSales") {
    ?>
    <div>
      <table style="width: calc(100% - 15px);border: #cccccc solid 1px">
        <tr style="background: #eeeeee">
          <td style="width: 80px;border-left: #cccccc solid 1px"><b>Invoice Number</b></td>
          <td style="border-left: #cccccc solid 1px"><b>Client Name</b></td>
          <td style="width: 80px;text-align: right"><b>Date</b></td>
		  <td style="width: 80px;text-align: right"><b>Amount</b></td>
        </tr>
    <?PHP
	openDB();
      $query =
        "SELECT *
         FROM
            lpa_invoices
         WHERE lpa_inv_status <> 'D'
         AND
            (lpa_inv_no LIKE '%$txtSearch%' OR
			lpa_inv_client_name LIKE '%$txtSearch%' OR
			lpa_inv_date LIKE '%$txtSearch%')"; 
			
      $result = $db->query($query);
      $row_cnt = $result->num_rows;
      if($row_cnt >= 1) {
		  $total = 0;
		 while ($row = $result->fetch_assoc()) { 
		 $total+=$row['lpa_inv_amount'];
		 ?>
		 <tr class="hl">
            <td style="cursor: pointer;border-left: #cccccc solid 1px">
		       <?PHP echo $row['lpa_inv_no']; ?>
            </td>
            <td style="cursor: pointer;border-left: #cccccc solid 1px">
                <?PHP echo $row['lpa_inv_client_name']; ?>
            </td>
            <td style="text-align: right">
		 <?PHP echo $row['lpa_inv_date']; ?>
		 </td>
		 <td style="text-align: right">
		 <?PHP echo $row['lpa_inv_amount']; ?>
           </td>
          </tr>
		 <?PHP }
		 ?>
		 <tr class="h1">
			<td style="width: 80px;border-left: #cccccc solid 1px"><b>total</b></td>
			<td colspan="2">
			<td style="width: 80px;text-align; right">
		 <b><?PHP echo $total; ?></b>
		 </td>
		 </tr>
		 <?PHP
	  } else { ?>
	  <tr>
		<td colspan="3" style="text-align: center">
			No Record Found For: <b><?PHP echo $txtSearch; ?></b>
	  </td>
	  </tr>
	  <?PHP } ?>
	  </table>
	  </div>
<?PHP } ?>
<!-- search section list end -->
</div>
<script>
  var action = "<?PHP echo $action; ?>";
  var search = "<?PHP echo $txtSearch; ?>";
  if(action == "recInsert") {
	  alert("Record Added!");
  navMan("sales.php?a=listSales&txtSearch=" + search);
  }
  $("#btnSearch").click(function() {
    $("#frmSearchSales").submit();
  });
	$("#btnAddRec").click(function() { 
	navMan("salesaddedit.php");
	});
	setTimeout (function(){
	$("#txtSearch").select().focus();
	},1);
  </script>
  
<?PHP
build_footer();
?>