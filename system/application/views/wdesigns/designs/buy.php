<h1 class="title">Купить дизайн</h1>
<p class="subtitle">Форма покупки дизайна</p>
<?=validation_errors()?>
<?=show_highslide()?>
<form action="" method="post" />
<input type="hidden" name="design_id" value="<?=$id?>" />
  <div class="rnd">
    <div>
      <div>
        <div style="overflow:hidden;">
          <table class="order-form">
            <tr>
              <td class="caption">ID дизайна:</td>
              <td><?=$id?></td>
            </tr>

            <tr>
              <td class="caption">Дизайн:</td>
              <td>
<div class="highslide-gallery">
<div style="width: 170px;">
<a href="<?=$full_image?>" class="highslide" onclick="return hs.expand(this)">
<img src="<?=$small_image?>" title="<?=$title?>" />
</a>
</div>
</div>
              </td>
            </tr>

            <tr>
              <td class="caption">Вид:</td>
              <td>
<input type="radio" name="kind" value="1" <?=set_checkbox('kind', '1'); ?> /> Покупка (<strong><?=$price_1?> USD</strong>)&nbsp &nbsp
<input type="radio" name="kind" value="2" <?=set_checkbox('kind', '2'); ?> /> Выкуп (<strong><?=$price_2?> USD</strong>)
              </td>
            </tr>


          </table>
        </div>
      </div>
    </div>
  </div>
<input type="submit" value="Продолжить">
</form>