<?php

namespace Drupal\course_module;

use Drupal\Core\Logger\LoggerChannelTrait;

/**
 * Class UserService.
 *
 * @package Drupal\course_module
 *   My user service.
 */
class UserServices {

  use LoggerChannelTrait;

  public function returnUsersByRole() {

    $logger = $this->getLogger('course_module');
    $userList = [];
    $user_storage = \Drupal::service('entity_type.manager')->getStorage('user');
    $ids = $user_storage->getQuery()
      ->condition('roles', 'course_participant', '=')
      ->execute();
    $logger->info('keegi vaatas lehte');
    return $user_storage->loadMultiple($ids);

  }
}
