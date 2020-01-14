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
    <div class="PageTitle">Users Search</div>
 
  <!-- Search Section Start -->
    <form name="frmSearchUsers" method="post"
          id="frmSearchUsers"
          action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
      <div class="displayPane">
        <div class="displayPaneCaption">Search:</div>
        <div>
          <input name="txtSearch" id="txtSearch" placeholder="Search User"
          style="width: calc(100% - 115px)" value="<?PHP echo $txtSearch; ?>">
          <button type="button" id="btnSearch">Search</button>
          <button type="button" id="btnAddRec">Add</button>
        </div>
      </div>
      <input type="hidden" name="a" value="listusers">
    </form>
    <!-- Search Section End -->
    
<?PHP
if($action == "listusers") {
    ?>
    <div>
      <table style="width: calc(100% - 15px);border: #cccccc solid 1px">
        <tr style="background: #eeeeee">
          <td style="width: 80px;border-left: #cccccc solid 1px"><b>User ID</b></td>
          <td style="border-left: #cccccc solid 1px"><b>Username </b></td>
          
		  <td style="width: 80px;text-align: right"><b>first name</b></td>
		  <td style="width: 80px;text-align: right"><b>last name</b></td>
		  <td style="width: 80px;text-align: right"><b>Group</b></td>
		  <td style="width: 80px;text-align: right"><b>Status</b></td>
        </tr>
    <?PHP
	openDB();
      $query =
	 "SELECT *
         FROM
            lpa_users
         WHERE lpa_user_status <> 'D'
         AND
            (lpa_user_ID LIKE '%$txtSearch%' OR
			lpa_user_username LIKE '%$txtSearch%' OR
			lpa_user_password LIKE '%$txtSearch%' OR
			lpa_user_firstname LIKE '%$txtSearch%' OR
			lpa_user_lastname LIKE '%$txtSearch%' OR
			lpa_user_group LIKE '%$txtSearch%')"; 
			
	$result = $db->query($query);
      $row_cnt = $result->num_rows;
      if($row_cnt >= 1) {
        while ($row = $result->fetch_assoc()) {
          $sid = $row['lpa_user_ID'];
          ?>
		 <tr class="hl">
            <td style="cursor: pointer;border-left: #cccccc solid 1px">
		       <?PHP echo $row['lpa_user_username']; ?>
            </td>
            
            <td style="cursor: pointer;border-left: #cccccc solid 1px">
		       <?PHP echo $row['lpa_user_firstname']; ?>
            </td>
		 <td style="cursor: pointer;border-left: #cccccc solid 1px">
		       <?PHP echo $row['lpa_user_lastname']; ?>
            </td>
			<td style="cursor: pointer;border-left: #cccccc solid 1px">
		       <?PHP echo $row['lpa_user_group']; ?>
            </td>
          </tr>
		
	  <?PHP } ?>
	  </table>
	  </div>
	  <?PHP } }?>
<!-- search section list end -->
</div>
<script>
    var action = "<?PHP echo $action; ?>";
    var search = "<?PHP echo $txtSearch; ?>";
    if(action == "recUpdate") {
        alert("Record Updated!");
        navMan("users.php?a=listusers&txtSearch=" + search);
    }
    if(action == "recInsert") {
        alert("Record Added!");
        navMan("users.php?a=listusers&txtSearch=" + search);
    }
    if(action == "delRec") {
        alert("Record Deleted!");
        navMan("users.php?a=listusers&txtSearch=" + search);
    }
    function loadUserslist(ID,MODE) {
        window.location = "usersaddedit.php?sid=" +
            ID + "&a=" + MODE + "&txtSearch=" + search;
    }
    $("#btnSearch").click(function() {
        $("#frmSearchUsers").submit();
    });
    $("#btnAddRec").click(function() {
        loadUserslist("","Add");
    });
    setTimeout(function(){
        $("#txtSearch").select().focus();
    },1);
</script>
