<footer>
	<div class="wb">
	    <div class="width pad">
	        <table width="100%" border="0">
	            <tr>
	                <tbody>
	                    <tr>
	                        <td style="text-align: center; font-size: 10px; color: #333333;">
                            This email sended by <?=$settings['page_author']?> to informate you. Your private data is secure.
	                        </td>
	                    </tr>
	                </tbody>
	            </tr>
	        </table>
	    </div>
	</div>
	<div class="cdiv"></div>

	<div class="width pad footer">
	    <div class="row"><strong style="font-size:20px;"><?=$settings['page_author']?></strong></div>
	     <div class="row">
	         <table style="width: 100%">
	             <tbody>
	                 <tr>
	                     <td style="width:33.333%;">HU-<?=$settings['page_author_address']?></td>
	                     <td style="width:33.333%;">Phone: <?=$settings['page_author_phone']?></td>
	                     <td style="width:33.333%;">Email: <a href="mailto:<?=$settings['primary_email']?>"><?=$settings['primary_email']?></a></td>
	                 </tr>
	             </tbody>
	         </table>
	     </div>
	     <div class="row">
	         <a href="<?=$settings['blog_url']?>"><?=$settings['blog_url']?></a>
	     </div>
	</div>
</footer>