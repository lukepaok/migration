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

<A HREF="select_file.php<?php print '?appdir='.$appdir.'&appname='.$appname.'&progname='.$progname ?>">Επιστροφή<img SRC="../../media/back1.jpg" BORDER="0" ALIGN="middle"></A><BR>
<HR>
<FONT class="PrText">

<?php

require_once $PATH_LIB.'/excelread/reader.php';

$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('CP1253');
$data->read($dfile);
if ($line_to=='') $line_to=$data->sheets[0]['numRows'];
error_reporting(E_ALL ^ E_NOTICE);
$Contr_ar=array('MM3_'=>1,'MONI'=>2,'EKT1_'=>3,'EKT_'=>4,'ESPA'=>5);
$Contr_ids_ar=array(308,309,310);
foreach ($Contr_ids_ar as $Value) {
  $Bens_set=f_GetTableSet("SELECT * FROM CONTRACTS_HAS_BENEFITS WHERE CON_ID=".$Value." AND SYSMST_ID=0 ");
  while(!$Bens_set->EOF) {
    $Con_Bens_ar[$Value][]=$Bens_set->fields["BEN_ID"];
    $Bens_set->Movenext();
  }
  $Deds_set=f_GetTableSet("SELECT * FROM CONTRACTS_HAS_DEDUCTIONS WHERE CON_ID=".$Value." AND SYSMST_ID=0 ");
  while(!$Deds_set->EOF) {
    $Con_Deds_ar[$Value][]=$Deds_set->fields["DED_ID"];
    $Deds_set->Movenext();
  }
  $GenPars_set=f_GetTableSet("SELECT * FROM CONTRACTS_HAS_GENERAL_PARAMS WHERE CON_ID=".$Value." AND SYSMST_ID=0 ");
  while(!$GenPars_set->EOF) {
    $Con_GenPars_ar[$Value][]=$GenPars_set->fields["GEN_ID"];
    $GenPars_set->Movenext();
  }
}
$Xoris_AFM=array();
$Categ_ar=array('ΥΕ'=>1,'ΔΕ'=>2,'ΤΕ'=>3,'ΠΕ'=>4);
$RENK_ar=array('258'=>1,'259'=>2,'260'=>3,'261'=>4,'262'=>4,'998'=>998);
for ($i=$line_from; $i<= $line_to; $i++) {
  set_time_limit(30);
  $AFM=trim($data->sheets[0]['cells'][$i][7]);
  $Contract= trim(substr($data->sheets[0]['cells'][$i][1],27,5));
  $AMKA=trim($data->sheets[0]['cells'][$i][2]);
  $Eponymo=trim($data->sheets[0]['cells'][$i][3]);
  $Onoma=trim(substr($data->sheets[0]['cells'][$i][4],0,10));
  $ADT=trim($data->sheets[0]['cells'][$i][8]);
  $IBAN_no=trim($data->sheets[0]['cells'][$i][9]);
  $AMM=trim($data->sheets[0]['cells'][$i][10]);
  $MK=trim($data->sheets[0]['cells'][$i][11]);
  $RENK=trim($data->sheets[0]['cells'][$i][12]);
  $Categ=trim(substr($data->sheets[0]['cells'][$i][13],0,2));
  if ($AFM=='') { continue; }
  $sql="SELECT * FROM EMPLOYEES WHERE EMP_TAX_NUMBER='".$AFM."'";
  $Emp_id=f_Getfld($sql,'EMP_ID');
  if ($Emp_id!='') {
    $Contr_temp=$Contr_ar[$Contract];
    $CON_ID=0;
    if ($RENK>0) { $CON_ID=308; }
    else {
      if (in_array($Contr_temp,array(1,2))) { $CON_ID=309; }
      elseif (in_array($Contr_temp,array(3,4,5))) { $CON_ID=310; }
    }
    if ($CON_ID>0) {
      f_sqlexe("UPDATE EMPLOYEES SET CON_ID=".$CON_ID." WHERE EMP_ID=".$Emp_id);
      foreach ($Con_Bens_ar[$CON_ID] as $value) {
        $Benf=f_sqlexe("SELECT * FROM EMPLOYEES_HAS_BENEFITS WHERE EMP_ID=".$Emp_id." AND BEN_ID=".$value." AND SYSMST_ID=0");
        if ($Benf==0) { f_sqlexe("INSERT INTO EMPLOYEES_HAS_BENEFITS (EMP_ID,BEN_ID,SYSMST_ID,PAYTYPES,PRIORITY) VALUES (".$Emp_id.",".$value.",0,'1,2,3,4,5,6,7,8,9,10,11,12',1)"); }
      }
      foreach ($Con_Deds_ar[$CON_ID] as $value) {
        $Dedf=f_sqlexe("SELECT * FROM EMPLOYEES_HAS_DEDUCTIONS WHERE EMP_ID=".$Emp_id." AND DED_ID=".$value." AND SYSMST_ID=0");
        if ($Dedf==0) { f_sqlexe("INSERT INTO EMPLOYEES_HAS_DEDUCTIONS (EMP_ID,DED_ID,SYSMST_ID,PAYTYPES,PRIORITY) VALUES (".$Emp_id.",".$value.",0,'1,2,3,4,5,6,7,8,9,10,11,12',1)"); }
      }
      foreach ($Con_GenPars_ar[$CON_ID] as $value) {
        $Genpardf=f_GFsArray("SELECT * FROM GENERAL_PARAMS WHERE GEN_ID=".$value,array("GEN_VARIABLE","GEN_DESCRIPTION","GEN_TYPE","GEN_VALUE","GEN_FPOINT","GEN_VALUES"));
        $Genpardf['GEN_DESCRIPTION']=str_replace("'","΄",$Genpardf['GEN_DESCRIPTION']);
        $Emppar=f_sqlexe("SELECT * FROM EMP_CONTRACT_PARAMS WHERE EMP_ID=".$Emp_id." AND ECOP_VARIABLE='".$Genpardf['GEN_VARIABLE']."'");
        if ($Genpardf['GEN_VARIABLE']=='ΚΛΙΜΑΚΙΟ_2016' && $MK>0) { $Genpardf['GEN_VALUE']=$MK; }
        elseif ($Genpardf['GEN_VARIABLE']=='ΚΑΤΗΓΟΡΙΑ_ΚΛΙΜΑΚΙΟΥ') { $Genpardf['GEN_VALUE']=$Categ_ar[$Categ]; }
        elseif ($Genpardf['GEN_VARIABLE']=='ΒΑΘΜΟΣ_ΙΑΤΡΩΝ' && $RENK>0) { $Genpardf['GEN_VALUE']=$RENK_ar[$RENK]; }
        if ($Emppar==0) {
          f_sqlexe("INSERT INTO EMP_CONTRACT_PARAMS (EMP_ID,ECOP_DESCRIPTION,ECOP_VARIABLE,ECOP_TYPE,ECOP_VALUE,ECOP_FPOINT,ECOP_VALUES) VALUES (".
                 $Emp_id.",'".$Genpardf['GEN_DESCRIPTION']."','".$Genpardf['GEN_VARIABLE']."','".$Genpardf['GEN_TYPE']."','".$Genpardf['GEN_VALUE']."','".$Genpardf['GEN_FPOINT']."','".$Genpardf['GEN_VALUES']."')");
          if (in_array($Genpardf['GEN_VARIABLE'],array('ΑΝΕΥ_ΦΟΡΟΥ','ΑΣΦΑΛΙΣΜΕΝΟΣ_ΜΕΤΑ_93','ΒΑΘΜΟΣ_ΙΑΤΡΩΝ','ΔΗΜΟΣΙΟΣ_ΥΠΑΛΛΗΛΟΣ','ΕΙΔΙΚΟΣ_ΜΙΣΘΟΣ','ΗΜΕΡΟΜΙΣΘΙΟΣ','ΚΑΤΗΓΟΡΙΑ_ΚΛΙΜΑΚΙΟΥ',
                  'ΚΛΙΜΑΚΙΟ','ΚΛΙΜΑΚΙΟ_2016','ΝΕΟ_ΚΛΙΜΑΚΙΟ','ΟΑΕΔ_ΔΠ_13','ΣΠΟΥΔΕΣ','ΦΜΥ_ΠΟΣΟ','ΦΜΥ_ΣΕ_ΚΛΙΜΑΚΑ','ΩΡΕΣ_ΕΡΓΑΣΙΑΣ','ΩΡΟΜΙΣΘΙΟΣ'))) {
            $Ecop_id=f_Getfld("SELECT * FROM EMP_CONTRACT_PARAMS WHERE EMP_ID=".$Emp_id." AND ECOP_VARIABLE='".$Genpardf['GEN_VARIABLE']."' AND ECOP_VALUE>0",'ECOP_ID');
            if ($Ecop_id>0) {
               f_sqlexe("INSERT INTO SYSTEM_SCD_REGISTER (SYSMST_ID,SYSREG_TABLE,SYSREG_TABLE_ID,SYSREG_TABLE_FIELD,SYSREG_VALIDFROM,SYSREG_VALUE,SYSREG_VALUE_TYPE,
                   SYSREG_VALUE_FPOINT,SYSREG_CREATED,SYSREG_TYPE,SYSREG_VALUEOLD,SYSREG_DESCRIPTION)
                   VALUES (0,'emp_contract_params',".$Ecop_id.",'".$Genpardf['GEN_VARIABLE']."',".f_Form2SQL('31/12/1899').",'0',".$Genpardf['GEN_TYPE'].",".$Genpardf['GEN_FPOINT'].
                   ",SYSDATE,1,0,'".$Genpardf['GEN_DESCRIPTION']."')");
               f_sqlexe("INSERT INTO SYSTEM_SCD_REGISTER (SYSMST_ID,SYSREG_TABLE,SYSREG_TABLE_ID,SYSREG_TABLE_FIELD,SYSREG_VALIDFROM,SYSREG_VALUE,SYSREG_VALUE_TYPE,
                   SYSREG_VALUE_FPOINT,SYSREG_CREATED,SYSREG_TYPE,SYSREG_VALUEOLD,SYSREG_DESCRIPTION)
                   VALUES (0,'emp_contract_params',".$Ecop_id.",'".$Genpardf['GEN_VARIABLE']."',".f_Form2SQL('01/01/2021').",'".$Genpardf['GEN_VALUE']."',".$Genpardf['GEN_TYPE'].",".$Genpardf['GEN_FPOINT'].
                   ",SYSDATE,1,0,'".$Genpardf['GEN_DESCRIPTION']."')");
            }
          }
        }
      }
    }
    else { $Synola[1]++; }
    $Synola[2]++;
  }
  else {
    $Synola[3]++;
    $Xoris_AFM[$i]=array($AFM,$Eponymo,$Onoma);
  }
}

print '<BR>ΧΩΡΙΣ ΣΥΜΒΑΣΗ='.$Synola[1].$eol;
print 'ΒΡΕΘΗΚΑΝ   ='.$Synola[2].$eol;
print 'ΧΩΡΙΣ Η ΜΕ ΛΑΘΟΣ ΑΦΜ='.$Synola[3].$eol;
print 'LINE FROM='.$line_from.$eol;
print 'LINE TO='.$line_to.$eol;
//print '<H3 style="color:blue">ZXCVB</H3><pre>'; print_r($Xoris_AFM); print "</pre>";
//INSERT INTO EMP_CONTRACT_PARAMS (EMP_ID,ECOP_DESCRIPTION,ECOP_VARIABLE,ECOP_TYPE,ECOP_VALUE,ECOP_FPOINT,ECOP_VALUES) VALUES (9066,'Ανήκει στη Γ' Ζώνη;','Γ_ΖΩΝΗ','3','0','0','')

?>
</FONT>
<HR>
<A HREF="select_file.php<?php print '?appdir='.$appdir.'&appname='.$appname.'&progname='.$progname ?>">Επιστροφή<img SRC="../../media/back1.jpg" BORDER="0" ALIGN="middle"></a><BR>
</BODY>
</HTML>