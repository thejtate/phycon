<?php

define('__THEME_PATH', drupal_get_path('theme', 'phycon'));
define('CONTACT_US_WEBFORM_NID', 7);
define('SERVICES_MAIN_NID', 8);
define('NEWS_NID', 16);
define('ARCHIVE_NEWS_NID', 22);

/**
 * Implements template_preprocess_html().
 */
function phycon_preprocess_html(&$vars) {

  $viewport = array(
    '#tag' => 'meta',
    '#attributes' => array(
      'name' => 'viewport',
      'content' => 'width=device-width, initial-scale=1, maximum-scale=1',
    ),
  );

  drupal_add_html_head($viewport, 'viewport');

  $view = views_get_page_view();
  if (is_object($view)) {
    if ($view->name == '' && $view->current_display == '') {
      $vars['classes_array'][] = 'page';
    }
  }

//  if (module_exists('search')) {
//    if (arg(0) == 'search') {
//      $vars['classes_array'][] = 'section-top-img-big';
//    }
//  }

  $node = menu_get_object('node', 1);
  if ($node) {
    switch ($node->type) {
      case 'homepage':
        $vars['classes_array'][] = 'page';
        break;
      case 'service':
        $vars['classes_array'][] = 'section-top-img-big';
        break;
    }
    switch ($node->nid) {
      case SERVICES_MAIN_NID:
        $vars['classes_array'][] = 'section-top-img-big';
        break;

      case NEWS_NID:
      case ARCHIVE_NEWS_NID:
        $vars['classes_array'][] = 'page-news';
        break;
    }
  }
}

/**
 * Implements template_preprocess_page().
 */
function phycon_preprocess_page(&$vars) {
  if (isset($vars['node'])) {
    $node = $vars['node'];
    if ($node->nid == SERVICES_MAIN_NID) {
      $color = _phycon_get_rows_from_node($node, array('field_color_scheme'));
      if (isset($color['field_color_scheme']) && !empty($color['field_color_scheme'])) {
        $color = $color['field_color_scheme']['#items'][0]['rgb'];
        $vars['color_style'] = phycon_get_color_class($color);
      }
    }

    switch ($node->type) {
      case 'service':
        $use = node_load(SERVICES_MAIN_NID);
        break;
      case 'contact_us_landing':
      case 'contact_us':
      case 'page':
      case 'about_us':
      case 'questions':
      case 'faqs':
      case 'careers':
        $use = node_load($node->nid);
        break;

    }
  }
  if (isset($use)) {
    $top_img = array(
      'field_top_image',
      'title',
      'field_subtitle',
      'field_page_description',
      'field_sidebar_text',
      'field_color_scheme',
    );
    $common = _phycon_get_rows_from_node($use, $top_img);
    if (isset($common) && !empty($common)) {
      $vars['custom_sidebar'] = TRUE;
      if (isset($common['field_top_image']) && !empty($common['field_top_image'])) {
        $vars['page']['section_top'] = render($common['field_top_image']);
      }
      if (isset($common['title']) && !empty($common['title'])) {
        $vars['title'] = $common['title'];
      }
      if (isset($common['field_subtitle']) && !empty($common['field_subtitle'])) {
        $vars['page']['sidebar_left_title'] = render($common['field_subtitle']);
      }
      if (isset($common['field_page_description']) && !empty($common['field_page_description'])) {
        $vars['page']['sidebar_left_desc'] = render($common['field_page_description']);
      }
      if (isset($common['field_sidebar_text']) && !empty($common['field_sidebar_text'])) {
        $vars['page']['sidebar_left'] = render($common['field_sidebar_text']);
      }
      if (isset($common['field_color_scheme']) && !empty($common['field_color_scheme'])) {
        $color = $common['field_color_scheme']['#items'][0]['rgb'];
        $vars['color_style'] = phycon_get_color_class($color);
      }
    }
  }
//  kpr($vars);
  //Add title to Search page
  if (module_exists('search')) {
    if (arg(0) == 'search') {
      $vars['title'] = t('results for ');
    }
  }
}

/**
 * Implements hook_preprocess_views_view().
 * @param $vars
 */
function phycon_preprocess_views_view(&$vars) {
  switch ($vars['name']) {
    case 'services':
      if ($vars['display_id'] == 'block') {
        $vars['classes_array'][] = 'content-list';

      }
      break;
  }
}

/**
 * Implements template_preprocess_node().
 */
function phycon_preprocess_node(&$vars) {
  $node = $vars['node'];
  if (!$vars['page']) {
    $vars['theme_hook_suggestions'][] = 'node__' . $vars['type'] . '__' . $vars['view_mode'];
  }

  if (isset($vars['content']['field_top_image']) && !empty($vars['content']['field_top_image'])) {
    hide($vars['content']['field_top_image']);
  }
  if (isset($vars['content']['field_page_description']) && !empty($vars['content']['field_page_description'])) {
    hide($vars['content']['field_page_description']);
  }

  hide($vars['content']['sidebar_left_title']);

  hide($vars['content']['field_sidebar_text']);


  switch ($node->type) {
    case 'homepage':

      break;
    case 'news':
      $path = drupal_get_path_alias('node/' . $node->nid);
      $data = array(
        'url' => url($path, array('absolute' => TRUE)),
        'title' => $vars['title'],
      );
      $socials = _phycon_custom_social_share_admin_settings_map();
      $vars['share_list'] = theme("phycon_custom__social_share_links", array(
        'services' => $socials,
        'data' => $data
      ));
      break;
  }

}

/**
 * Implements hook_preprocess_field().
 */
function phycon_preprocess_field(&$vars, $hook) {
  $element = $vars['element'];
  switch ($element['#field_name']) {
    case 'field_contact_ways':
    case 'field_contact_ways_type':
    case 'field_contact_ways_value':
    case 'field_staff_position':
    case 'field_home_bottom_title':
      $vars['theme_hook_suggestions'][] = 'field__no_wrappers';
      break;
    case 'field_staff':
      $vars['classes_array'][] = 'member-list';
      break;
    case 'field_home_top_slider':
      $slider_images = _phycon_rows_from_field_collection($vars, array('field_home_top_slider_image'));
      $vars['slider_images'] = array();
      foreach ($slider_images as $key => $image) {
        $url = isset($image['field_home_top_slider_image']['uri']) ?
          file_create_url($image['field_home_top_slider_image']['uri']) : '';
        if ($url) {
          $vars['slider_images'][$key] = $url;
        }
      }
      break;
    case 'field_home_tabs':
      $tab_titles = _phycon_rows_from_field_collection($vars, array('field_home_tabs_title'));
      $titles = array();
      foreach ($tab_titles as $title) {
        $title = isset($title['field_home_tabs_title']) ? $title['field_home_tabs_title'] : '';
        $titles[] = '<a href="#">' . $title . '</a>';
      }

      if ($titles) {
        $vars['tab_titles'] = theme('item_list', array('items' => $titles));
      }
      break;
  }
}

/**
 * Creates a simple text rows array from a field collections, to be used in a
 * field_preprocess function.
 *
 * @param $vars
 * An array of variables to pass to the theme template.
 * @param $field_array
 * Array of fields to be turned into rows in the field collection.
 * @return array
 */
function _phycon_rows_from_field_collection(&$vars, $field_array) {
  $rows = array();
  if (isset($vars['element']['#items'])) {
    $items = $vars['element']['#items'];
  }
  elseif (isset($vars['#items'])) {
    $items = $vars['#items'];
  }
  else {
    $items = array();
  }

  foreach ($items as $key => $item) {
    $entity_id = $item['value'];
    $entity = field_collection_item_load($entity_id);
    try {
      $wrapper = entity_metadata_wrapper('field_collection_item', $entity);
      $row = array();
      $properties = $wrapper->getPropertyInfo();

      foreach ($field_array as $field) {
        if (array_key_exists($field, $properties)) {
          $row[$field] = $wrapper->$field->value();
        }
      }
      $rows[] = $row;
    } catch (EntityMetadataWrapperException $exc) {
      watchdog('phycon', 'See ' . __FUNCTION__ . '() <pre>' . $exc->getTraceAsString() . '</pre>', NULL, WATCHDOG_ERROR);
    }
  }

  return $rows;
}

/**
 * Implements hook_form_alter().
 */
function phycon_form_alter(&$form, &$form_state, $form_id) {
  switch ($form_id) {
    case 'webform_client_form_' . CONTACT_US_WEBFORM_NID:
      $form['#attributes']['class'][] = 'form';
      $form['#attributes']['class'][] = 'form-sign-up-for-demo';
      break;
    case 'search_form':
      $form['advanced']['#access'] = FALSE;
      $form['basic']['#access'] = FALSE;
      break;

  }
}

/**
 * Get rows from node.
 *
 * @param $node
 * @param $field_array
 * @return array|void
 */
function _phycon_get_rows_from_node($node, $field_array) {

  if (!is_object($node)) {
    return;
  }

  try {
    $node_wrapper = entity_metadata_wrapper('node', $node);
    $properties = $node_wrapper->getPropertyInfo();
    $rows = array();

    foreach ($field_array as $field) {
      if (array_key_exists($field, $properties)) {
        $display = array('label' => 'hidden');
        $rows[$field] = field_view_field('node', $node, $field, $display);
      }
      if ($field === 'title') {
        $rows[$field] = $node_wrapper->label();
      }
    }
  } catch (EntityMetadataWrapperException $exc) {
    watchdog('phycon', 'See ' . __FUNCTION__ . '() <pre>' . $exc->getTraceAsString() . '</pre>', NULL, WATCHDOG_ERROR);
  }

  return $rows;
}


/**
 * Get color classes map.
 */
function _phycon_get_color_class_map() {
  $color_classes = array(
    '#fd9215' => 'color-style-a',
    '#036ea6' => 'color-style-b',
    '#8dc63f' => 'color-style-c',
  );

  return $color_classes;
}

/**
 * @param string $color in format '#ffffff'
 *
 * @return string color class if exist
 */
function phycon_get_color_class($color) {
  $classes_map = _phycon_get_color_class_map();
  $color = strtolower($color);

  return (isset($classes_map[$color]) && !empty($classes_map[$color])) ? $classes_map[$color] : '';
}

/**
 * Implements hook_preprocess_vcardfield().
 */
function phycon_preprocess_vcardfield(&$vars) {
  $vars['vcard_url'] = 'getvcard/' . str_replace('field_', '', $vars['instance']) . '/' . $vars['nid'] . '/' . $vars['delta'] . '/' . $vars['type'];
  $vars['vcard_link'] = l('', $vars['vcard_url'], array(
    'attributes' => array(
      'rel' => 'nofollow',
      'class' => array('link')
    )
  ));
}
