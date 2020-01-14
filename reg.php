<?PHP 
  require('app-lib.php');
  build_header();
?>

<?PHP
  $authChk = true;
  $msg = null;
  

  
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
  
  isset($_POST['txtUserID'])? $userID = $_POST['txtUserID'] : $userID = gen_ID();
  isset($_POST['txtUserName'])? $userName = $_POST['txtUserName'] : $userName = "";
  isset($_POST['txtUserPassword'])? $userPassword = $_POST['txtUserPassword'] : $userPassword = "";
  isset($_POST['txtUserConfirmPassword'])? $userConfirmPassword = $_POST['txtUserConfirmPassword'] : $userConfirmPassword = "";
  isset($_POST['txtUserFirstName'])? $userFirstName = $_POST['txtUserFirstName'] : $userFirstName = "";
  isset($_POST['txtUserLastName'])? $userLastName = $_POST['txtUserLastName'] : $userLastName = "";
  isset($_POST['txtUserAddress'])? $userAddress = $_POST['txtUserAddress'] : $userAddress = "";
  isset($_POST['txtUserPhoneNumber'])? $userPhoneNumber = $_POST['txtUserPhoneNumber'] : $userPhoneNumber = "";
  isset($_POST['txtUserGroup'])? $userGroup = $_POST['txtUserGroup'] : $userGroup = "user";
  isset($_POST['txtUserStatus'])? $userStatus = $_POST['txtUserStatus'] : $userStatus = "a";
  $mode = "insertRec";
  
  $hashed_password = hash("sha512", $userPassword . "kDl*63(7");

  if($action == "insertRec") {
    $query =
      "INSERT INTO lpa_users (
         lpa_user_ID,
         lpa_user_username,
         lpa_user_password,         
         lpa_user_firstname,
         lpa_user_lastname,
		 lpa_user_address,
		 lpa_user_phonenumber,
         lpa_user_group,
		 lpa_user_status
       ) VALUES (
         '$userID',
         '$userName',
         '$hashed_password',
         '$userFirstName',
         '$userLastName',
		 '$userAddress',
		 '$userPhoneNumber',
         '$userGroup',
         '$userStatus'
       )
      ";
    openDB();
	  $result = $db->query($query);
    if($db->error) {
      printf("Errormessage: %s\n", $db->error);
      exit;
    }	else {
      header("Location: reg.php?a=recInsert&txtSearch=".$userID);
      exit;
    }
  }

  $fieldSpacer = "5px";
?>

  <div id="content">
    <div class="PageTitle">New user register page </div>
    <form name="frmUsersRec" id="frmUsersRec" method="post" action="<?PHP echo $_SERVER['PHP_SELF']; ?>">
      <div>
        <input name="txtUserID" id="txtUserID" placeholder="User ID" value="<?PHP echo $userID; ?>" style="width: 100px;" type="hidden" title="User ID">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtUserName" id="txtUserName" placeholder="User Name" value="<?PHP echo $userName; ?>" style="width: 150px;"  title="User Name">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtUserPassword" id="txtUserPassword" placeholder="User Password" value="<?PHP echo $userPassword; ?>" type="password"  title="User Password" onkeyup='check();'><br><br>
		<input name="txtUserConfirmPassword" id="txtUserConfirmPassword" placeholder="User Confirm Password" value="<?PHP echo $userConfirmPassword; ?>" type="password"  title="User Confirm Password" onkeyup='check();' > <span id='message'></span> <br>		
		<input type="checkbox" onclick="visibility()">Show password
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtUserFirstName" id="txtUserFirstName" placeholder="User First Name" value="<?PHP echo $userFirstName; ?>" style="width: 150px;text-align: left"  title="User First Name">
      </div>
	  <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtUserLastName" id="txtUserLastName" placeholder="User Last Name" value="<?PHP echo $userLastName; ?>" style="width: 150px;text-align: left"  title="User Last Name">
      </div>
	  <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtUserAddress" id="txtUserAddress" placeholder="User Address" value="<?PHP echo $userAddress; ?>" style="width: 250px;text-align: left"  title="User Address">
      </div>
	  <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtUserPhoneNumber" id="txtUserPhoneNumber" placeholder="User Phone Number" value="<?PHP echo $userPhoneNumber; ?>" style="width: 150px;text-align: left"  title="User Phone Number">
      </div>
      <div style="margin-top: <?PHP echo $fieldSpacer; ?>">
        <input name="txtUserGroup" id="txtUserGroup" placeholder="User Group" value="<?PHP echo $userGroup; ?>" style="width: 150px;text-align: left" type="hidden" title="User Group">
      </div>
      
      <input name="a" id="a" value="<?PHP echo $mode; ?>" type="hidden">
      <input name="sid" id="sid" value="<?PHP echo $sid; ?>" type="hidden">
      <input name="txtSearch" id="txtSearch" value="<?PHP echo $txtSearch; ?>" type="hidden">
    </form>
    <div class="optBar">
	  <button type="button" id="back" onclick="back">Back to Login page</button>
      <button type="button" id="btnUserSave">Register</button>
     

    </div>
	</div>
	
	<script>
	var action = "<?PHP echo $action; ?>";
    var search = "<?PHP echo $txtSearch; ?>";
    var msg = "<?PHP echo $msg; ?>";
    if(msg) {
    alert(msg);
  }

    $("#btnUserSave").click(function(){
		if(document.getElementById("txtUserName").value == "" || document.getElementById("txtUserPassword").value == "" ||
			document.getElementById("txtUserFirstName").value == "" || document.getElementById("txtUserLastName").value == "" ||
			document.getElementById("txtUserConfirmPassword").value == "" || document.getElementById("txtUserAddress").value == "" || document.getElementById("txtUserPhoneNumber").value == "")
		{
			alert ("You have empty fields");
		}
		else
		{	
			alert("The User has been created successfully!!");
			$("#frmUsersRec").submit();
		}
		});
    setTimeout(function(){
      $("#txtUserName").focus();
    },1);
  </script>
  
 <?PHP 
 // back to login page + password script + confirm password start 
 ?>
  <script>
 
 function loadLogItem(ID,MODE) {
	window.location = "login.php?sid=" +
	ID + "&a=" + MODE ;
	}
	$("#back").click(function() {
	loadLogItem("","Add");
	});
 function visibility() {
	 var x =document.getElementById("txtUserPassword");
	 if (x.type === "password") {
		 x.type = "text";
	 } else {
		 x.type = "password";
	 }
 }	
 var check = function() {
  if (document.getElementById('txtUserPassword').value ==
    document.getElementById('txtUserConfirmPassword').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = 'matching';
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'not matching';
  }
}
</script>
  <?PHP 
 // back to login page + password script + confirm password finish
 ?>



 
<?PHP
build_footer();
?>
	
	