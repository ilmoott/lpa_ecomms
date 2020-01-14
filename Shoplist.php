<?PHP
  require('app-lib.php');
  isset($_POST['a'])? $action = $_POST['a'] : $action = "";
  if(!$action) {
    isset($_REQUEST['a'])? $action = $_REQUEST['a'] : $action = "";
  }
  isset($_POST['sid'])? $txtSearch = $_POST['sid'] : $sid = "";
  if(!$sid) {
    	isset($_REQUEST['sid'])? $sid = $_REQUEST['sid'] : $sid = "";
  }
  build_header($displayName);
?>

<?php 
if($action == "removeFromCar")
{	
$ses = "Cart".$sid;
unset($_SESSION[$ses]);
}
?>

<?PHP build_navBlock();?>
<html lang="en">
<div id="content">
<div class="PageTitle">Shopping Cart</div>

<?PHP 
foreach( $_SESSION as $index => $data ){
	if($data != "");
	{
		$ok = 1;
	}
}
if($ok == 1){
	?>
	<div>
	<table style="width: calc(100% - 15px);border: #cccccc solid 1px">
	<tr style="background: #eeeeee">
	<td style="text-align: center;border-left: #cccccc solid 1px"><b> Product Name</b></td>
	<td style="text-align: center;border-left: #cccccc solid 1px"><b> Product Desc</b></td>
	<td style="text-align: center;border-left: #cccccc solid 1px"><b> Product Price</b></td>
	<td style="text-align: center;border-left: #cccccc solid 1px"><b> Quantity</b></td>
	<td style="text-align: center;border-left: #cccccc solid 1px"><b> Total</b></td>
	<td style="width: 80px;text-align:center;border-left: #cccccc solid 1px"><b>Remove from Cart</b></td>
	</tr>
<?PHP
$total = 0;
foreach( $_SESSION as $index => $data )
{
	$dsT = str_replace("Cart","",$index);
	openDB();
	$query = 
	"SELECT
	*
	FROM
	lpa_stock
	WHERE
	lpa_stock_ID LIKE '%$dsT%'
	";
	$result = $db->query($query);
	$row_cnt = $result->num_rows;
	while ($row =$result->fetch_assoc()) {
	$sid = $row['lpa_stock_ID'];
	?>
	<tr>
	<td style="cursor:pointer; border-left: #cccccc solid 1px">
	<?PHP echo $row['lpa_stock_name']; ?>
	</td>
	<td style="text-align: right">
	<?PHP echo $row['lpa_stock_desc']; ?>
	</td>
	<td style="text-align: right">
	<?PHP echo $row['lpa_stock_price']; ?>
	</td>
	<td style="text-align: right">
	<?PHP echo $data; ?>
	</td>
	<td style="text-align: right">
	<?PHP echo $data*$row['lpa_stock_price']; ?>
	</td>
	<td style="text-align: right ">
	
	<img id="btnRmvCar" src="picture/remove.jpg" style="height: 40px; width:40px; cursor:pointer;" onclick=
	"removeFromCar(<?PHP echo $sid ?>)">
</td>
<input name="nmSession" id="nmSession" value="<?PHP echo $index; ?>" type="hidden">
</tr>
<?PHP }?>
 <?PHP }?>	
 <tr>
 <td style="width: 80px;text-align:center;border-left: #cccccc solid 1px"><b>Total</b></td>
 <td colspan="3">
 <td style="width: 80px;text-align:right"><b><?PHP echo $total; ?></b></td>
 </td>
 <td></td>
 </tr>
 </table>
 </div>
 <?PHP } ?>
 <!-- search section list end -->
 
 <?PHP if ($ok >= 1) { ?>
 <button type="button" id="btncheckOut" class="btn" style="allign: right;" onclick="navMan('login.php?killses=true')">checkout</button>
 <?PHP } ?>
 </div>
 <script>
 
 var action = "<?PHP echo $action; ?>";
 if(action == "removeFromCar") {
	 alert("item removed from the shopping cart!!");
 }
 function removeFromCar(ID) {
	 window.location = "shoplist.php?sid=" + ID  + "&a=removeFromCar";
 }
 $("#btnCatalog").click(function() {
	 navman("catalog.php?a=listCatalog");
 });
 $("#btncheckOut").click(function() {
	 navMan("Checkout.php?a=listCatalog");
 });
 setTimeout(function() {
	 $("#txtSearch").select().focus();
 },1);
 </script>
 <?PHP
 build_footer();
 ?>