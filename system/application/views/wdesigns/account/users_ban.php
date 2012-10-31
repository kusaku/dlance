<?php $this->load->view('wdesigns/account/block'); ?>
<div id="yui-main">
	<div class="yui-b">
		<?= validation_errors()?>
		<div class="rnd">
			<div>
				<div>
					<div>
						<div id="msearch">
							<form action="" method="post">
								Причина:
								<div>
									<input type="text" name="cause" class="mtext"></div>
								<div>
									<input type="submit" value="Забанить"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!--/yui-main-->
