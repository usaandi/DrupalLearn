<?php

namespace Drupal\course_module\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\course_module\Controller\CourseController;
use Drupal\text\Plugin\Field\FieldFormatter\TextDefaultFormatter;

/**
 * Plugin implementation of the 'course_text_default' formatter.
 *
 * @FieldFormatter(
 *   id = "course_text_default",
 *   label = @Translation("Course default"),
 *   field_types = {
 *     "text",
 *     "text_long",
 *     "text_with_summary",
 *   }
 * )
 */
class CourseModuleFormatter extends TextDefaultFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $user_service = \Drupal::service('course_module.user_services');
    $course_controller = new CourseController($user_service);
    $users = $course_controller->content();
    $elements = parent::viewElements($items, $langcode);
    $elements = [
      '#type' => 'container',
      'element' => $elements,
      'users' => ['#markup' => 'hello'],

    ];
    return $elements;
  }

}
