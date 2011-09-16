<div id="yui-main">
<div class="yui-b">


<h1><a href="/account/downloads">Загрузки</a></h1>

<? if( !empty($data) ): ?>
<table class="offers">
<tr>
<th class="txtl" style="width:100px;">Название</th>
<th style="width:100px;">Осталось</th>
<th></th>
</tr>
<? foreach($data as $row): ?>
<tr>
<td class="title"><?=$row['title']?></td>
<td class="owner txtc"><?=$row['left_date']?></td>
<td><span class="fr"><a href="/account/download/<?=$row['code']?>">Скачать</a></span></td>
</tr>
<? endforeach; ?>
</table>

<? else: ?>
<p>Загрузки отсутствуют.</p>
<? endif; ?>
  </div>

</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>