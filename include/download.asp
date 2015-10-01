	        <table border="0" width="100%" cellspacing="3" cellpadding="0">
	        <?php
	          If Not RS3.EOF Then
	        ?>
	          <tr>
                    <td class="line150">ÀÉ®×¤U¸ü¡G</td>
                  </tr> 	        
	        <?php
	          End If
	          While Not RS3.EOF
	        ?>
	          <tr>
                    <td class="line150">
                      <a href="../Upload/<?php=RS3("Upload_FileURL")?>" target="_blank">
                        <img border="0" src="../images/save.GIF" align="absmiddle">
                        <?php=RS3("Upload_FileName")?>
                      </a>
                    </td>
                  </tr>                       	        
	        <?php
	          RS3.MoveNext
                  Wend
                ?>
	        </table>