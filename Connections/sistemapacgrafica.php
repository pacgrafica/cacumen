<?php if (!isset($_SESSION)) {
  session_start();
}?>
<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_sistemapacgrafica = "localhost";
$database_sistemapacgrafica = "pacgrafi_cacumen";
$username_sistemapacgrafica = "pacgrafi_cacumen";
$password_sistemapacgrafica = "mastodon2015";
$sistemapacgrafica = mysql_pconnect($hostname_sistemapacgrafica, $username_sistemapacgrafica, $password_sistemapacgrafica) or trigger_error(mysql_error(),E_USER_ERROR); 
?>