<?php

if (getenv('ENV') === 'dev') {
  // Load DDEV settings.
  if (file_exists($app_root . '/' . $site_path . '/settings.ddev.php')) {
    include $app_root . '/' . $site_path . '/settings.ddev.php';
  }
  // Load dev settings.
  if (file_exists($app_root . '/' . $site_path . '/development.settings.php')) {
    include $app_root . '/' . $site_path . '/development.settings.php';
  }
  $settings['container_yamls'][] = DRUPAL_ROOT . '/sites/default/development.services.yml';
}
$settings['config_sync_directory'] = '../config/base';
