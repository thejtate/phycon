<?php

/**
 * @file
 * Default theme implementation for field collection items.
 *
 * Available variables:
 * - $content: An array of comment items. Use render($content) to print them all, or
 *   print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $title: The (sanitized) field collection item label.
 * - $url: Direct url of the current entity if specified.
 * - $page: Flag for the full page state.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. By default the following classes are available, where
 *   the parts enclosed by {} are replaced by the appropriate values:
 *   - entity-field-collection-item
 *   - field-collection-item-{field_name}
 *
 * Other variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * @see template_preprocess()
 * @see template_preprocess_entity()
 * @see template_process()
 */
?>

<div class="b-contacts">

  <?php if (!empty($content['field_about_us_info_fc_title_txt'])): ?>
    <h4><?php print render($content['field_about_us_info_fc_title_txt']); ?></h4>
  <?php endif; ?>

  <?php if (!empty($content['field_about_us_info_fc_fst_text'])): ?>
    <p><?php print render($content['field_about_us_info_fc_fst_text']); ?></p>
  <?php endif; ?>
  <?php if (!empty($content['field_contact_us_land_phone_txt']) || !empty($content['field_contact_us_land_phone_txt']) || !empty($content['field_contact_us_land_fax_txt'])): ?>
    <p>
      <?php if (!empty($content['field_contact_us_land_phone_txt'])): ?>
        <span
          class="item-info"><strong><?php print t('PHONE'); ?></strong> <?php print render($content['field_contact_us_land_phone_txt']); ?></span>
      <?php endif; ?>

      <?php if (!empty($content['field_contact_us_land_fax_txt'])): ?>
        <span
          class="item-info"><strong><?php print t('FAX'); ?></strong> <?php print render($content['field_contact_us_land_fax_txt']); ?></span>
      <?php endif; ?>
    </p>
  <?php endif; ?>

  <?php if (!empty($content['field_contact_us_email'])): ?>
    <?php print render($content['field_contact_us_email']); ?>
  <?php endif; ?>

  <?php if (!empty($content['field_about_us_info_fc_snd_text'])): ?>
    <p><?php print render($content['field_about_us_info_fc_snd_text']); ?></p>
  <?php endif; ?>

  <?php if (!empty($content['field_contact_us_land_faq_link'])): ?>
    <?php print render($content['field_contact_us_land_faq_link']); ?>
  <?php endif; ?>
</div>