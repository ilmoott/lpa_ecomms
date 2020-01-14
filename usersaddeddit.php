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
      "UPDATE lpa_users SET
         lpa_user_status = 'D'
       WHERE
         lpa_user_ID = '$sid' LIMIT 1
      ";
    openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Errormessage: %s\n", $db->error);
      exit;
    } else {
      header("Location: users.php?a=delRec&txtSearch=$txtSearch");
      exit;
    }
  }

isset($_POST['txtUserID'])? $userID = $_POST['txtUsersID'] : $userID = gen_ID();
  isset($_POST['txtUserUsername'])? $userUsername = $_POST['txtUserUsername'] : $userUsername = "";
  isset($_POST['txtUserPassword'])? $userPassword = $_POST['txtUserPassword'] : $userPassword = "";
  isset($_POST['txtUserFirstname'])? $userFirstname = $_POST['txtUserFirstname'] : $userFirstname = "0";
  isset($_POST['txtUserLastname'])? $userLastname = $_POST['txtUserLastname'] : $userLastname = "";
  isset($_POST['txtUserGroup'])? $userGroup = $_POST['txtUserGroup'] : $userGroup = "0.00";
  isset($_POST['txtUserStatus'])? $userStatus = $_POST['txtUserStatus'] : $userStatus = "";
  $mode = "insertRec";
   if($action == "updateRec") {
    $query =
      "UPDATE lpa_stock SET
         lpa_user_ID = '$userID',
         lpa_user_username = '$userUsername',
         lpa_user_password = '$userPassword',
         lpa_user_firstname = '$userFirstname',
		 lpa_user_lastname = '$userLastname',
         lpa_user_group = '$userGroup',
         lpa_user_status = '$userStatus'
       WHERE
         lpa_user_ID = '$sid' LIMIT 1
      ";
     openDB();
     $result = $db->query($query);
     if($db->error) {
       printf("Errormessage: %s\n", $db->error);
       exit;
     } else {
         header("Location: users.php?a=recUpdate&txtSearch=$txtSearch");
       exit;
     }
  }
  if($action == "insertRec") {
    $query =
      "INSERT INTO lpa_stock (
         lpa_user_ID,
         lpa_user_username,
         lpa_user_password,
         lpa_user_firstname,
		 lpa_user_lastname,
         lpa_user_group,
         lpa_user_status
       ) VALUES (
         '$userID',
         '$userUsername',
         '$userPassword',
         '$userFirstname',
		 '$userLastname',
         '$userGroup',
         '$userStatus'
       )
      ";
	  openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Errormessage: %s\n", $db->error);
      exit;
    } else {
      header("Location: users.php?a=recInsert&txtSearch=".$userID);
      exit;
    }
  }
  
  
  if($action == "Edit") {
    $query = "SELECT * FROM lpa_users WHERE lpa_user_ID = '$sid' LIMIT 1";
    $result = $db->query($query);
    $row_cnt = $result->num_rows;
    $row = $result->fetch_assoc();
    $userID    = $row['lpa_user_ID'];
    $userUsername  = $row['lpa_user_username'];
    $userPassword   = $row['lpa_user_password'];
    $userFirstname = $row['lpa_user_firstname'];
	$userLastname  = $row['lpa_user_lastname'];
    $userGroup  = $row['lpa_user_group'];
    $userStatus = $row['lpa_user_status'];
    $mode = "updateRec";
  }
  build_header($displayName);
  build_navBlock();
  $fieldSpacer = "5px";
?>

<div id="content">
    <div class="PageTitle">User Record Management (<?PHP echo $action; ?>)</div>
    <form name="frmUsersRec" id="frmUsersRec" method="post" action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
      <div>
        <input name="txtUserID" id="txtUserID" placeholder="User ID" value="<?PHP echo $userID; ?>" style="width: 100px;" title="User ID">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
	  <div>User Username:</div>
        <input name="txtUserUsername" id="txtUserUsername" placeholder="User Username" value="<?PHP echo $userUsername; ?>" style="width: 400px;"  title="User Username ">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
	  <div>User Password:</div>
        <textarea name="txtUserPassword" id="txtUserPassword" placeholder="User Password" style="width: 400px;height: 80px"  title="User Password"><?PHP echo $userPassword; ?></textarea>
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
	  <div>User First Name:</div>
        <input name="txtUserFirstname" id="txtUserFirstname" placeholder="User First Name" value="<?PHP echo $userFirstname; ?>" style="width: 90px;text-align: right"  title="User First Name">
      </div>
	  <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
	  <div>User Last Name:</div>
        <input name="txtUserLastname" id="txtUserLastname" placeholder="User Last Name" value="<?PHP echo $userLastname; ?>" style="width: 90px;text-align: right"  title="User Last Name">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
	  <div>User Group:</div>
        <input name="txtUserGroup" id="txtUserGroup" placeholder="User Group" value="<?PHP echo $userGroup; ?>" style="width: 90px;text-align: right"  title="User Group">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <div>Stock Status:</div>
        <input name="txtStatus" id="txtUserStatusActive" type="radio" value="a">
          <label for="txtUserStatusActive">Active</label>
        <input name="txtStatus" id="txtUserStatusInactive" type="radio" value="i">
          <label for="txtUserStatusInactive">Inactive</label>
      </div>
      <input name="a" id="a" value="<?PHP echo $mode; ?>" type="hidden">
      <input name="sid" id="sid" value="<?PHP echo $sid; ?>" type="hidden">
      <input name="txtSearch" id="txtSearch" value="<?PHP echo $txtSearch; ?>" type="hidden">
    </form>
    <div class="optBar">
      <button type="button" id="btnUserSave">Save</button>
      <button type="button" onclick="navMan('users.php')">Close</button>
      <?PHP if($action == "Edit") { ?>
      <button type="button" onclick="recDel('<?PHP echo $sid; ?>')" style="color: darkred; margin-left: 20px">DELETE</button>
      <?PHP } ?>
    </div>
  </div>
  <script>
  var stockRecStatus = "<?PHP echo $stockStatus; ?>";
    if(stockRecStatus == "a") {
      $('#txtUserStatusActive').prop('checked', true);
    } else {
      $('#txtUserStatusInactive').prop('checked', true);
    }
	
	$("#btnUserSave").click(function(){
		if(document.getElementById("txtUserID").value == ""){
			alert("Please type the user ID!");
		}	
		else {
			if(document.getElementById("txtUserUsername").value == ""){
			alert("Please type the Username!");	
			}
			else {
				if(document.getElementById("txtUserPassword").value == ""){
					alert("Please type the Password!");	
					}
					else {
				if(document.getElementById("txtUserFirstname").value == ""){
					alert("Please type Your Firstname !!");	
					}
					else {
						if(document.getElementById("txtUserLastname").value == ""){
						alert("Please type Your Lastname!!");
						}
							else { $("#frmUsersRec").submit();
			}
				}
					}
						}
    });
    function recDel(ID) {
      navMan("users.php?sid=" + ID + "&a=recDel");
    }
    setTimeout(function(){
      $("#txtUserUsername").focus();
    },1);
  </script>
<?PHP
build_footer();
?>