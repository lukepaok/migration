<?php
$DB_CONNECTION='OKANASV1';
$DB_SERVER='192.168.1.70';
$DB_USER='CSDB_ELPIS';
$DB_PSWD='CSDB_ELPIS';
$DB_NAME='orcl_dev';

$DB_TYPE       = 'Oracle';
$ApplName   ="CS Migration";
$ApplNameWin="CS Tools";
$PATH_APPL=str_replace("\config","",dirname(__FILE__));
if ($DB_CONNECTION=='DBG4_CSDB_GEN') { $PATH_APPL='E:/xampp/htdocs/g4cs'; }
$PATH_LIB   = $PATH_APPL.'/lib';
$PATH_LANG  = $PATH_APPL.'/lang/gr';
$PATH_MEDIA = $PATH_APPL.'/media';
$PATH_PARAMS= $PATH_APPL.'/config/params';
$eol='<BR>';
error_reporting (E_ALL & ~E_NOTICE);
date_default_timezone_set('Europe/Athens');
ini_set('default_charset', 'ISO-8859-7');
ini_set('session.gc_Maxlifetime',3600);
ini_set('max_execution_time',1200);
ini_set('session.cache_limiter','');
$GLYear = array(2013=>2013,2014,2015,2016,2017,2018,2019,2020,2021,2022,2023,2024,2025,2026,2027,2028,2029,2030,2031,2032,2033,2034,2035,2036,2037,2038,2039);
?>