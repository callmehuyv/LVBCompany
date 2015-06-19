<?php
function messageSystems() {
	if(Yii::$app->session->get('message') != null) {
		?>
			<script type="text/javascript">
				messageSystems('<?php echo Yii::$app->session->getFlash('message'); ?>');
			</script>
		<?php
	}
}