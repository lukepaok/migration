<?php
session_start();
include('instart.php');
include($PATH_LANG.'/msg_imp_excel.php');
$appdir=$_REQUEST['appdir'];
$appname=$_REQUEST['appname'];
$progname=$_REQUEST['progname'];
$data_file=$_FILES["data_file"]["name"];
$line_from=$_REQUEST['line_from'];
$line_to=$_REQUEST['line_to'];
if ($line_from=='') $line_from=1;
$colsearch=$_REQUEST['colsearch'];
$fldsel=$_REQUEST['fldsel'];
$coliban=$_REQUEST['coliban'];
$choice=$_REQUEST['choice'];
$Synola=array(1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0);
?>
<HTML>
<HEAD><TITLE><?php print $ApplNameWin.': '.$TitleWin ?></TITLE>
  <META http-equiv="Content-Type" content="text/html; charset=iso-8859-7">
  <LINK href="../../lib/main.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY>

<?php
if($_FILES["data_file"]["tmp_name"] == "") {
  print "<b>File did not successfully upload.<br>";
  print "Check the file size. File must be less than 5 MB.</b><br>";
  exit();
}
$dfile=$_FILES["data_file"]["tmp_name"];
?>
<A HREF="select_file.php<?php print '?appdir='.$appdir.'&appname='.$appname.'&progname='.$progname ?>">?????????<img SRC="../../media/back1.jpg" BORDER="0" ALIGN="middle"></A><BR>
<HR>
<FONT class="PrText">
<?php
require_once $PATH_LIB.'/excelread/reader.php';
$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('CP1253');
$data->read($dfile);
if ($line_to=='') $line_to=$data->sheets[0]['numRows'];
error_reporting(E_ALL ^ E_NOTICE);
$TBL_Data=array();
$TBL_Data[0]=array('EMP_ID','EMP_LAST_NAME','EMP_FIRST_NAME','EMP_TAX_NUMBER','IBAN');
$TBL_NoData[0]=array('???????','?????','?????????','????');
for ($i = $line_from; $i <= $line_to; $i++) {
  set_time_limit(30);
  //$Eponymo  = trim(substr($data->sheets[0]['cells'][$i][1],0,30));
  //$Onoma    = trim(substr($data->sheets[0]['cells'][$i][2],0,5));
  //$IBAN_no  = trim(substr($data->sheets[0]['cells'][$i][3],10,20));
  $Eponymo  = trim($data->sheets[0]['cells'][$i][3]);
  $Onoma    = $data->sheets[0]['cells'][$i][4];
  /*
  $Eponymo  = trim($data->sheets[0]['cells'][$i][1]);
  $Onoma    = trim(substr($data->sheets[0]['cells'][$i][2],0,4));
  $IBAN_no  = trim($data->sheets[0]['cells'][$i][3]);
  if ($Eponymo=='') { continue; }
  $sql = "SELECT * FROM EMPLOYEES WHERE TRIM(EMP_LAST_NAME)='".$Eponymo."' AND SUBSTR(EMP_FIRST_NAME,1,4)='".$Onoma."'";
  $Emp_id=f_Getfld($sql,'EMP_ID');
  */
  $ValueSearch=trim($data->sheets[0]['cells'][$i][$colsearch]);
  $IBAN_no=trim($data->sheets[0]['cells'][$i][$coliban]);
  $sql="SELECT * FROM EMPLOYEES WHERE TRIM(".$fldsel.")='".$ValueSearch."'";
  $Emp_data=f_GFsArray($sql,array('EMP_ID','EMP_LAST_NAME','EMP_FIRST_NAME','EMP_TAX_NUMBER'));
  $Emp_id=$Emp_data['EMP_ID'];
  if ($Emp_id!='') {
    $TBL_Data[]=array($Emp_id,$Emp_data['EMP_LAST_NAME'],$Emp_data['EMP_FIRST_NAME'],$Emp_data['EMP_TAX_NUMBER'],$IBAN_no);
    if ($choice=='cprint') {

    }
    elseif($choice=='cfile') {

    }
    elseif($choice=='cexe') {
      $sql = "SELECT * FROM BANKACCOUNTS WHERE EMP_ID=".$Emp_id;
      $Bac_id=f_Getfld($sql,'BAC_ID');
      if ($Bac_id!='') {
        $Synola[1]++;
        $sql = "UPDATE BANKACCOUNTS SET BAC_ISBN='".$IBAN_no."', BAC_TYPE=1 WHERE BAC_ID=".$Bac_id;
      }
      else {
        $Synola[2]++;
        $sql = "INSERT INTO BANKACCOUNTS (";
        $sql .= "EMP_ID,";
        $sql .= "BAN_ID,";
        $sql .= "BAC_LOCKED,";
        $sql .= "BAC_X,";
        $sql .= "BAC_Y,";
        $sql .= "BAC_ISBN, ";
        $sql .= "BAC_TYPE ";
        $sql .= ") VALUES (";
        $sql .= $Emp_id.",";
        $sql .= "19,";
        $sql .= "0,";
        $sql .= "-1,";
        $sql .= "-1,";
        $sql .= "'$IBAN_no',";
        $sql .= "1";
        $sql .= ")";
      }
      f_sqlexe($sql);
    }
  }
  else {
    $Synola[3] ++;
    print $i.' - NAME='.$Eponymo.' '.$Onoma.$eol;
    $TBL_NoData[]=array($Eponymo,$Onoma,$ValueSearch,$IBAN_no);
  }
  

}
print 'UPDATE   ='.$Synola[1].$eol;
print 'INSERT   ='.$Synola[2].$eol;
print 'NO INSERT='.$Synola[3].$eol;
print 'LINE FROM='.$line_from.$eol;
print 'LINE TO='.$line_to.$eol;
if ($choice=='cprint') { print '<H3 style="color:blue">?????????????</H3><pre>'; print_r($TBL_Data); print "</pre>"; }
print '<H3 style="color:red">??? ?????????????</H3><pre>'; print_r($TBL_NoData); print "</pre>";
?>
</FONT>
<HR>
<A HREF="select_file.php<?php print '?appdir='.$appdir.'&appname='.$appname.'&progname='.$progname ?>">?????????<img SRC="../../media/back1.jpg" BORDER="0" ALIGN="middle"></a><BR>
</BODY>
</HTML>