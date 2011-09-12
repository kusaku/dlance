<? if( !empty($data) ): ?>
<? foreach($data as $row): ?>
<div class="event" id="message-<?=$row['id']?>"><img id="close_message"
	style="float: right; cursor: pointer"
	src="/templates/wdesigns/css/img/close.png" /> <?=$row['title']?></div>
<? endforeach; ?>
<? endif; ?>
<div class="event" id="message-1"><img id="close_message"
	style="float: right; cursor: pointer"
	src="/templates/wdesigns/css/img/close.png" /> ��������� �������������
�����, ���� ��������� ��������� �� 34<br />
����������� � �������, ���� ��������� ��������� �� -51<br />
����������� � �������, ���� ��������� ��������� �� -51</div>
