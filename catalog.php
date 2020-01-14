<?php
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
isset($_REQUEST['sid'])? $sid = $_REQUEST['sid'] : $sid = "";
if(!$sid) {
    isset($_POST['sid'])? $sid = $_POST['sid'] : $sid = "";
}
isset($_REQUEST['name'])? $name = $_REQUEST['name'] : $name = "";
if(!$name) {
    isset($_POST['name'])? $name = $_POST['name'] : $name = "";
}
isset($_REQUEST['description'])? $description = $_REQUEST['description'] : $description = "";
if(!$description) {
    isset($_POST['description'])? $description = $_POST['description'] : $description = "";
}
isset($_REQUEST['price'])? $price = $_REQUEST['price'] : $price = "";
if(!$price) {
    isset($_POST['price'])? $price = $_POST['price'] : $price = "";
}
isset($_REQUEST['quantity'])? $quantity = $_REQUEST['quantity'] : $quantity = "";
if(!$quantity) {
    isset($_POST['quantity'])? $quantity = $_POST['quantity'] : $quantity = "";
}
  build_header($displayName);
?>

<?php

if($action == "addToCar")
{
    $ses = "Cart".$sid;
    $_SESSION[$ses] = $quantity;
}
?>
<html>
<body>
<?php
//print_r(array_values($item_array));
//session_destroy();
?>

<?php build_navBlock(); ?>
<html lang="en">
<div id="content">
    <div class="PageTitle">Catalog Management Search</div>

    <!-- Search section -->
    <form name="frmSearchCatalog" method="post"
          id="frmSearchCatalog"
          action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
        <div class="displayPane">
            <div>
                <input name="txtSearch" id="txtSearch" placeholder="Search Product"
                       style="width: calc(100% - 70px)" value="<?php echo $txtSearch; ?>">
            </div>
        </div>
        <input type="hidden" name="a" value="listProduct">
    </form>
    <div>
        <table style="width: calc(100% - 15px);border: antiquewhite solid 1px">
            <tr style="background: bisque">
                <td style="text-align: center; border-left: antiquewhite solid 1px"><b>Product Name</b></td>
            <td style="text-align: center; border-left: antiquewhite solid 1px"><b>Product Description</b></td>
            <td style="text-align: center; border-left: antiquewhite solid 1px"><b>Product Price</b></td>
            <td style="text-align: center; border-left: antiquewhite solid 1px"><b>Quantity</b></td>
            <td style="width: 100px; text-align: center; border-left: antiquewhite solid 1px"><b>Add to Chart</b></td>
            </tr>

            <?php
            openDB();
            $query =
                "SELECT
            *
         FROM
            lpa_stock
         WHERE
            lpa_stock_ID LIKE '%$txtSearch%' AND lpa_stock_status <> 'D'
         OR
            lpa_stock_name LIKE '%$txtSearch%' AND lpa_stock_status <> 'D'

         ";
            $result = $db->query($query);
            $row_cnt = $result->num_rows;
            if($row_cnt >= 1) {
            while ($row = $result->fetch_assoc()) {
            $sid = $row['lpa_stock_ID'];
            ?>
            <tr class="hl">
                <td style="cursor: pointer; border-left: antiquewhite solid 1px">
                    <input type="hidden" name="idProduct" value="<?php echo $sid; ?>">
                    <?php echo $name; ?>
                </td>
                <td style="text-align: right>
                    <input type="hidden" name="description" value="<?php echo $description; ?>">
                <?php $description= $row['lpa_stock_desc']; ?>
                    <?php echo $description; ?>
                </td>
                <td style="text-align: right>
                    <input type="hidden" name="price" value="<?php echo $price; ?>">
                <?php $price= $row['lpa_stock_price']; ?>
                <?php echo $price; ?>
                </td>
                <td style="text-align: right">
                    <input name="txtQuantity" id="txtQuantity <?php echo  $sid; ?>" placeholder="">
                </td>
                <td onclick="addToCar(<?PHP echo $sid; ?>)">
                    <img id="btnAddCar" src="add.png" style="height: 40px; width: 40px; cursor: pointer; text-align: center" >
                </td>
            </tr>
            <?php }
            }else { ?>
            <tr>
                <td colspan="3" style="text-align: center">No Record Found for: <b><?php echo $txtSearch; ?></b></td>
            </tr>
            <?php }?>

        </table>
    </div>
</div>
<script>
    var action = "<?php echo $action; ?>";
    var search = "<?php echo $txtSearch; ?>";
    if (action == "addToCar") {
        alert("Item Added to the Shopping Cart!");
        navMan("catalog.php?a=listProduct&txtSearch=" + search);
    }
    function addToCar(ID) {
        var Quantity = $("#txtQuantity" + ID).val();
        window.location = "catalog.php?a=addToCar&sid=" + ID + "&quantity=" + Quantity;
    }
    $("#btnSearch").click(function () {
        $("#frmSearchCatalog").submit();
    });
    setTimeout(function () {
        $("#txtSearch").select().focus();
    },1);
</script>

</body>
</html>
<?php
build_footer();
?>


