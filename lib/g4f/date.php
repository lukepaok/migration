<?php

function f_SQL2Screen($FDate) {
  if (strpos($FDate,'-')) { $Date_Array = explode('-',$FDate); }
  elseif (strpos($FDate,'/')) { $Date_Array = explode('/',$FDate); }
  if (strlen($Date_Array[2])>2) { $Date_Array[2]= substr($Date_Array[2],0,2); }
  Return $Date_Array[2].'/'.$Date_Array[1].'/'.$Date_Array[0];
}

function f_Form2SQL($FDate) {
  if (strpos($FDate,'-')) { $Date_Array=explode('-',$FDate); }
  elseif (strpos($FDate,'/')) { $Date_Array=explode('/',$FDate); }
  $Func_ret="TO_DATE('".$Date_Array[0].'/'.$Date_Array[1].'/'.$Date_Array[2]."','DD/MM/YYYY')";
  if ($Date_Array[2]<40) { $Func_ret="TO_DATE('".$Date_Array[2].'/'.$Date_Array[1].'/'.$Date_Array[0]."','DD/MM/YYYY')"; }
  return $Func_ret;
}


?>
