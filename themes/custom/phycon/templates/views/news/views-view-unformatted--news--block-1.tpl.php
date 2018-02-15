<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<div class="b-news style-items">
  <div class="items">
    <?php foreach ($rows as $id => $row): ?>
    <div class="item el-with-animation">
      <?php print $row; ?>
      </div>
    <?php endforeach; ?>
  </div>
</div>