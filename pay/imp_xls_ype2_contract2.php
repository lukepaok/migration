<?php
session_start();
include('instart.php');
include($PATH_LANG.'/msg_imp_excel.php');
$TitleWin='CONTRACTS';
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
  <LINK href="../lib/migration.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" language="JavaScript1.2" src="../lib/menu/stmenu.js"></script>
</HEAD>
<BODY>
<TABLE width="100%" border="0" cellpadding="0" cellspacing="0"><TR><TD>
<?php include('top_appl.php'); ?>
</TD></TR>
<TR><TD>
<A HREF="select_file.php<?php print '?appdir='.$appdir.'&appname='.$appname.'&progname='.$progname ?>">Επιστροφή<img SRC="../../media/back1.jpg" BORDER="0" ALIGN="middle"></a><BR>
<HR>
</TR><TD>
<TR><TD >
<TABLE cellpadding="10" cellspacing="0"><TR height="300" valign="top"><TD>
<?php
if($_FILES["data_file"]["tmp_name"] == "") {
  print "<b>File did not successfully upload.<br>";
  print "Check the file size. File must be less than 5 MB.</b><br>";
  exit();
}
$dfile=$_FILES["data_file"]["tmp_name"];

require_once $PATH_LIB.'/excelread/reader.php';

$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('CP1253');
$data->read($dfile);
if ($line_to=='') $line_to=$data->sheets[0]['numRows'];
error_reporting(E_ALL ^ E_NOTICE);
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
$Xoris_Contract=array();
$Wrong_iban=array();
$No_iban=array();
$Categ_ar=array('ΥΕ'=>1,'ΔΕ'=>2,'ΤΕ'=>3,'ΠΕ'=>4);
$RENK_ar=array('258'=>1,'259'=>2,'260'=>3,'261'=>4,'262'=>4,'998'=>4);

$total=$line_to-$line_from+1;
print '<div id="progress" style="width:500px;border:3px solid #ccc;"></div><div id="information" style="width"></div>';
for ($i=$line_from; $i<= $line_to; $i++) {
  $i_bar=$i-$line_from+1;
  $percent=intval($i_bar/$total * 100)."%";
  print '<script language="javascript">
    document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:#ddd;\">&nbsp;</div>";
    document.getElementById("information").innerHTML="'.$i_bar.' / '.$total.' ";
    </script>'.PHP_EOL;
  print str_repeat(' ',1024*64).PHP_EOL;
  flush();
  set_time_limit(30);
  $AFM=trim($data->sheets[0]['cells'][$i][7]);
  $Contract= trim($data->sheets[0]['cells'][$i][1]);
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
  $sql="SELECT * FROM EMPLOYEES WHERE EMP_TAX_NUMBER='".$AFM."' AND FOR_ID=3";
  $Emp_id=f_Getfld($sql,'EMP_ID');
  if ($Emp_id!='') {
    $Bancs_ar=f_GFsArray("SELECT * FROM BANKACCOUNTS WHERE EMP_ID=".$Emp_id,array('BAC_ID','BAC_ISBN'));
    if ($Bancs_ar['BAC_ID']>0) {
      if ($Bancs_ar['BAC_ISBN']!=$IBAN_no) {
        $Synola[7]++;
        $Wrong_iban[$i]=array($AFM,$Eponymo,$Onoma,$Bancs_ar['BAC_ID']);
      }
    }
    else {
      $sql = "INSERT INTO BANKACCOUNTS (EMP_ID,BAN_ID,BAC_LOCKED,BAC_X,BAC_Y,BAC_ISBN,BAC_TYPE) VALUES (".$Emp_id.",19,0,-1,-1,'".$IBAN_no."',1)";
      f_sqlexe($sql);
      $Synola[8]++;
      $No_iban[$i]=array($AFM,$Eponymo,$Onoma,$Bancs_ar['BAC_ID']);
    }
    $CON_ID=0;
    if ($Contract=='xml_pay_files/xml_nov2/ΕΦΗΜ ΓΝ ΜΟΝ ΚΑΡΠΑΘ 06 2021.xml') { $CON_ID=308; }
    elseif ($Contract=='xml_pay_files/xml_nov2/ΕΦΗΜ ΚΥ ΕΚΤ 06 2021.xml') { $CON_ID=310; }
    elseif ($Contract=='xml_pay_files/xml_nov2/ΕΦΗΜ ΚΥ ΜΟΝ 06 2021.xml') { $CON_ID=308; }
    elseif ($Contract=='xml_pay_files/xml_nov2/ΕΦΗΜ ΜΥ ΠΕΔΥ ΕΚΤ 06 2021.xml') { $CON_ID=310; }
    elseif ($Contract=='xml_pay_files/xml_nov2/ΕΦΗΜ ΜΥ ΠΕΔΥ ΜΟΝ 06 2021.xml') { $CON_ID=308; }
    elseif ($Contract=='xml_pay_files/xml_nov2/ΕΦΗΜ ΤΟΜΥ ΕΜΒ ΕΚΤ 06 2021.xml') { $CON_ID=310; }
    elseif ($Contract=='xml_pay_files/xml_nov2/ΥΠ ΓΝ ΚΑΡΠ ΕΚΤ 2021-06 Χ4055.xml') { $CON_ID=310; }
    elseif ($Contract=='xml_pay_files/xml_nov2/ΥΠ ΓΝ ΚΑΡΠ ΜΟΝ 2021-06 Χ4054.xml') { $CON_ID=309; }
    elseif ($Contract=='xml_pay_files/xml_nov2/ΥΠ ΕΚΤ ΜΥ 06 2021 ΜΑ Χ4062.xml') { $CON_ID=310; }
    elseif ($Contract=='xml_pay_files/xml_nov2/ΥΠ ΕΚΤ ΜΥ 06 2021 ΧΑ Χ4063.xml') { $CON_ID=310; }
    elseif ($Contract=='xml_pay_files/xml_nov2/ΥΠ ΕΚΤ ΤΟΜΥ ΕΜΒ 2021-06 ΜΑ Χ4052.xml') { $CON_ID=310; }
    elseif ($Contract=='xml_pay_files/xml_nov2/ΥΠ ΕΚΤ ΤΟΜΥ ΕΜΒ 2021-06 ΧΑ Χ4053.xml') { $CON_ID=310; }
    elseif ($Contract=='xml_pay_files/xml_nov2/ΥΠ ΕΣΠΑ ΚΥ COVID 2021-06 Χ4064.xml') { $CON_ID=310; }
    elseif ($Contract=='xml_pay_files/xml_nov2/ΥΠΕΡ ΚΥ ΕΚΤ 2021-06 ΜΑ Χ4061.xml') { $CON_ID=310; }
    elseif ($Contract=='xml_pay_files/xml_nov2/ΥΠΕΡ ΚΥ ΕΚΤ 2021-06 ΧΑ Χ4058.xml') { $CON_ID=310; }
    elseif ($Contract=='xml_pay_files/xml_nov2/ΥΠΕΡ ΚΥ ΜΟΝ 2021-06 ΜΑ Χ4060.xml') { $CON_ID=309; }
    elseif ($Contract=='xml_pay_files/xml_nov2/ΥΠΕΡ ΚΥ ΜΟΝ 2021-06 ΧΑ Χ4057.xml') { $CON_ID=309; }
    elseif ($Contract=='xml_pay_files/xml_nov2/ΥΠΕΡ ΜΥ ΜΟΝ 2021-06 ΜΑ Χ4056.xml') { $CON_ID=309; }
    elseif ($Contract=='xml_pay_files/xml_nov2/ΥΠΕΡ ΜΥ ΜΟΝ 2021-06 ΧΑ Χ4059.XML') { $CON_ID=309; }
    if ($CON_ID>0) {
      $Synola[4]++;
      $sql="SELECT CON_ID FROM EMPLOYEES WHERE EMP_ID=".$Emp_id;
      $contrid=f_Getfld($sql,'CON_ID');
      if ($contrid>0) { $Synola[5]++; }
      else {
        $Synola[6]++;
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
                     VALUES (0,'emp_contract_params',".$Ecop_id.",'".$Genpardf['GEN_VARIABLE']."',".f_Form2SQL('01/01/2020').",'".$Genpardf['GEN_VALUE']."',".$Genpardf['GEN_TYPE'].",".$Genpardf['GEN_FPOINT'].
                     ",SYSDATE,1,0,'".$Genpardf['GEN_DESCRIPTION']."')");
              }
            }
          }
        }
      }
    }
    else {
      $Xoris_Contract[$i]=array($AFM,$Eponymo,$Onoma);
      $Synola[1]++;
    }
    $Synola[2]++;
  }
  else {
    $sql="SELECT FOR_ID FROM EMPLOYEES WHERE EMP_TAX_NUMBER='".$AFM."'";
    $For_id=f_Getfld($sql,'FOR_ID');
    if ($For_id=='') {
      $Synola[3]++;
      $Xoris_AFM[$i]=array($AFM,$Eponymo,$Onoma,$For_id);
    }
  }
}

print '<p style="color:blue; font-family:Tahoma; font-weight:bold;">SERVER='.$DB_SERVER.PHP_EOL;
print '<BR>FILE='.$_FILES['data_file']['name'].'</p>'.PHP_EOL;

print '<BR>LINE FROM='.$line_from.PHP_EOL;
print '<BR>LINE TO='.$line_to.PHP_EOL;
print '<BR>ΒΡΕΘΗΚΑΝ   ='.$Synola[2].PHP_EOL;
print '<BR>ΧΩΡΙΣ Η ΜΕ ΛΑΘΟΣ ΑΦΜ='.$Synola[3].PHP_EOL;
print '<BR>ΔΕΝ ΑΝΗΚΟΥΝ ΣΤΗΝ ΚΑΤΗΓΟΡΙΑ ΤΩΝ ΣΥΜΒΑΣΕΩΝ='.$Synola[1].PHP_EOL;
print '<BR>ΒΡΕΘΗΚΑΝ ΣΥΜΒΑΣΕΙΣ  ='.$Synola[4].PHP_EOL;
print '<BR>ΕΧΟΥΝ ΣΥΜΒΑΣΗ ='.$Synola[5].PHP_EOL;
print '<BR>ΔΕΝ ΕΧΟΥΝ ΣΥΜΒΑΣΗ='.$Synola[6].PHP_EOL;
print '<BR>ΛΑΘΟΣ IBAN='.$Synola[7].PHP_EOL;
print '<BR>ΔΕΝ ΕΧΟΥΝ IBAN='.$Synola[8].PHP_EOL;
print '<FONT class="PrText">';
print '<H3 style="color:blue">ΧΩΡΙΣ ΑΦΜ</H3><pre>'; print_r($Xoris_AFM); print "</pre>";
print '<H3 style="color:blue">ΧΩΡΙΣ ΣΥΜΒΑΣΗ</H3><pre>'; print_r($Xoris_Contract); print "</pre>";
print '<H3 style="color:blue">ΛΑΘΟΣ IBAN</H3><pre>'; print_r($Wrong_iban); print "</pre>";
//print '<H3 style="color:blue">ΔΕΝ ΕΧΟΥΝ IBAN</H3><pre>'; print_r($No_iban); print "</pre>";
print '</FONT>';
?>

</TD></TR></TABLE></TD></TR><TR><TD><?php include('bot_appl.php'); ?></TD></TR></TABLE>
</BODY>
</HTML>