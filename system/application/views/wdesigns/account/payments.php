<div id="yui-main">
<div class="yui-b">

<h1><a href="/balance/payments/">Платежи</a></h1>
<p class="subtitle">
Список платежей. Для создания нового перевода нажмите: "<a href="/account/transfer/">Создать перевод</a>"<br />
Для принятия отправленного вам платежа, кликните по номеру.
</p>

<? if( !empty($data) ): ?>
<table class="offers">
<tr>
<th style="width:15px;">№</th>
<th class="txtl">Дата создания</th>
<th style="width:100px;">Тип</th>
<th style="width:100px;">Сумма</th>
<th style="width:100px;">Плательщик</th>
<th style="width:100px;">Получатель</th>
<th style="width:60px;">Статус</th>
</tr>
<? foreach($data as $row): ?>
<tr>
<td><a href="/account/payments/<?=$row['id']?>.html"><?=$row['id']?></a></td>
<td class="title"><?=$row['date']?></td>
<td class="state txtc"><?=$row['type']?>
<? if( $row['type_id'] == 2 and $row['status'] == 1 ): //Если платеж с кодом протекции?>
(<?=$row['time']?>)
<? endif; ?>
</td>
<td class="budget txtc"><strong><?=$row['amount']?> рублей</strong></td>
<td class="owner txtc"><a href="/user/<?=$row['user']?>/"><?=$row['user']?></a></td>
<td class="owner txtc"><a href="/user/<?=$row['recipient']?>/"><?=$row['recipient']?></a></td>
<td class="state txtc"><?=$row['status']?></td>
</tr>
<? endforeach; ?>
    </table>
<?=$page_links?>
<? else: ?>
<p>Платежи отсутствуют.</p>
<? endif; ?>


  </div>

</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>