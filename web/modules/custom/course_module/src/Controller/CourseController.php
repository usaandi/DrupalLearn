<?php

namespace Drupal\course_module\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\course_module\UserServices;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CourseController extends ControllerBase {


  /**
   * UserService.
   *
   *   My service.
   */

  protected $userService;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {

    $user_service = $container->get('course_module.user_services');

    return new static($user_service);

  }

  /**
   * CourseController constructor.
   * @param UserServices $user_service
   *   Inject services.
   */
  public function __construct(UserServices $user_service) {

    $this->userService = $user_service;
  }

  public function ajaxCallback() {
    $ajax = new AjaxResponse();
    $ajax->addCommand(new ReplaceCommand('#course-content', $this->content()));
    return $ajax;
  }
  /**
   * Content function.
   *
   *   Return render element.
   */
  public function content() {
    $build = [
      '#theme' => 'course_theme__users',
      '#users' => $this->userService->returnUsersByRole(),
      '#ajaxButton' => [
        '#type' => 'link',
        '#title' => $this
          ->t('Refresh'),
        '#url' => Url::fromRoute('course_module.ajax'),
        '#attributes' => [
          'class' => ['use-ajax'],
        ],
      ],
    ];

    return $build;

  }

}