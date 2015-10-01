                    <p>
                    <?phpIf ImgPosition="bottom" Then echo content_desc?>
                    <table cellSpacing="0" cellPadding="6" width="98" align="<?php=ImgPosition?>" border="0">
                      <?phpWhile Not RS2.EOF?>
                      <tr>
                        <td align=middle>
                        <?phpIf RS2("attach_type")="image" Then?>
                      	    <IMG src="../Upload/<?php=RS2("Upload_fileURL")?>" border=0 alt="<?php=RS2("upload_filename")?>">
                      	<?phpElseIf RS2("attach_type")="flash" Then?>
                            <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0"WIDTH=611 HEIGHT=82>
			      <PARAM NAME=movie VALUE="../Upload/<?php=rs2("upload_fileurl")?>">
			      <PARAM NAME=quality VALUE=high>
			      <PARAM NAME=bgcolor VALUE=#FFFFFF>
			      <EMBED src="../Upload/<?php=rs2("upload_fileurl")?>" quality=high bgcolor=#FFFFFF  WIDTH=611 HEIGHT=82 TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></EMBED>
                            </OBJECT>                        
                        <?phpElseIf RS2("attach_type")="av" or RS2("attach_type")="WMV" Then
                            If RS2("attach_type")="WMV" then
                              data_url=rs2("upload_fileurl")
                            Else
                              data_url="upload/"&rs2("upload_fileurl")
                            End if?>
                            <object id='MediaPlayer' classid='CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6' VIEWASTEXT>
                              <param name='AllowChangeDisplaySize' value='1'>
                              <PARAM name='autoStart' value='false'>
                              <param name='AutoSize' value='0'>
                              <param name='AnimationAtStart' value='1'>
                              <param name='ClickToPlay' value='1'>
                              <param name='EnableContextMenu' value='0'>
                              <param name='EnablePositionControls' value='1'>
                              <param name='EnableFullScreenControls' value='1'>
                              <param name='URL' value='<?php=data_url?>'>
                              <param name='ShowControls' value='1'>
                              <param name='ShowAudioControls' value='1'>
                              <param name='ShowDisplay' value='0'>
                              <param name='ShowGotoBar' value='0'>
                              <param name='ShowPositionControls' value='1'>
                              <param name='ShowStatusBar' value='1'>
                              <param name='ShowTracker' value='1'>
                              <embed src='<?php=data_url?>' 
                              type='video/x-ms-wmv' 
                              width='320' height='240' 
                              autoStart='1' showControls='0'
                              AutoSize='0'
                              AnimationAtStart='1'
                              ClickToPlay='1'
                              EnableContextMenu='0'
                              EnablePositionControls='1'
                              EnableFullScreenControls='1'
                              ShowControls='1'
                              ShowAudioControls='1'
                              ShowDisplay='0'
                              ShowGotoBar='0'
                              ShowPositionControls='1'
                              ShowStatusBar='1'
                              ShowTracker='1'></embed>
                            </object>                                                    
                        <?phpElseIf RS2("attach_type")="YouTube" Then
                            echo rs2("upload_fileurl")                     	
                      	  End If?>                        
                        </td>
                      </tr>
                      <!--
                      <tr>
                        <td><font color="#4B640B" size="2"><?php=RS2("upload_filename")?></font></td>
                      </tr>                       
                      -->                     
                      <?phpRS2.MoveNext
                        Wend?>
                    </table>
                    <?phpIf ImgPosition<>"bottom" Then echo content_desc?>
                    </p>