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
    <TABLE border="0" cellpadding="0" cellspacing="0">
    <TR><TD class="headtitle" align="center" valign="middle" height="50"><?php print $Appl_Title[$appname] ?></TD></TR>
    <TR>


<TD width="450" align="center" valign="middle">
<TABLE border="0" cellpadding="0" cellspacing="0">
<TR><TD>
<TABLE width="380" height="27" border="0" cellpadding="0" cellspacing="0" background="../media/page_title_bkg.gif">
   <TR><TD><IMG src="../media/page_title1.gif" width="8" height="27"></TD>
   <TD class="pagetitle"><?php print $TitleSearch ?></TD>
   <TD align="right"><IMG src="../media/page_title_corner1.gif" width="8" height="27"></TD></TR>
   </TABLE></TD></TR>
<TR><TD>



<TABLE width="380" CELLPADDING="0" CELLSPACING="0"><TR><TD>
<TABLE width="380" BGCOLOR="#F8F8FF" border="0" CELLPADDING="1" CELLSPACING="1" ALIGN="center">

<FORM enctype="multipart/form-data" NAME="selectfile" METHOD="post" ACTION="<?php print $phpprog ?>"><SPAN CLASS="forma">
<INPUT TYPE="HIDDEN" NAME="Button">
<INPUT TYPE="HIDDEN" name=appname VALUE="<?php print $appname ?>" >
<INPUT TYPE="HIDDEN" name=progname VALUE="<?php print $progname ?>" >
<INPUT TYPE="HIDDEN" name="MAX_FILE_SIZE" VALUE="5000000">
<TR><TD WIDTH="160"><?php print $Formfld1 ?></TD><TD CLASS="fld"><INPUT TYPE="file" STYLE="WIDTH:235px;" NAME="data_file" ID="data_file" value="<?php print $data_file ?>"></TD></TR>
<TR><TD><?php print $Formfld2 ?></TD><TD CLASS="fld"><INPUT TYPE="text" NAME="line_from" ID="line_from" value="<?php print $line_from ?>"></TD></TR>
<TR><TD><?php print $Formfld3 ?></TD><TD CLASS="fld"><INPUT TYPE="text" NAME="line_to" ID="line_to" value="<?php print $line_to ?>"></TD></TR>
<TR><TD>Στήλη Αναζήτησης</TD><TD CLASS="fld"><INPUT TYPE="text" NAME="colsearch" ID="colsearch" SIZE=5px value="1"></TD></TR>
<TR><TD><label for="sele">Field Αναζήτησης:</label></TD><TD><select id="fldsel" name="fldsel"><option value="EMP_TAX_NUMBER">ΑΦΜ</option><option value="EMP_AMKA">ΑΜΚΑ</option><option value="onoma">Ονοματεπώνυμο</option></select></TD></TR>
<TR><TD>Στήλη IBAN</TD><TD CLASS="fld"><INPUT TYPE="text" NAME="coliban" ID="coliban" SIZE=5px value="2"></TD></TR>
<TR><TD><label for="choice">Επιλογή:</label></TD><TD><select id="choice" name="choice"><option value="cprint">Εκτύπωση</option><option value="cexe">Εκτέλεση</option><option value="cfile">Αρχειο</option></select></TD></TR>
<TR align="center"><TD colspan="2" height="25" valign="middle" background="../media/blue_bkg_for_button.gif" class="buttons">
<INPUT CLASS="btn" TYPE="SUBMIT" VALUE="<?php print $BTNSearch ?>">&nbsp;&nbsp;&nbsp;
</TD></TR>
</FORM></SPAN></TABLE></TD></TR></TABLE>
</TD></TR>
</TABLE>
</TD>

</TR>
</TABLE></TD></TR>
</TABLE>

</TD></TR><TR><TD><?php include('select_bot.php'); ?></TD></TR></TABLE>
</BODY>
</HTML>

