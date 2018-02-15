<?php
/**
 * @file Social maps
 */

/**
 * Social map.
 *
 * @return array
 */
function _phycon_custom_admin_settings_map() {
  return array(
    'phycon_custom_settings_phone' => array(
      'title' => t('Phone'),
    ),
    'phycon_custom_settings_fax' => array(
      'title' => t('Fax'),
    ),
    'phycon_custom_settings_email' => array(
      'title' => t('Email'),
    ),
    'phycon_custom_settings_address' => array(
      'title' => t('Address'),
    ),
    'phycon_custom_settings_linkedin' => array(
      'title' => t('LinkedIn'),
    ),
  );
}

/**
 * Social Share map.
 *
 * @return array
 */
function _phycon_custom_social_share_admin_settings_map() {
  return array(
    'phycon_custom_social_share_settings_facebook' => array(
      'title' => t('Facebook'),
      'class' => 'ico ss-icon ss-social-regular ss-facebook st_facebook_custom'
    ),
    'phycon_custom_social_share_settings_twitter' => array(
      'title' => t('Twitter'),
      'class' => 'ico ss-icon ss-social-regular ss-twitter st_twitter_custom'
    ),
    'phycon_custom_social_share_settings_mail' => array(
      'title' => t('Mail'),
      'class' => 'ico ss-icon ss-standard ss-mail st_email_custom'
    ),
  );
}