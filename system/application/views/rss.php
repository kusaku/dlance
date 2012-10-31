<?= '<?xml version="1.0" encoding="UTF-8" ?>'?>
<rss version="2.0">
	<channel>
		<title><?= $feed_name; ?></title>
		<link>
		<?= $feed_url; ?>
		</link>
		<description>
			<?= $page_description; ?>
		</description>
		<language>
			<?= $page_language; ?>
		</language>
		<copyright>
			Copyright <?= gmdate("Y", time()); ?>
		</copyright>
		<?php foreach ($posts as $row): ?>
		<item>
			<title><?= xml_convert($row['title']); ?></title>
			<link>
			<?= site_url('designs/'.$row['id'].'.html')?>
			</link>
			<description>
<![CDATA[
Категория: <a href="/designs/index/?category=<?=$row['category_id']?>"><?=$row['category']?></a><br /><br />
<?=$row['text']?>
]]>
			</description>
			<guid>
				<?= site_url('projects/'.$row['id'].'.html')?>
			</guid>
			<pubdate>
				<?= $row['date']; ?>
			</pubdate>
		</item>
		<?php endforeach; ?>
	</channel>
</rss>
