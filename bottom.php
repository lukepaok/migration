<?php
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="4" align="center" bgcolor="BF3D29">
    </td>
  </tr>
  <tr>
    <td height="33" align="center" background="media/bottom_bkg.gif">
      <table border="0" cellpadding="0" cellspacing="0" background="0">
        <tr class="bottom">
          <td>
            <FONT COLOR="#000000">[ </FONT><?php print $DB_SERVER;?>
            <FONT COLOR="#000000"> ] </FONT> &nbsp; &nbsp;
          </td>
          <td>
            <FONT COLOR="#000000">[ </FONT><?php print $DB_USER;?>
            <FONT COLOR="#000000"> ] </FONT>
          </td>
          <td WIDTH='500'>&nbsp;
          </td>
          <td>
            <FONT COLOR="#000000">[ </FONT><?php print date('j-n-Y');?>
            <FONT COLOR="#000000"> ] </FONT> &nbsp; &nbsp;
          </td>
          <td>
            <FONT COLOR="#000000">[ </FONT><?php print strftime("%H:%M:%S");?>
            <FONT COLOR="#000000"> ] </FONT>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td height="3" align="center" background="media/horizontal_line.gif">
    </td>
  </tr>
</table>

<FONT class="mikro"><?php print 'OS='.PHP_OS.' - PHP='.PHP_VERSION.' - INCLUDE='.DEFAULT_INCLUDE_PATH?></FONT>
