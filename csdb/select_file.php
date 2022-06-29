<?php
session_start();
include('instart.php');
include($PATH_LANG.'/msg_select_file.php');
$appname=$_REQUEST['appname'];
$progname=$_REQUEST['progname'];
$phpprog='imp_'.$progname.'.php';
$data_file=$_REQUEST['data_file'];
$line_from=$_REQUEST['line_from'];
$line_to=$_REQUEST['line_to'];




if ($progname=='xml_readwrite') {   }


?>
<HTML>
<HEAD><TITLE><?php print $ApplNameWin.': '.$appname ?></TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=iso-8859-7">
  <LINK href="../lib/main.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" language="JavaScript1.2" src="../lib/menu/stmenu.js"></script>
</HEAD>
<BODY>
<TABLE width="100%" border="0" cellpadding="0" cellspacing="0"><TR><TD>
<?php include('select_top.php'); ?></TD></TR><TR><TD></TD></TR>
<TR><TD align="center">
  <TABLE width="100%" border="0" cellpadding="0" cellspacing="0">
  <TR><TD height="70">&nbsp;</TD></TR>
  <TR><TD align="center" valign="top" height="330">
<?php
print'    <TABLE border="0" cellpadding="0" cellspacing="0">'.PHP_EOL;
print'    <TR><TD class="headtitle" align="center" valign="middle" height="50">'.$Appl_Title[$progname].'</TD></TR>'.PHP_EOL;
print'    <TR>'.PHP_EOL;
print'      <TD width="450" align="center" valign="middle">'.PHP_EOL;
print'      <TABLE border="0" cellpadding="0" cellspacing="0">'.PHP_EOL;
print'      <TR><TD>'.PHP_EOL;
print'        <TABLE width="380" height="27" border="0" cellpadding="0" cellspacing="0" background="../media/page_title_bkg.gif">'.PHP_EOL;
print'        <TR><TD><IMG src="../media/page_title1.gif" width="8" height="27"></TD>'.PHP_EOL;
print'        <TD class="pagetitle">'.$TitleSearch.'</TD>'.PHP_EOL;
print'        <TD align="right"><IMG src="../media/page_title_corner1.gif" width="8" height="27"></TD></TR>'.PHP_EOL;
print'        </TABLE></TD></TR>'.PHP_EOL;
print'      <TR><TD>'.PHP_EOL;
print'        <TABLE width="380" CELLPADDING="0" CELLSPACING="0"><TR><TD>'.PHP_EOL;
print'          <TABLE width="380" BGCOLOR="#F8F8FF" border="0" CELLPADDING="1" CELLSPACING="1" ALIGN="center">'.PHP_EOL;
print'            <FORM enctype="multipart/form-data" NAME="selectfile" METHOD="post" ACTION="'.$phpprog.'"><SPAN CLASS="forma">'.PHP_EOL;
print'            <INPUT TYPE="HIDDEN" NAME="Button">'.PHP_EOL;
print'            <INPUT TYPE="HIDDEN" name=appname VALUE="'.$appname.'">'.PHP_EOL;
print'            <INPUT TYPE="HIDDEN" name=progname VALUE="'.$progname.'">'.PHP_EOL;
print'            <INPUT TYPE="HIDDEN" name="MAX_FILE_SIZE" VALUE="5000000">'.PHP_EOL;
print'            <TR><TD WIDTH="160">'.$Formfld1.'</TD><TD CLASS="fld"><INPUT TYPE="file" STYLE="WIDTH:235px;" NAME="data_file" ID="data_file" value="'.$data_file.'"></TD></TR>'.PHP_EOL;
if (in_array($progname,array('xls_iban'))) {
  print'            <TR><TD>'.$Formfld2.'</TD><TD CLASS="fld"><INPUT TYPE="text" NAME="line_from" ID="line_from" value="'.$line_from.'"></TD></TR>'.PHP_EOL;
  print'            <TR><TD>'.$Formfld3.'</TD><TD CLASS="fld"><INPUT TYPE="text" NAME="line_to" ID="line_to" value="'.$line_to.'"></TD></TR>'.PHP_EOL;
  print'            <TR><TD>Στήλη Αναζήτησης</TD><TD CLASS="fld"><INPUT TYPE="text" NAME="colsearch" ID="colsearch" SIZE=5px value="1"></TD></TR>'.PHP_EOL;
  print'            <TR><TD><label for="sele">Field Αναζήτησης:</label></TD><TD><select id="fldsel" name="fldsel"><option value="EMP_TAX_NUMBER">ΑΦΜ</option><option value="EMP_AMKA">ΑΜΚΑ</option><option value="onoma">Ονοματεπώνυμο</option></select></TD></TR>'.PHP_EOL;
  print'            <TR><TD>Στήλη IBAN</TD><TD CLASS="fld"><INPUT TYPE="text" NAME="coliban" ID="coliban" SIZE=5px value="2"></TD></TR>'.PHP_EOL;
}
print'            <TR><TD><label for="choice">Επιλογή:</label></TD><TD><select id="choice" name="choice"><option value="cprint">Εκτύπωση</option><option value="cexe">Εισαγωγή</option><option value="cfile">Αρχειο</option></select></TD></TR>'.PHP_EOL;
print'            <TR align="center"><TD colspan="2" height="25" valign="middle" background="../media/blue_bkg_for_button.gif" class="buttons">'.PHP_EOL;
print'            <INPUT CLASS="btn" TYPE="SUBMIT" VALUE="'.$BTNSearch.'">&nbsp;&nbsp;&nbsp;'.PHP_EOL;
print'            </TD></TR>'.PHP_EOL;
print'            </FORM></SPAN>'.PHP_EOL;
print'          </TABLE></TD></TR>'.PHP_EOL;
print'        </TABLE></TD></TR>'.PHP_EOL;
print'      </TABLE></TD></TR>'.PHP_EOL;
print'    </TABLE>'.PHP_EOL;
?>
    </TD></TR>
  </TABLE></TD>
  </TR>
  <TR><TD><?php include('select_bot.php'); ?></TD></TR>
</TABLE>
</BODY>
</HTML>