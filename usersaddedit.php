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
      header("Location: usersaddedit.php?a=recDel&txtSearch=$txtSearch");
      exit;
    }
  }
  $salt = "$2y14$";
  for ($i = 0; $i < 22; $i++) {
	  $salt .=substr("./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789",mt_rand(0,63), 1);
  }
  isset($_POST['txtUserID'])? $UserID = $_POST['txtUserID'] : $UserID = gen_ID();
  isset($_POST['txtUserUsername'])? $UserUsername = $_POST['txtUserUsername'] : $UserUsername = "";
  isset($_POST['txtUserPassword'])? $UserPassword = $_POST['txtUserPassword'] : $UserPassword = "";
  isset($_POST['txtUserFirstname'])? $UserFirstname = $_POST['txtUserFirstname'] : $UserFirstname = "";
  isset($_POST['txtUserLastname'])? $UserLastname = $_POST['txtUserLastname'] : $UserLastname = "";
  isset($_POST['txtUserGroup'])? $UserGroup = $_POST['txtUserGroup'] : $UserGroup = "";
  isset($_POST['txtuserStatus'])? $userStatus = $_POST['txtuserStatus'] : $userStatus = "";
  
  // Blowfish algorithm Encryptation Method //////////
  $blowFish = crypt ($UserPassword, $salt);
  

  
  
  
  if($action == "updateRec") {
    $query =
      "UPDATE lpa_users SET
         lpa_user_ID = '$UserID',
         lpa_user_username = '$UserUsername',
         lpa_user_password = '$UserPassword',
         lpa_user_firstname = '$UserFirstname',
         lpa_user_lastname = '$UserLastname',
         lpa_user_group = '$UserGroup',
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
         header("Location: usersaddedit.php?a=recUpdate&txtSearch=$txtSearch");
       exit;
     }
  }

  $mode = "insertRec";
  if($action == "insertRec") {
    $query =
      "INSERT INTO lpa_users (
         lpa_user_ID,
         lpa_user_username,
         lpa_user_password,
         lpa_user_firstname,
         lpa_user_lastname,
         lpa_user_group,
         lpa_user_status
       ) VALUES (
         '$UserID',
         '$UserUsername',
         '$blowFish',
         '$UserFirstname',
         '$UserLastname',
         '$UserGroup',
         '$userStatus'
       )
      ";
    openDB();
    $result = $db->query($query);
    if($db->error) {
      printf("Errormessage: %s\n", $db->error);
      exit;
    } else {
      header("Location: usersaddedit.php?a=recInsert&txtSearch=".$stockID);
      exit;
    }
  }

  if($action == "Edit") {
    $query = "SELECT * FROM lpa_users WHERE lpa_user_ID = '$sid' LIMIT 1";
    $result = $db->query($query);
    $row_cnt = $result->num_rows;
    $row = $result->fetch_assoc();
    $UserID     = $row['lpa_user_ID'];
    $UserUsername   = $row['lpa_user_username'];
    $UserPassword   = $row['lpa_user_password'];
    $UserFirstname = $row['lpa_user_firstname'];
    $UserLastname  = $row['lpa_user_lastname'];
    $UserGroup  = $row['lpa_user_group'];
    $userStatus = $row['lpa_user_status'];
    $mode = "updateRec";
  }
  build_header($displayName);
  build_navBlock();
  $fieldSpacer = "5px";
  
  //<input  name="txtUserGroup" id="txtUserGroup" placeholder="Users Group"  value="<?PHP echo $UserGroup; ?>" style="width: 400px"  title="Users Group">
  
?>

  <div id="content">
    <div class="PageTitle">Users Record Management (<?PHP echo $action; ?>)</div>
    <form name="frmUsersRec" id="frmUsersRec" method="post" action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
      <div>
        <input name="txtUserID" id="txtUserID" placeholder="Users ID" value="<?PHP echo $UserID; ?>" style="width: 100px;" title="Users ID">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtUserUsername" id="txtUserUsername" placeholder="Users Name" value="<?PHP echo $UserUsername; ?>" style="width: 400px;"  title="Users Name">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtUserPassword" id="txtUserPassword" placeholder="Users Password" value="<?PHP echo $UserPassword; ?>" style="width: 400px"  title="Users Description">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input  name="txtUserFirstname" id="txtUserFirstname" placeholder="User FirstName" value="<?PHP echo $UserFirstname; ?>" style="width: 400px" title="Users FirstName">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input  name="txtUserLastname" id="txtUserLastname" placeholder="Users LastName"  value="<?PHP echo $UserLastname; ?>" style="width: 400px" title="Users LastName">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
	    <select id="cmbGroup" name="cmbGroup" onchange="<?PHP echo $userGroup;?>">
			<option value="User">Select Group</option>
			<option value="Administrator">Admin</option>
			<option value="User">User</option>
		</select>
        
      </div>	  
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <div>Users Status:</div>
        <input name="txtuserStatus" id="txtUsersStatusActive" type="radio" value="a">
          <label for="txtUsersStatusActive">Active</label>
        <input name="txtuserStatus" id="txtUsersStatusInactive" type="radio" value="i">
          <label for="txtUsersStatusInactive">Inactive</label>
      </div>
      <input name="a" id="a" value="<?PHP echo $mode; ?>" type="hidden">
      <input name="sid" id="sid" value="<?PHP echo $sid; ?>" type="hidden">
      <input name="txtSearch" id="txtSearch" value="<?PHP echo $txtSearch; ?>" type="hidden">
    </form>
    <div class="optBar">
      <button type="button" id="btnUsersSave">Save</button>
      <button type="button" onclick="navMan('usersaddedit.php')">Close</button>
      <?PHP if($action == "Edit") { ?>
      <button type="button" onclick="delRec('<?PHP echo $sid; ?>')" style="color: darkred; margin-left: 20px">DELETE</button>
      <?PHP } ?>
    </div>
  </div>
  <script>
    var usersRecStatus = "<?PHP echo $userStatus; ?>";
    if(usersRecStatus == "a") {
      $('#txtUsersStatusActive').prop('checked', true);
    } else {
      $('#txtUsersStatusInactive').prop('checked', true);
    }
    $("#btnUsersSave").click(function(){
        $("#frmUsersRec").submit();
    });
    function delRec(ID) {
      navMan("usersaddedit.php?sid=" + ID + "&a=delRec");
    }
    setTimeout(function(){
      $("#txtUserUsername").focus();
    },1);
  </script>
<?PHP
build_footer();
?>