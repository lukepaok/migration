<?php



$TitleSearch='Select File';
$Formfld1='File:';
$Formfld2='From line:';
$Formfld3='To line:';
$Formfld4='Organization:';
$Formfld5='Delete Table:';
$Formfld6='Code:';
$BTNSearch='Import';


if ($_REQUEST['progname']=='xml_readwrite') {
  $TitleSearch='Select XML File';
  $BTNSearch='��������';
}





$Appl_Title=array( 'xls_iban'=>'�������� IBAN',
                   'xml_readwrite'=>' &nbsp; &nbsp; &nbsp; �������� ��� �������� ���� Database &nbsp; &nbsp; &nbsp; ��������� ������� XML',


                   'xls_zim_protocol' => 'Z I M: &nbsp; �������� ��� GRAMMAT �� PROTOCOL (Excel)',
                   'xls_zim_es_recv' => 'Z I M: &nbsp; �������� ��� PROTOCOL_RECEIVERS ��� GREISER(Excel)',
                   'xls_zim_ex_recv' => 'Z I M: &nbsp; �������� ��� PROTOCOL_RECEIVERS ��� GREXER (Excel)',
                   'xls_drama_daneia' => '&nbsp; &nbsp; &nbsp; �����: &nbsp; ������ (Excel)',
                   'xls_thes_empl_KY' => '�������� ��������� �� ���������-�������',
                   'txt_panlar_emproyp'   => '�������� ������������',
                   'txt_panlar_adeies'    => '�������� ���������',
                   'txt_panlar_upemploy'  => '��������� ������������',
                   'txt_panlar_readd_adeies'  => '������������� ������',
                   'txt_vol_vathm_klim'  => '�������� ������-���������',
                   'txt_vol_vathm_klim2'  => '�������� ������-��������� 2',
                   'txt_thes_pi'  => '�������� ������������ ��������',
                 )
?>