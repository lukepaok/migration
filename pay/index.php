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
$Menus1=array('select_file.php?appname=Import&progname=xls_ype2_contract'=>'YPE2->Εισαγωγη Σύμβασης (Excel)',
              'select_file.php?appname=Import&progname=xls_ype2_update'=>'YPE2->Εισαγωγη Παραμέτρων (Excel)',
              'select_file.php?appname=Import&progname=xls_ype2_contract2'=>'YPE2->Εισαγωγη Σύμβασης 2 (Excel)',
              'select_file.php?appname=Import&progname=xls_ype2_checkupdate'=>'YPE2->Final Update (Excel)'

);
$Menus2=array();
$Menus3=array();
f_GenMenu('PAYROLL','Migration', $Menus1, $Menus2, $Menus3);
?>
</TD></TR>
<TR><TD><?php include('bottom.php'); ?></TD></TR></TABLE>
</BODY>
</HTML>