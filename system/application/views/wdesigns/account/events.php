<? $this->load->view('wdesigns/account/block'); ?>

<div class="content">

<script type="text/javascript">

function update(id){

	var dataString = 'id='+ id;

	$.ajax({
		type: "POST",
		url: "/account/update_event",
		data: dataString,
		cache: false,
		//Тут нужно изменить img
		success: function(html)
		{
			$('#event_'+ id + '').removeClass("new");
		}
	});

	return false;
}
</script>

	<div class="userEventsHeader">
		<h3>События:</h3>
		<ul class="userEventsCategory">
			<li><a href="#">репутация:</a> <span>37</span></li>
			<li><a href="#">сообщения:</a> <span>45</span></li>
			<li><a href="#">финансы:</a> <span>13</span></li>
			<li><a href="#">дизайны:</a> <span>24</span></li>
			<li><a href="/account/events" class="active">все</a></li>
		</ul>
		<ul class="userEventsSelect">
			<li>показывать:</li>
			<li><a href="/account/events/?status=1">новые</a></li>
			<li><a href="/account/events/?status=2">старые</a></li>
			<li><a href="/account/events" class="active">все</a></li>
		</ul>
	</div>
	<? if( !empty($data) ): ?>
		<ul class="userEventsList">
		<? foreach($data as $row): ?>
		<? if( $row['status'] == 1 ): ?>
		<li id="event_<?=$row['id']?>" onclick="update(<?=$row['id']?>)" class="new">
		<? else: ?>
		<li>
		<? endif; ?>
			<p class="date"><?=$row['date']?></p>
			<p class="event people"><?=$row['title']?></p>
		</li>
		<? endforeach; ?>
		</ul>
		<div class="userEventsPagination">
			<?=$page_links?>
		</div>
	<? else: ?>
		<p>События отсутствуют.</p>
	<? endif; ?>

</div>
