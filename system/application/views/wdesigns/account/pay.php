<script src="/templates/js/register.js" type="text/javascript"></script>
<?=show_highslide()?>
<h1 class="title">���������� �������</h1>
<p class="subtitle">�������������� ���������, ������������� ��� ����������.</p>

<div id="register" style="margin:10px;"></div>
<input name="cart" type="hidden" id="cart" value="<?=$cart?>" />
  <div class="rnd">
    <div>
      <div>
        <div style="overflow:hidden;">
          <table class="order-form">
            <tr>
              <td class="caption">����� �����:</td>
              <td><input name="total_amount" type="hidden" id="total_amount" value="<?=$total_amount?>" /> <?=$total_amount?> ������</td>
            </tr>

            <tr>
              <td class="caption">�����:</td>
              <td><input name="username" type="text" size="20" id="username" />&nbsp;<span class="error"><span id="username_err"></span></span></td>
            </tr>

            <tr>
              <td class="caption">Email:</td>
              <td><input name="email" type="text" size="20" id="email" />&nbsp;<span class="error"><span id="email_err"></span></span></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>

<div align="center" id="robokassa">
<input type="button" id="sendbtn" value="���������" onclick="send()" />
</div>
<br />



<? foreach($data as $row): ?>
  <div class="rnd">
    <div>
      <div>
        <div style="overflow:hidden;">
          <table class="order-form">
            <tr>
              <td class="caption">ID �������:</td>
              <td><?=$row['id']?></td>
            </tr>

            <tr>
              <td class="caption">������:</td>
              <td>
<div class="highslide-gallery">
<div style="width: 170px;">
<a href="<?=$row['full_image']?>" class="highslide" onclick="return hs.expand(this)">
<img src="<?=$row['small_image']?>" title="<?=$row['title']?>" />
</a>
</div>
</div>
              </td>
            </tr>

            <tr>
              <td class="caption">����:</td>
              <td>
<? if( $row['kind'] == 1 ): ?>
�������: <?=$row['price_1']?>
<? else: ?>
�����: <?=$row['price_2']?>
<? endif; ?>
              </td>
            </tr>


          </table>
        </div>
      </div>
    </div>
  </div>
<? endforeach; ?>