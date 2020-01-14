<?PHP
$authChk = true;
require('app-lib.php');
isset($_POST['a'])? $action = $_POST['a'] : $action ="";
if(!$action) {
    isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  }
  isset($_POST['txtSearch'])? $txtSearch = $_POST['tztSearch'] : $txtSearch = "";
  if(!$txtSearch) {
    isset($_REQUEST['tztSearch'])? $txtSearch = $_REQUEST['txtSearch'] : $txtSearch = "";
  }
   isset($_POST['sid'])? $sid = $_POST['sid'] : $sid = "";
  if(!$sid) {
	isset($_REQUEST['sid'])? $sid = $_REQUEST['sid'] : $sid = "";
  }
  build_header($displayName);
  ?>
  

  
  <?PHP build_navBlock(); ?>
  <div id="content">
  <div class="PageTitle">Check Out </div>
  <form name="frmSearchSales" method="post"
  id="frmSearchSales"
  action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
  </form>
  <div class="displayPaneCaption"></div>
  <div>
  <input name="PaymentMeth" id="Paymentmeth" placeholder="Payment Method"
  style="text-align:center; width: calc(100% - 1px)"
  </div>
  <table style="width: calc(100% - 1px);border: #cccccc solid 1px">
  <tr style="background: #eeeeee">
  <td onclick="ChkOut(<?PHP echo $sid; ?>)" >
  <img id="btnAddCar" src="picture/amexx.png" style="height; 60px; width:80px; cursor:pointer; text-align:right;" ></td>
  <td onclick="ChkOut(<?PHP echo $sid; ?>)" >
  <img id="btnAddCar" src="picture/commonwealth.png" style="height: 60px;
  width:60px: cursor:pointer; text-align:center;"></td>
  <td onclick="ChkOut(<?PHP echo $sid; ?>)" >
  <img id="btnAddCar" src="picture/paypal.png" style="height; 60px; width:130px; cursor:pointer; text-align:center;" ></td>
   <td onclick="ChkOut(<?PHP echo $sid; ?>)" >
  <img id="btnAddCar" src="picture/m.jpg" style="height; 60px; width:120px; cursor:pointer; text-align:center;" ></td>
   <td onclick="ChkOut(<?PHP echo $sid; ?>)" >
  <img id="btnAddCar" src="picture/download.png" style="height; 60px; width:150px; cursor:pointer; text-align:center;"></td>
   <td onclick="ChkOut(<?PHP echo $sid; ?>)" >
  <img id="btnAddCar" src="picture/anz.png" style="height; 60px; width:120px; cursor:pointer; text-align:center;"></td>
  <td onclick="ChkOut(<?PHP echo $sid; ?>)" >
  <img id="btnAddCar" src="picture/discover.png" style="height; 60px; width:120px; cursor:pointer; text-align:center;"></td>
  
  
  </tr>
  </table> 
 
  <script>
  var action = "<?PHP echo $action; ?>";
  var search = "<?PHP echo $txtSearch; ?>";
  function ChkOut(ID) {
	  alert("Your payment has been Successful!!");
  }
  setTimeout(function(){
	  $("#txtSearch").select().focus();
  },1);
  </script>
  <?PHP
  build_footer();
  ?>