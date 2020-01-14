 var usersRecStatus = "<?PHP echo $usersStatus; ?>";
    if(userRecStatus == "a") {
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