<?php
//log files
if(!file_exists("log/lpalog.log")){
	fopen("log/lpalog.log","w")or die("Unable to open file!"); 
} //if there any error it catches its description 
function errorhandle($errstr) {
	$log = fopen("log/lpalog.log","a+")or die("unable to open file!!");
	$desc = "Error:".$errstr.PHP_EQL;
	fwrite($log,$desc);
	fclose($log);
}
set_error_handler("errorhandle");
function logFile($logFile) {
	$log = fopen("log/lpalog.log","a+") or die("unable to open file!");
	fwrite($log,@logFile. PHP_EQL);
	fclose($log);
}
?>