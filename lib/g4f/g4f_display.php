<?php

function f_GenMenu($fp_Head='',$fp_Title='Menu', $fp_Menus1, $fp_Menus2, $fp_Menus3) {
  extract($GLOBALS);

  print '<TABLE border=0>';
  if ($fp_Head!='') {
    print '<TR><TD class="headtitle" align="center" valign="middle" height="30">'.$fp_Head.'</TD></TR>';
  }
  print '<TR><TD align="center"><SPAN CLASS="gate4">'.PHP_EOL;
  print '  <TABLE class="box">'.PHP_EOL;
  if (isset($fp_Menus1)) {
    $f_di=1;
    $f_Menu[1]=$fp_Menus1;
  }
  if (isset($fp_Menus2) && count($fp_Menus2)>0) {
    $f_di=2;
    $f_Menu[2]=$fp_Menus2;
  }
  if (isset($fp_Menus3) && count($fp_Menus2)>0) {
    $f_di=3;
    $f_Menu[3]=$fp_Menus3;
  }
  print '  <TR><TH class="box" colspan='.$f_di.'>'.$fp_Title.'</TH></TR>'.PHP_EOL;
  print '  <TR>'.PHP_EOL;

  for ($i=1;$i<=$f_di;$i=$i+1) {
    print '    <TD class="box">'.PHP_EOL;
    $First=1;
    foreach ($f_Menu[$i] as $key => $value) {
      if ($First==1) {
        print '          <A HREF="'.$key.'">'.$value.'</A>'.PHP_EOL;
        $First=2;
      }
      else {
        print '      <BR><A HREF="'.$key.'">'.$value.'</A>'.PHP_EOL;
      }
    }
    print '    </TD>'.PHP_EOL;
  }
  print '  </TR></TABLE></SPAN></TD></TR>';
  print '<TR><TD height="20"> </TD></TR></TABLE>';
  return ;
}


?>
