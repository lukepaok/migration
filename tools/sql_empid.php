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


  $SQL_SET=f_GetTableSet("select EMP_ID, EMP_LAST_NAME, EMP_FIRST_NAME from employees where emp_tax_number in



  (
'018261202',
'021818340',
'024078123',
'024889571',
'026108164',
'028072527',
'028251517',
'028549696',
'028599571',
'029908695',
'030306626',
'031415435',
'031509974',
'032608519',
'032762584',
'032872620',
'033266039',
'033779109',
'033779700',
'033860888',
'033890463',
'033893416',
'034198048',
'034207455',
'034247047',
'034294257',
'034404567',
'034404611',
'034498856',
'034667620',
'035197500',
'035276981',
'035397489',
'035519147',
'036248132',
'036465488',
'036813358',
'037169974',
'037358030',
'037363642',
'037883499',
'038010999',
'038368518',
'038889601',
'038980328',
'039270863',
'039335720',
'039576041',
'039933990',
'042421287',
'043834018',
'043938330',
'044480142',
'044609140',
'045604097',
'045651351',
'045890061',
'045978661',
'045978673',
'046177007',
'046268624',
'046268974',
'046294181',
'046544021',
'047018018',
'047255153',
'047313357',
'049139856',
'049719410',
'049809684',
'049888197',
'051172123',
'051600681',
'051883707',
'052432654',
'053669133',
'054082878',
'054107460',
'054176780',
'054503677',
'055847945',
'055966240',
'057740812',
'057795050',
'058534960',
'058615680',
'058824415',
'059269972',
'059522275',
'059603327',
'059698846',
'059832056',
'059919113',
'061256688',
'061483756',
'062804566',
'062810801',
'062866010',
'062953455',
'064517419',
'064547701',
'065231833',
'065386173',
'065669265',
'066411370',
'066861761',
'067127496',
'067383989',
'067846718',
'067976710',
'069115782',
'069404623',
'070408625',
'070883504',
'073055359',
'073632143',
'073775768',
'074354437',
'074414555',
'074716650',
'074921332',
'075104620',
'075225940',
'075238290',
'075423107',
'075671103',
'076133520',
'076707010',
'077124742',
'077280763',
'077299580',
'077355728',
'078835678',
'079023846',
'079374726',
'100660970',
'101089076',
'101461179',
'101477061',
'101478346',
'102983268',
'103153142',
'103311683',
'103406094',
'104587359',
'104591011',
'105109102',
'105567230',
'105583870',
'106292332',
'106331558',
'108155197',
'108659074',
'109256037',
'110607066',
'110629741',
'110791246',
'110955374',
'111058612',
'111090882',
'112675648',
'112988801',
'112994487',
'114754346',
'115342651',
'115765997',
'116256734',
'116810381',
'116986301',
'117687359',
'118136535',
'118659870',
'120924147',
'120932160',
'120942269',
'121297194',
'122290302',
'122330353',
'122521956',
'122570140',
'123746320',
'124170902',
'124407565',
'125387639',
'125819404',
'126170497',
'126220850',
'126273093',
'127798878',
'129041379',
'129102469',
'130667484',
'130687919',
'130857300',
'130872129',
'130887468',
'131093200',
'131222470',
'131645416',
'131678331',
'132087344',
'132161561',
'132173897',
'132355331',
'133138360',
'133162715',
'133166695',
'133177083',
'133428349',
'133435513',
'135861429',
'135874382',
'136423022',
'137201146',
'137863098',
'138089324',
'138241559',
'139551965',
'140159240',
'141459492',
'141498954',
'142063563',
'142068430',
'142933710',
'145297674',
'145839640',
'145839812',
'145842160',
'146721997',
'149161878',
'149337919',
'149345170',
'149345182',
'151406297',
'151801470',
'152104650',
'152736470',
'152779966',
'152799547',
'153377975',
'153697565',
'154612142',
'154744415',
'155362472',
'155402911',
'158527319',
'158920326',
'159272920',
'159452991',
'159475734',
'159730079',
'160301461',
'160398696',
'160802624',
'161160252',
'162819651',
'163580440',
'164041477',
'164703650',
'165781822',
'167852114',
'300107175',
'301001004',
'301021285',
'301030269',
'301051265',
'301063971',
'301766800',
'301803363',
'302317611',
'302558098',
'302693444') ORDER BY EMP_LAST_NAME, EMP_FIRST_NAME

                            ");

$Empid_in='(';

  while(!  $SQL_SET->EOF) {
    $Emp_id=$SQL_SET->fields["EMP_ID"];
    $Lastname=$SQL_SET->fields["EMP_LAST_NAME"];

    $found=f_sqlexe('SELECT * FROM TS_GROUP_EMPLOYEES WHERE EMP_ID='.$Emp_id);

    if ($found==0) {
      print '<BR> [ '.$Emp_id.' ] '.$Lastname.'    ***** ��� �������';
      $Empid_in.=$Emp_id.',';
      $Synola[1]++;
    }
    else {
      print '<BR> [ '.$Emp_id.' ] '.$Lastname.' �������';
      $Synola[2]++;
    }
    $SQL_SET->Movenext();
  }
$Empid_in.=')';

PRINT '<BR><BR>'.$Empid_in;


PRINT '<BR><BR>�������� = '.$Synola[2];
PRINT '<BR><BR>��� �������� = '.$Synola[1];

?>
</FONT>
<HR>
<A HREF="select_file.php<?php print '?appdir='.$appdir.'&appname='.$appname.'&progname='.$progname ?>">���������<img SRC="../../media/back1.jpg" BORDER="0" ALIGN="middle"></a><BR>
</BODY>
</HTML>