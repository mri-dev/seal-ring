	</div>
    <div>
		<div style="background:#787878; height:2px; margin:15px 0 5px 0; position:relative;">&nbsp;</div>
        <table width="100%" border="0" style="border:none; line-height:20px;">
            <tr>
                <tbody>
                    <tr>
                        <td rowspan="2" width="80" style="text-align:center; vertical-align:middle;">
                            <img src="http://<?=str_replace('http://','',$settings['page_url'])?>/admin/src/images/logo_200x_black.png" alt="<?=$settings['page_title']?>" style="width:auto !important; height:40px;" alt="<?=$settings['page_title']?>">
                        </td>
                        <td><strong style="color:black;"><?=$settings['page_title']?></strong></td>
                        <td rowspan="2"  style="text-align:right; vertical-align:middle; font-size:12px; color:#888;" ><?=$infoMsg?></td>  
                    </tr>
                    <tr>
                        <td style="font-size:12px;"><a href="http://<?=str_replace('http://','',$settings['page_url'])?>" style="color:black;"><?=$settings['page_url']?></a></td>
                    </tr>
                </tbody>
            </tr>
        </table>
	</div>
</div>
</div>
</body>
</html>