<div id="yui-main">
<div class="yui-b">

<h1> <a href="/account/userpic">Юзерпик</a> </h1>
<p class="subtitle"> Ваш юзерпик </p>

<? if( !empty($error) ) {?><div class="error"><?=$error?></div><? } ?>



<div class="main">
<form action="/account/userpic" method="post" enctype="multipart/form-data">
<div class="ttl">
<div class="ttr"></div>
</div>
<div class="bbd">
<table class="images">
<tr>
<td>
<img src="<?=$userpic?>" alt=""><br>
Удалить [<a href="/account/userpic_del">x</a>]<br>&nbsp;<br>
Загрузить аватар (100x100x18000)<br />
<input name="userfile" type="file" class="file" size="24" /><br />
</td>
</tr>         
</table>
</div>
<div class="bbl">
<div class="bbr"></div>
</div>
<br>
<input type="submit" value="Загрузить">
</form>
</div>




  </div>

</div>
<!--/yui-main-->

<? $this->load->view('wdesigns/account/block'); ?>