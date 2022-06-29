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
  $BTNSearch='Εκτέλεση';
}





$Appl_Title=array( 'xls_iban'=>'Εισαγωγή IBAN',
                   'xml_readwrite'=>' &nbsp; &nbsp; &nbsp; Ανάγνωση και Εισαγωγή στην Database &nbsp; &nbsp; &nbsp; Στοιχείων Αρχείου XML',


                   'xls_zim_protocol' => 'Z I M: &nbsp; Εισαγωγή από GRAMMAT σε PROTOCOL (Excel)',
                   'xls_zim_es_recv' => 'Z I M: &nbsp; Εισαγωγή στο PROTOCOL_RECEIVERS από GREISER(Excel)',
                   'xls_zim_ex_recv' => 'Z I M: &nbsp; Εισαγωγή στο PROTOCOL_RECEIVERS από GREXER (Excel)',
                   'xls_drama_daneia' => '&nbsp; &nbsp; &nbsp; ΔΡΑΜΑ: &nbsp; Δάνεια (Excel)',
                   'xls_thes_empl_KY' => 'Εισαγωγή Υπαλλήλων ΚΥ Θεσσαλίας-Στερεας',
                   'txt_panlar_emproyp'   => 'Εισαγωγή δημογραφικων',
                   'txt_panlar_adeies'    => 'Εισαγωγή μεταβολων',
                   'txt_panlar_upemploy'  => 'Ενημερωση δημογραφικων',
                   'txt_panlar_readd_adeies'  => 'Επαναεισαγωγη Αδειων',
                   'txt_vol_vathm_klim'  => 'Εισαγωγή Βαθμων-Κλιμακιων',
                   'txt_vol_vathm_klim2'  => 'Εισαγωγή Βαθμων-Κλιμακιων 2',
                   'txt_thes_pi'  => 'Εισαγωγή Περιφεριακων Ιατρειων',
                 )
?>