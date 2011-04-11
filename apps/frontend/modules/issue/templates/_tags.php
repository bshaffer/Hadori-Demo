<ul>
<?php foreach ($issue['Tags'] as $tag): ?>
  <li><?php echo link_to($tag, 'tag_show', $tag) ?></li>
<?php endforeach ?>
</ul>