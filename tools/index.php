<?php
session_start();
include('instart.php');
include($PATH_LANG.'/msg.php');
?>
<HTML>
<HEAD><TITLE><?php print $ApplNameWin.': '.$TitleWin ?></TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=iso-8859-7">
  <LINK href="../lib/migration.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" language="JavaScript1.2" src="../lib/menu/stmenu.js"></script>
</HEAD>
<BODY>
<TABLE width="100%" border="0" cellpadding="0" cellspacing="0"><TR><TD>
<?php include('top.php'); ?></TD></TR>
<TR><TD align="center" valign="middle" height="400" >

<?php
$Menus1=array('sql_empid.php'=>'SQL EMP_ID');
$Menus2=array('select_file.php?appname=Import&progname=xlsx_rtest'=>'Read excel XLSX file',
              'select_file.php?appname=Import&progname=xls_wtest'=>'Write excel file test'
             );
$Menus3=array();
f_GenMenu('TOOLS','&nbsp; D A T A B A S E &nbsp;', $Menus1, $Menus2, $Menus3);

$Menus1=array('test01.php'=>'TEST 01');
$Menus2=array();
$Menus3=array();
f_GenMenu('','&nbsp; T E S T S &nbsp;', $Menus1, $Menus2, $Menus3);

?>
</TD></TR>
<TR><TD><?php include('bottom.php'); ?></TD></TR></TABLE>
</BODY>
</HTML>