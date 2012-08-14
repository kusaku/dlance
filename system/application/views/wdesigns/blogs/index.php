<div id="yui-main">
<div class="yui-b clearfix"> 

<div align="right"><a  href="/blogs/add/"><b>Добавить запись</b></a></div><br />

<? if( !empty($blogs) ): ?>
<? foreach($blogs as $row): ?>
<div class="rnd mb10">
      <div>
        <div>
          <div>
            <div class="row-title"><a href="/blogs/<?=$row['id']?>.html"><?=$row['title']?></a></div>
            <div class="row-date"><?=$row['date']?></div>
            <div class="row-desc clearfix skip-rating"><?=nl2br($row['text'])?></div>
            <div class="row-comments"><span>Комментарии (<?=$row['count_comments']?>)</span> &nbsp;|&nbsp; Категория: <a href="/blogs/index/?category=<?=$row['category_id']?>"><?=$row['category']?></a> &nbsp;|&nbsp; <span>Автор: <a href="/user/<?=$row['username']?>"><?=$row['username']?></a></span></div>
          </div>
        </div>
      </div>
    </div>
<? endforeach; ?>
<?=$page_links?>
<? else: ?>
<p>Ничего не найдено.</p>
<? endif; ?>


</div>
</div>






<div id="sidebar" class="yui-b">
<div class="hd"></div>
<div class="bd clearfix">

<ul class="marketnav">
      <h3><a href="/blogs">Все блоги</a></h3>

<? foreach($categories as $row): ?> 

<li class="lvl-1"><a href="/blogs/index/?category=<?=$row['id']?>"><?=$row['name']?></a></li>



<? endforeach; ?>
</ul>

</div>

<div class="ft"></div>
</div>