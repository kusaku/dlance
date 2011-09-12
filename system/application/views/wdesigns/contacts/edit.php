<div id="yui-main">
<div class="yui-b">

<h1><a href="">�������� / ���������</a></h1>

<p class="subtitle">���� ��������</p>



<div class="rnd">
<div>
<div>
<div>
<div align="right"><a href="/contacts/add">������� ������</a></div>
<h1 class="market-title">������</h1>
<div id="msearch">
<div><select name="group_id"
	onchange="document.location.href = '/contacts/index/?group_id=' + this.value"
	<? foreach($groups as $row): ?><option value="<?=$row['id']?>"><?=$row['name']?> (<?=$row['count_contacts']?>)</option>
<? endforeach; ?>
</select></div>
</div>
</div>
</div>
</div>
</div>

<?=validation_errors()?>
<div class="rnd">
<div>
<div>
<div>
<div id="msearch">
<form action="" method="post">�������� ������:
<div><input type="text" name="name" class="mtext" value="<?=$name?>"></div>
<div><input type="submit" value="�������������"></div>
</form>
</div>
</div>
</div>
</div>
</div>



</div>

</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>