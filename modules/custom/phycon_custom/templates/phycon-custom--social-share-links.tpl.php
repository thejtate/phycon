<?php
/**
 * @file Social Share links template
 */

?>

<div class="sharethis-wrapper share">
  <span class="subtitle"><?php print t('Share'); ?></span>
  <?php print (isset($social_share_menu)) ? $social_share_menu : ""; ?>
</div>

