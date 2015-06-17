<?php
function messageSystem() {
	if(Yii::$app->session->get('message') != null) {
		?>
			<div class="message-summary">
				<p>Message From System</p>
				<ul>
					<li><?php echo Yii::$app->session->getFlash('message'); ?></li>
				</ul>
			</div>
		<?php
	}
}