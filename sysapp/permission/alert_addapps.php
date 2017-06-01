<?php
	require('../../global.php');
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>添加应用</title>
	<?php include('sysapp/global_css.php'); ?>
</head>
<body>
	<div class="alert_addapps">
		<?php
			foreach($db->select('tb_app', array('tbid', 'name', 'icon'), array(
				'app_category_id' => $db->get('tb_app_category', 'tbid', array(
					'issystem' => 1
				))
			)) as $v){
				echo '<div class="app" title="'.$v['name'].'" appid="'.$v['tbid'].'">';
					echo '<img src="../../'.$v['icon'].'" alt="'.$v['name'].'" title="'.$v['name'].'">';
					echo '<div class="name">'.$v['name'].'</div>';
					echo '<span class="selected"></span>';
				echo '</div>';
			}
		?>
	</div>
	<input type="hidden" id="value_1">
	<?php include('sysapp/global_js.php'); ?>
	<script>
	$(function(){
		var dialog = window.parent.dialog.get(window);
		if(dialog.data.appsid != ''){
			$('#value_1').val(dialog.data.appsid);
			var appsid = dialog.data.appsid.split(',');
			$('.app').each(function(){
				for(var i = 0; i < appsid.length; i++){
					if(appsid[i] == $(this).attr('appid')){
						$(this).addClass('act');
						break;
					}
				}
			});
		}
		$('.app').click(function(){
			if($(this).hasClass('act')){
				var appsid = $('#value_1').val().split(',');
				var newappsid = [];
				for(var i = 0, j = 0; i < appsid.length; i++){
					if(appsid[i] != $(this).attr('appid')){
						newappsid[j] = appsid[i];
						j++;
					}
				}
				$('#value_1').val(newappsid.join(','));
				$(this).removeClass('act');
			}else{
				if($('#value_1').val() != ''){
					var appsid = $('#value_1').val().split(',');
					appsid[appsid.length] = $(this).attr('appid');
					$('#value_1').val(appsid.join(','));
				}else{
					$('#value_1').val($(this).attr('appid'));
				}
				$(this).addClass('act');
			}
			dialog.data.appsid = $('#value_1').val();
		});
	});
	</script>
</body>
</html>