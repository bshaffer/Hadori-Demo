<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />

    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
      <div id="header">
        <?php include_partial('global/github_ribbon') ?>
        <div id="public-nav">
          <?php if ($sf_user->isAuthenticated()): ?>
            <strong><?php echo $sf_user->getGuardUser() ?></strong>
            <?php echo link_to('Sign Out', 'sf_guard_signout') ?>
          <?php else: ?>
            <?php echo link_to('Sign In', 'sf_guard_signin') ?>
          <?php endif ?>
        </div>
        <h1 id="site-title">Admin</h1>
      </div>
      <div id="content">
        <div id="admin-nav">
          <ul>
            <li><?php echo link_to('Users', '@sf_guard_user') ?></li>
            <li><?php echo link_to('Issues', '@issue') ?></li>
            <li><?php echo link_to('Pull Requests', '@pull_request') ?></li>
            <li><?php echo link_to('Tags', '@tag') ?></li>
          </ul>
				</div>
				<div id="main">
				  <div id="main-inner">
            <?php echo $sf_content ?>
          </div>
        </div>
      </div>
      <div id="footer">© 2011 Brent Shaffer</div>
  </body>
</html>


