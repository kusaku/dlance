<script type='text/javascript' src='/templates/js/thickbox/thickbox.js'></script>
<link rel="stylesheet" type="text/css" href="/templates/js/thickbox/thickbox.css" />

<script type="text/javascript">

function vote(id, type)
{
	var dataString = 'id='+ id +'&type='+ type;

	$('#rating').fadeOut(300);

	$.ajax({
		type: "POST",
		url: "/designs/vote",
		data: dataString,
		cache: false,
		success: function(html)//�������� ����� �� ��������
		{
			$('#rating').html(html);
			$('#rating').fadeIn(300);
		}
	});

	return false;
}

function send_report(id)
{
	var text = $('#report').val();

	var dataString = 'id='+ id +'&text='+ text;

    if(text.length > 256)
	{
        alert('����� ��������� �� ������ ��������� ������ 256 ��������');

		return false;
	}

	$.ajax({
		type: "POST",
		url: "/designs/send_report",
		data: dataString,
		success: function(html)//�������� ����� �� ��������
		{
			alert('������ ����������');
		}
	});

	tb_remove()

	return false;
}

<? if( $this->team == 2 ): ?>
function ban(id)
{
	var text = $('#cause').val();

	var dataString = 'id='+ id +'&text='+ text;

	if(text.length > 256)
	{
        alert('����� ��������� �� ������ ��������� ������ 256 ��������');

		return false;
	}

	$.ajax({
		type: "POST",
		url: "/designs/send_ban",
		data: dataString,
		success: function(html)//�������� ����� �� ��������
		{
			alert('������� �������');
		}
	});

	tb_remove()

	return false;
}
<? endif; ?>

function addcart(id, kind)
{
	var dataString = 'id='+ id +'&kind='+ kind;

	$('#addcart').fadeOut(300);

	$.ajax({
		type: "POST",
		url: "/account/cart_add",
		data: dataString,
		cache: false,
		success: function(html)//�������� ����� �� ��������
		{
			$('#addcart').html(html);
			$('#addcart').fadeIn(300);
		}
	});

	return false;
}
</script>


<script src="/templates/js/slider/jquery.jcarousel.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/templates/js/slider/tango/skin.css" />
<script type="text/javascript">
jQuery(document).ready(function() {
    /*
	jQuery('#sub').jcarousel({
        vertical: true
    });
	*/
    jQuery('#similar').jcarousel();
});
</script>
<div id="yui-main">
<div id="order-page" class="yui-b clearfix">

<? if( $status_id == 1 ): ?>

<? if( $this->user_id != $user_id ): ?>

<div id="addcart" align="right" style="margin:10px;">
<a href="#" onclick="addcart(<?=$id?>, 1)"><img src="/templates/wdesigns/css/img/buy.gif" /></a>

<? if( $sales == 0 ): ?><a href="#" onclick="addcart(<?=$id?>, 2)"><img src="/templates/wdesigns/css/img/buyout.gif" /></a><? endif; ?>
</div>
<? endif; ?>

<? endif; ?>
<div class="order-title">
<div class="tr">
<div class="tl">


<div id="rating">
<a href="#" onclick="vote(<?=$id?>, 1)"><img src="/templates/wdesigns/css/img/like.gif" /></a>
<a href="#" onclick="vote(<?=$id?>, 2)"><img src="/templates/wdesigns/css/img/dislike.gif" /></a>
<br />
<span class="like">��������: <?=$like?></span> | <span class="dislike">�� �������� <?=$dislike?></span>
</div>



<h1><?=$title?></h1>
<a href="/designs/index/?category=<?=$category_id?>"><?=$category?></a>
<? if( $this->user_id == $user_id ): ?><div align="right"><a href="/designs/images_add/<?=$id?>">�������� �������������� �����������</a> | <a href="/designs/edit/<?=$id?>">�������������</a> | <a href="/designs/close/<?=$id?>">�������</a></div><? endif; ?>
<br />



</div>
</div>
</div>

<?
if( !empty($similar_designs) ): ?>
<div class="order-title">

<div style="padding:35px;">
<ul id="similar" class="jcarousel-skin-tango">
<? foreach($similar_designs as $row): ?>
<li><a href="/designs/<?=$row['id']?>.html"><img src="<?=$row['small_image']?>" width="120" height="75" alt="" /></a></li>
<? endforeach; ?>
</ul>
</div>

</div>

<? endif; 
?>

<?=show_highslide()?>
<table class="order">
<tr>
<td class="lbl btb">�����:</td>
<td class="txt">
      <ul class="ocard">
		<img src="<?=$userpic?>" alt="" class="avatar" />
        <li class="black">
        <a href="/user/<?=$username?>"><?=$surname?> <?=$name?> (<?=$username?>)</a></li>
        <li>��������� �����: <?=$last_login?></li>
        <li>���� �����������: <?=$created?></li>
		<li><a href="/contacts/send/<?=$username?>">������ ���������</a></li>
      </ul>
</td>
</tr>

<tr>
<td class="lbl btb">������:</td>
<td class="txt">
<div class="highslide-gallery">
<div style="width: 170px;">
<a href="<?=$full_image?>" class="highslide" onclick="return hs.expand(this)">
<img src="<?=$small_image?>" title="<?=$title?>" />
</a>
</div>
</div> 
<? if( $logged_in ): ?>
<a href="#TB_inline?height=250&width=500&inlineId=modalWindow" class="thickbox"><strong>�������� ������</strong></a>
<? endif; ?>

<? if( $this->team == 2 ) :?>
 | <a href="#TB_inline?height=250&width=500&inlineId=banWindow" class="thickbox"><strong>�������� �������</strong></a>
<? endif; ?>

</td>
</tr>


<tr>
<td class="lbl">����:</td>
<td class="txt"<? if( $status_id == 2 ): ?> style="text-decoration:line-through"<? endif; ?>><strong><?=$price_1?> ������</strong></td>
</tr>

<tr>
<td class="lbl">���� ������:</td>
<td class="txt"<? if( $sales > 0 ): ?> style="text-decoration:line-through"<? endif; ?>><strong><?=$price_2?> ������</strong></td>
</tr>

<tr>
<td class="lbl">���������:</td>
<td class="txt"><?=$date?></td>
</tr>

<tr>
<td class="lbl">����������:</td>
<td class="txt">������: <?=$sales?>  |  ���������: <?=$views?></td>
</tr>

<tr>
<td class="lbl">������:</td>
<td class="txt"><?=$status?></td>
</tr>

<tr>
<td class="lbl">����:</td>
<td class="txt">
<div>
<ul class="tags">
<? foreach($tags as $row): ?>
<li><a href="/designs/search/?tags=<?=$row['tag']?>"><?=$row['tag']?></a>  (<?=$row['tag_count']?>)</li> 
<? endforeach; ?>
</ul>
<div>
</td>
</tr>

</table>

<p class="subtitle">�������������� ���������.</p>

<table class="order">
<? if( $flash ): ?>
<tr>
<td class="lbl">����:</td>
<td class="txt"><?=$flash?></td>
</tr>
<? endif; ?>

<? if( $stretch ): ?>
<tr>
<td class="lbl">������:</td>
<td class="txt"><?=$stretch?></td>
</tr>
<? endif; ?>

<? if( $columns ): ?>
<tr>
<td class="lbl">���������� �������:</td>
<td class="txt"><?=$columns?></td>
</tr>
<? endif; ?>

<? if( $destination ): ?>
<tr>
<td class="lbl">���������� �����:</td>
<td class="txt"><?=$destination?></td>
</tr>
<? endif; ?>

<? if( $quality ): ?>
<tr>
<td class="lbl">��� ��������:</td>
<td class="txt"><?=$quality?></td>
</tr>
<? endif; ?>

<? if( $type ): ?>
<tr>
<td class="lbl">��� �������:</td>
<td class="txt"><?=$type?></td>
</tr>
<? endif; ?>

<? if( $tone ): ?>
<tr>
<td class="lbl">���:</td>
<td class="txt"><?=$tone?></td>
</tr>
<? endif; ?>

<? if( $bright ): ?>
<tr>
<td class="lbl">�������:</td>
<td class="txt"><?=$bright?></td>
</tr>
<? endif; ?>

<? if( $style ): ?>
<tr>
<td class="lbl">�����:</td>
<td class="txt"><?=$style?></td>
</tr>
<? endif; ?>

<? if( $theme ): ?>
<tr>
<td class="lbl">����:</td>
<td class="txt"><?=$theme?></td>
</tr>
<? endif; ?>

<? if( $adult ): ?>
<tr>
<td class="lbl">�����������:</td>
<td class="txt"></td
></tr>
<? endif; ?>

<? if( $colors ): ?>
<tr>
<td class="lbl">���������:</td>
<td class="txt">
<div class="jColorSelect">
<? foreach($colors as $row): ?>
<a href="/designs/search/?color=<?=$row['color']?>" title="<?=$row['percent']?>%"><div style="background-color:#<?=$row['color']?>;"></div></a>
<? endforeach; ?>
</div>
</td>
</tr>
<? endif; ?>
</table>

<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
<div class="yashare-auto-init" data-yashareType="button" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir"></div> 



<div class="order-text content"><?=nl2br($text)?></div>



<? if( !empty($images) ): ?>
<div id="ptf">
<p class="subtitle">�������������� �����������.</p>
<? foreach($images as $row): ?>
<div class="ptf-block">

<? if( $this->user_id == $user_id ): ?>
<span style="font-size:11px;">
<a href="/designs/images_edit/<?=$row['id']?>">�������������</a> | <a href="/designs/images_del/<?=$row['id']?>">�������</a>
</span>
<? endif; ?>

<div class="ptf-image brdrl">
<a href="<?=$row['full_image']?>" class="highslide " onclick="return hs.expand(this)">
<img src="<?=$row['small_image']?>" title="<?=$row['title']?>">
</a>
<div class="highslide-caption">
<?=$row['descr']?>
</div>

</div>
<div class="ptf-text"><?=$row['title']?></div>
</div>
<? endforeach; ?>
</div>
<? endif; ?>



<?=$comments?>

</div>
<!--/order-page-->
	
</div>
<!--/yui-main-->






<div id="sidebar" class="yui-b">
<div class="hd"></div>
<div class="bd clearfix">

<div class="sideblock">
      <h3>������� ������ ���������</h3>
      <ul class="latest-page">
<? foreach($newest_designs as $row): ?>
        <li><?=$row['date']?> | <a href="/designs/<?=$row['id']?>.html"><?=$row['title']?></a></li>
<? endforeach; ?>
      </ul>
</div>

<? if( !empty($sub) ): ?>
<div class="sideblock">
	<h3>����������� ������</h3>




<div class="similar">
<? foreach($sub as $row): ?>
<div><a href="/designs/<?=$row['id']?>.html"><img src="<?=$row['small_image']?>" title="<?=$row['title']?>" width="69px;"/></a></div>
<? endforeach; ?>
</div>
</div>
<? endif; ?>


<? if( !empty($members_voted) ): ?>
<div class="sideblock">
	<h3>��������������� ������������</h3>
	<div class="membvote">
<? foreach($members_voted as $row): ?>
<div><a href="/user/<?=$row['username']?>"><img src="<?=$row['userpic']?>"/></a></div>
<? endforeach; ?>
	</div>
</div>
<? endif; ?>
            
</div>
<div class="ft"></div>
</div>




<div id="modalWindow" style="display: none;">
	<textarea rows="5" cols="10" name="report" id="report" style="width:100%; height:200px;"></textarea><br /><br />
	
	<input value="���������" onclick="send_report(<?=$id?>)" type="button">
	<input value="��������" onclick="tb_remove()" type="button">
</div>
<div id="banWindow" style="display: none;">
������� ����
	<textarea rows="5" cols="10" name="cause" id="cause" style="width:100%; height:200px;"></textarea><br /><br />
	
	<input value="���������" onclick="ban(<?=$id?>)" type="button">
	<input value="��������" onclick="tb_remove()" type="button">
</div>