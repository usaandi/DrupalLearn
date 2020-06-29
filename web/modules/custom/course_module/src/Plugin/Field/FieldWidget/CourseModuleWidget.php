<?php

namespace Drupal\course_module\Plugin\Field\FieldWidget;

use Drupal\Core\Field\Annotation\FieldWidget;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\course_module\Controller\CourseController;
use Drupal\course_module\UserServices;
use Drupal\text\Plugin\Field\FieldWidget\TextareaWidget;


/**
 * A widget course_participants .
 *
 * @FieldWidget(
 *   id = "course_participants",
 *   module = "course_module",
 *   label = @Translation("Course participants - Widget"),
 *   field_types = {
 *     "text_long",
 *     "text",
 *     "text_with_summary"
 *
 *   }
 * )
 */
class CourseModuleWidget extends TextareaWidget {

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {

    $settings = parent::settingsForm($form, $form_state);

  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $user_service = \Drupal::service('course_module.user_services');
    $course_controller = new CourseController($user_service);
    $users = $course_controller->content();
    $element = parent::formElement($items, $delta, $element, $form, $form_state);
    $element = [
      '#type' => 'container',
      'element' => $element,
      'users' => ['#markup' => 'Hello world'],
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    $original_values = parent::massageFormValues($values, $form, $form_state);
    $values = [];
    foreach ($original_values as $key => $value) {
      $values[$key] = $value['element'];
    }
    return $values;
  }

}
