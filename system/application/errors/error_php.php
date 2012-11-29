<style type="text/css">
	#content {
		border: #999 1px solid;
		background-color: #fff;
		padding: 20px 20px 12px 20px;
	}
</style>
<div id="content">
	<h1>PHP Error</h1>
	<p>
		Severity: <?= $severity; ?>
	</p>
	<p>
		Message:	<?= $message; ?>
	</p>
	<p>
		Filename: <?= $filepath; ?>
	</p>
	<p>
		Line Number: <?= $line; ?>
	</p>
</div>
