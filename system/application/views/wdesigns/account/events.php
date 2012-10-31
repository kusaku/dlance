<?php $this->load->view('wdesigns/account/block'); ?>
<div class="content">
	<script type="text/javascript">
		
		function update(id){
		
			var dataString = 'id=' + id;
			
			$.ajax({
				type: "POST",
				url: "/account/update_event",
				data: dataString,
				cache: false,
				//Тут нужно изменить img
				success: function(html){
					$('#event_' + id + '').removeClass("new");
				}
			});
			
			return false;
		}
	</script>
	<div class="userEventsHeader">
		<h3>События:</h3>
		<ul class="userEventsCategory">
			<?php 
			/*
			 <li>
			 <a href="#">репутация:</a>
			 <span>37</span>
			 </li>
			 <li>
			 <a href="#">сообщения:</a>
			 <span>45</span>
			 </li>
			 <li>
			 <a href="#">финансы:</a>
			 <span>13</span>
			 </li>
			 <li>
			 <a href="#">дизайны:</a>
			 <span>24</span>
			 </li>
			 */
			?>
			<li>
				<a href="/account/events" class="active">все</a>
			</li>
		</ul>
		<ul class="userEventsSelect">
			<li>показывать:</li>
			<li>
				<a href="/account/events/?status=1">новые</a>
			</li>
			<li>
				<a href="/account/events/?status=2">старые</a>
			</li>
			<li>
				<a href="/account/events" class="active">все</a>
			</li>
		</ul>
	</div>
	<?php if (! empty($data)): ?>
	<ul class="userEventsList">
		<?php foreach ($data as $row): ?>
		<?php if ($row['status'] == 1): ?>
		<li id="event_<?=$row['id']?>" onclick="update(<?=$row['id']?>)" class="new">
		<?php else : ?>
		<li>
			<?php endif; ?>
			<p class="date">
				<?= $row['date']?>
			</p>
			<p class="event people">
				<?= $row['title']?>
			</p>
		</li>
		<?php endforeach; ?>
	</ul>
	<div class="userEventsPagination">
		<?= $page_links?>
	</div>
	<?php else : ?>
	<p>События отсутствуют.</p>
	<?php endif; ?>
</div>
