<?PHP
  $authChk = true;
  require('app-lib.php');
  isset($_REQUEST['sid'])? $sid = $_REQUEST['sid'] : $sid = "";
  if(!$sid) {
    isset($_POST['sid'])? $sid = $_POST['sid'] : $sid = "";
  }
  isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  if(!$action) {
    isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  }
  isset($_POST['txtSearch'])? $txtSearch = $_POST['txtSearch'] : $txtSearch = "";
  if(!$txtSearch) {
    isset($_REQUEST['txtSearch'])? $txtSearch = $_REQUEST['txtSearch'] : $txtSearch = "";
  }
  if($action == "delRec") {
    $query =
      "UPDATE lpa_invoices SET
         lpa_inv_status = 'D'
       WHERE
         lpa_Inv_no = '$sid' LIMIT 1
      ";
    openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Errormessage: %s\n", $db->error);
      exit;
    } else {
      header("Location: salesaddedit.php?a=recDel&txtSearch=$txtSearch");
      exit;
    }
  }

  isset($_POST['txtInvNo'])? $salesInvNo = $_POST['txtInvNo'] : $salesInvNo = gen_ID();
  isset($_POST['txtInvDt'])? $salesInvDate = $_POST['txtInvDt'] : $salesInvDate = "";
  isset($_POST['txtInvCl'])? $salesInvCl = $_POST['txtInvCl'] : $salesInvCl = "";
  isset($_POST['txtInvClN'])? $salesInvName = $_POST['txtInvClN'] : $salesInvName = "";
  isset($_POST['txtInvClAdd'])? $salesInvAdd = $_POST['txtInvClAdd'] : $salesInvAdd = "";
  isset($_POST['txtInvAmount'])? $salesInvAmount = $_POST['txtInvAmount'] : $salesInvAmount = "0.00";
  isset($_POST['txtInvStatus'])? $salesInvStatus = $_POST['txtInvStatus'] : $salesInvStatus = "";
  $mode = "insertRec";
  if($action == "updateRec") {
    $query =
      "UPDATE lpa_invoices SET
         lpa_inv_no = '$salesInvNo',
         lpa_inv_date = '$salesInvDate',
         lpa_inv_client_ID = '$salesInvCl',
         lpa_inv_client_name = '$salesInvName',
         lpa_inv_client_address = '$salesInvAdd',
         lpa_inv_amount = '$salesInvAmount',
         lpa_inv_status = '$salesInvStatus'
       WHERE
         lpa_inv_no = '$sid' LIMIT 1
      ";
     openDB();
     $result = $db->query($query);
     if($db->error) {
       printf("Errormessage: %s\n", $db->error);
       exit;
     } else {
         header("Location: salesaddedit.php?a=recUpdate&txtSearch=$txtSearch");
       exit;
     }
  }
  if($action == "insertRec") {
    $query =
      "INSERT INTO lpa_invoices (
         lpa_inv_no,
         lpa_inv_date,
         lpa_inv_client_ID,
         lpa_inv_client_name,
         lpa_inv_client_address,
         lpa_inv_amount,
         lpa_inv_status
       ) VALUES (
         '$salesInvNo',
         '$salesInvDate',
         '$salesInvCl',
         '$salesInvName',
         'salesInvAdd',
         '$salesInvAmount',
         '$salesInvStatus'
       )
      ";
    openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Errormessage: %s\n", $db->error);
      exit;
    } else {
      header("Location: salesaddedit.php?a=recInsert&txtSearch=".$salesInvNo);
      exit;
    }
  }

  if($action == "Edit") {
    $query = "SELECT * FROM lpa_invoices WHERE lpa_inv_no = '$sid' LIMIT 1";
    $result = $db->query($query);
    $row_cnt = $result->num_rows;
    $row = $result->fetch_assoc();
    $salesInvNo     = $row['lpa_inv_no'];
    $salesInvDate   = $row['lpa_inv_date'];
    $salesInvCl   = $row['lpa_inv_client_ID'];
    $salesInvName = $row['lpa_inv_client_name'];
    $salesInvAdd  = $row['lpa_inv_client_address'];
    $salesInvAmount  = $row['lpa_inv_amount'];
    $salesInvStatus = $row['lpa_inv_status'];
    $mode = "updateRec";
  }
  build_header($displayName);
  build_navBlock();
  $fieldSpacer = "5px";
?>

  <div id="content">
    <div class="PageTitle">Sales Record Management (<?PHP echo $action; ?>)</div>
    <form name="frmSalesRec" id="frmSalesRec" method="post" action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
      <div>
        <input name="txtInvNo" id="txtInvNo" placeholder="Inv No" value="<?PHP echo $salesInvNo; ?>" style="width: 100px;" title="Inv No">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtInvDt" id="txtInvDt" placeholder="Inv Date" value="<?PHP echo $salesInvDate; ?>" style="width: 400px;"  title="Inv Date">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtInvCl" id="txtInvCl" placeholder="Client ID" value="<?PHP echo $salesInvCl; ?>" style="width: 400px;"  title="Inv Client ID">
      </div>	  
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtInvClN" id="txtInvClN" placeholder="Client Name" value="<?PHP echo $salesInvName; ?>" style="width: 400px;"  title="Inv Client Name">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtInvClAdd" id="txtInvClAdd" placeholder="Inv Client Add" value="<?PHP echo $salesInvAdd; ?>" style="width: 400px;"  title="Inv Client Address">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtInvAmount" id="txtInvAmount" placeholder="Inv Amount" value="<?PHP echo $salesInvAmount; ?>" style="width: 80px;text-align: right"  title="Inv Amount">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <div>Inv Status:</div>
        <input name="txtStatus" id="txtInvStatusActive" type="radio" value="a">
          <label for="txtInvStatusActive">Active</label>
        <input name="txtStatus" id="txtInvStatusInactive" type="radio" value="i">
          <label for="txtInvStatusInactive">Inactive</label>
      </div>
      <input name="a" id="a" value="<?PHP echo $mode; ?>" type="hidden">
      <input name="sid" id="sid" value="<?PHP echo $sid; ?>" type="hidden">
      <input name="txtSearch" id="txtSearch" value="<?PHP echo $txtSearch; ?>" type="hidden">
    </form>
    <div class="optBar">
      <button type="button" id="btnSalesSave">Save</button>
      <button type="button" onclick="navMan('salesaddedit.php')">Close</button>
      <?PHP if($action == "Edit") { ?>
      <button type="button" onclick="delRec('<?PHP echo $sid; ?>')" style="color: darkred; margin-left: 20px">DELETE</button>
      <?PHP } ?>
    </div>
  </div>
  <script>
    var salesRecStatus = "<?PHP echo $salesInvStatus; ?>";
    if(salesRecStatus == "a") {
      $('#txtInvStatusActive').prop('checked', true);
    } else {
      $('#txtInvStatusInactive').prop('checked', true);
    }
    $("#btnSalesSave").click(function(){
		
		if(document.getElementById("txtInvNo").value == "" || document.getElementById("txtInvDt").value == "" ||
			document.getElementById("txtInvCl").value == "" || document.getElementById("txtInvClN").value == "" || document.getElementById("txtInvClAdd").value == "" ||
			document.getElementById("txtInvAmount").value = 0.00 ||
			document.getElementById("txtInvStatus").value == "")
		{
			alert ("You have empty fields");
		}
		else
		{	
			$("#frmSalesRec").submit ();
		}
		});
    
    function delRec(ID) {
      navMan("salesaddedit.php?sid=" + ID + "&a=delRec");
    }
    setTimeout(function(){
      $("#txtInvClN").focus();
    },1);
  </script>
<?PHP
build_footer();
?>