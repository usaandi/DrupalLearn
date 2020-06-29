<?php

namespace Drupal\course_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;

use Drupal\course_module\Form\CourseSettingsForm;

/**
 * Provides a 'Course Block' Block.
 *
 * @Block(
 *   id = "course_content",
 *   admin_label = @Translation("Course_content"),
 *   category = @Translation("Course_content"),
 * )
 */
class CourseContent extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#markup' => $this->getConfigVal(),
    ];
  }

  /**
   * Get field value.
   *
   * @return string
   *   Config value.
   */
  protected function getConfigVal() {
    $default_val = '';

    if (\Drupal::config(CourseSettingsForm::CONFIG_KEY)->get(CourseSettingsForm::CONFIG_COURSE_TEXT_AREA)) {
      $default_val = \Drupal::config(CourseSettingsForm::CONFIG_KEY)->get(CourseSettingsForm::CONFIG_COURSE_TEXT_AREA);
    }

    return $default_val;
  }

}