<div id="yui-main">
<div class="yui-b">


<h1><a href="/blogs/articles">Записи</a></h1>
<p class="subtitle"> Список ваших записей. Для публикации новой записи нажмите: "<a href="/blogs/add">Добавить запись</a>"</p>

<? if( !empty($data) ): ?>
<table class="listorder">
<tr>
<td class="topline lft txtl">Заголовок</td>
</tr>
<? foreach($data as $row): ?>
<tr>
<td class="ordertitle"><a href="/blogs/<?=$row['id']?>.html"><?=$row['title']?></a><br>

<div class="inf"><?=$row['category']?> | <?=$row['date']?></div>
<div class="inf"><a href="/blogs/edit/<?=$row['id']?>">Редактировать</a> | <a href="/blogs/del/<?=$row['id']?>">Удалить</a></div>
</td>
</tr>
<? endforeach; ?>
    </table>
<?=$page_links?>
<? else: ?>
<p>Записи отсутствуют.</p>
<? endif; ?>


  </div>

</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>