<ol>
<?php foreach ($pull_request->getComments() as $comment): ?>
  <li>
    <p><?php echo $comment['body'] ?></p>
    <em><?php echo link_to($comment['Author'], 'sf_guard_user_show', $comment['Author']) ?></em><br />
    <em><?php echo $comment['created_at'] ?></em>
    <hr />
  </li>
<?php endforeach ?>
</ol>