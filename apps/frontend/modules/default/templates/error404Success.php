<div class="sfTMessageContainer sfTAlert"> 
  <div class="sfTMessageWrap">
    <h1>Oops! Page Not Found</h1>
    <h5>The server returned a 404 response.</h5>
  </div>
</div>

<dl class="sfTMessageInfo">
  <dt>Did you type the URL?</dt>
  <dd>
    You may have typed the address (URL) incorrectly. Check it to make sure you've got the exact right spelling,
    capitalization, etc.
  </dd>

  <dt>Did you follow a link from somewhere else at this site?</dt>
  <dd>
    If you reached this page from another part of this site, please
    <?php echo mail_to(sfConfig::get('app_site_email'), 'email us', 'encode=true') ?> so we can correct our mistake.
  </dd>

  <dt>Did you follow a link from another site?</dt>
  <dd>
    Links from other sites can sometimes be outdated or misspelled.
    <?php echo mail_to(sfConfig::get('app_site_email'), 'Email us', 'encode=true') ?> the site where you came from,
    and we can try to contact the other site in order to fix the problem.
  </dd>

  <dt>What&rsquo;s next</dt>
  <dd>
    <ul class="sfTIconList">
      <li class="sfTLinkMessage"><a href="javascript:history.go(-1)">Back to previous page</a></li>
      <li class="sfTLinkMessage"><?php echo link_to('Go to Homepage', '@homepage') ?></li>
    </ul>
  </dd>
</dl>