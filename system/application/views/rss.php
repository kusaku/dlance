<? echo '<?xml version="1.0" encoding="windows-1251" ?>' ?>

<rss version="2.0">
<channel>
<title><?php echo $feed_name; ?></title>
<link><?php echo $feed_url; ?></link>
<description><?php echo $page_description; ?></description>
<language><?php echo $page_language; ?></language>
<copyright>Copyright <?php echo gmdate("Y", time()); ?></copyright>
<?php foreach($posts as $row): ?>
<item>
<title><?php echo xml_convert($row['title']); ?></title>
<link><?php echo site_url('designs/'.$row['id'].'.html') ?></link>
<description><![CDATA[
Категория: <a href="/designs/index/?category=<?=$row['category_id']?>"><?=$row['category']?></a><br /><br />
<?=$row['text']?>
]]>

</description>
<guid><?php echo site_url('projects/'.$row['id'].'.html') ?></guid>

<pubdate><?php echo $row['date'];?></pubdate>
</item>
<?php endforeach; ?>
</channel>
</rss>