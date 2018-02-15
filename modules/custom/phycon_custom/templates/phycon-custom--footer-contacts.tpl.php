<?php
/**
 * @file Footer links template
 */

?>
<?php $contacts = isset($contacts) ? $contacts : array(); ?>

<?php if ($contacts): ?>
  <p>
    <?php foreach ($contacts as $key => $contact): ?>
      <?php if ($key != 'phycon_custom_settings_address' && $key != 'phycon_custom_settings_linkedin'): ?>
        <span class="item-info"><?php print $contact; ?></span>
      <?php endif; ?>
    <?php endforeach; ?>
  </p>

  <?php print isset($contacts['phycon_custom_settings_address']) ?
    $contacts['phycon_custom_settings_address'] : ''; ?>

  <?php print isset($contacts['phycon_custom_settings_linkedin']) ?
    $contacts['phycon_custom_settings_linkedin'] : ''; ?>

<?php endif; ?>
