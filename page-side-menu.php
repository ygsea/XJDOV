<div class="pagemenus">
		<ul class="pagemenu">
			<?php 
			//global $side_title;
			$side_title = unserialize($side_title);
			//global $side_url;
			$side_url = unserialize($side_url);
				for($i=1;$i<=20;$i++){
					if($side_title[$i]==""){echo "</ul>";}elseif($side_title[$i]=="-"){
						echo '</ul><ul class="pagemenu">';
					}else{
						$url=$side_url[$i];
						$alinks=$side_title[$i];
						echo "<li><a href='{$url}'>{$alinks}</a></li>";

					}
				}

			?>
	</div>