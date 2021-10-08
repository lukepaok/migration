<?php
include($PATH_LIB.'/adodb/adodb.inc.php');

function openSQLDB(){
  extract($GLOBALS);
  if ($DB_TYPE == 'MySQL') {
    $db = NewADOConnection('mysql');
    $db -> Connect($DB_SERVER,$DB_USER,$DB_PSWD,$DB_NAME) or die("Unable to connect to MySQL Database");
    $db->Execute('SET character_set_client=greek');
    $db->Execute('SET character_set_connection=greek');
    $db->Execute('SET character_set_results=greek');
  }
  elseif ($DB_TYPE == 'Oracle' ) {
    putenv("NLS_LANG=AMERICAN_AMERICA.EL8ISO8859P7");
    $db = NewADOConnection('oci8');
    $db -> NLS_DATE_FORMAT="YYYY/MM/DD";
    $db -> PConnect($DB_SERVER,$DB_USER,$DB_PSWD,$DB_NAME) or die("Unable to connect to Oracle Database ".$DB_SERVER."-".$DB_USER."-".$DB_PSWD."-".$DB_NAME);
  }
  else {
    echo "Δεν είναι σωστές οι ρυθμίσεις για την σύνδεση με την DataBase";
    $db = false;
  }
  return $db;
}

function f_sqlexe($sqlexe) {
  extract($GLOBALS);
  $rs = openSQLDB() -> Execute($sqlexe) or die("Unable to execute the SQL: $sqlexe".openSQLDB() -> ErrorMsg());
  $ReturnData = $rs->RecordCount();
  $rs->close();
  return $ReturnData;
}

function f_Getfld($sqlGetfld,$DBField) {
  extract($GLOBALS);
  $rs = openSQLDB() -> Execute($sqlGetfld) or die("Unable to execute the SQL: $sqlGetfld".openSQLDB() -> ErrorMsg());
  $ReturnData = $rs->fields["$DBField"];
  $rs->close();
  return $ReturnData;
}

function f_GFsArray($sql,$ArrayName) {
  $rs = openSQLDB() -> Execute($sql) or die("Unable to execute the SQL: $sql".openSQLDB() -> ErrorMsg());
  $OutString=array();
  foreach ($ArrayName as $key => $value) { $OutString[$value]=$rs->fields["$value"]; }
  $rs->close();
  return $OutString;
}

function f_GetTableSet($sqlTableSet) {
  extract($GLOBALS);
  $rs = openSQLDB() -> Execute($sqlTableSet) or die("Unable to execute the SQL: $sqlTableSet.".openSQLDB() -> ErrorMsg());
  $rs->close();
  return $rs;
}

?>
