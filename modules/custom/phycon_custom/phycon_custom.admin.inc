<?php


/**
 * @file
 * Settings forms
 */

/**
 * Create settings form in drupal configuration settings section for module.
 */
function phycon_custom_admin_settings() {

  $form['phycon_custom_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Phycon Settings'),
    '#collapsible' => TRUE,
  );

  $settings = _phycon_custom_admin_settings_map();

  foreach($settings as $key => $data){
    $form['phycon_custom_settings'][$key] = array(
      '#type' => 'textfield',
      '#size' => 50,
      '#title' => $data['title'],
      '#default_value' => variable_get($key, ""),
    );
  }

  $form['phycon_custom_social_share_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Social Share settings'),
    '#collapsible' => TRUE,
  );

  $socials_share = _phycon_custom_social_share_admin_settings_map();

  foreach($socials_share as $key => $data) {
    $form['phycon_custom_social_share_settings'][$key] = array(
      '#type' => 'checkbox',
      '#title' => $data['title'],
      '#default_value' => variable_get($key, ""),
    );
  }

  return system_settings_form($form);
}
