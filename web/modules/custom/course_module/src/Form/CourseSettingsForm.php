<?php

namespace Drupal\course_module\Form;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


/**
 * Class CourseSettingsForm.
 *
 * @package Drupal\course_module\Form
 */
class CourseSettingsForm extends ConfigFormBase {


  const CONFIG_KEY = 'course.settings';
  const CONFIG_COURSE_NODE = 'course_node';
  const CONFIG_COURSE_TEXT_AREA = 'course_text_area';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'course_settings_form';

  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [self::CONFIG_KEY];
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    if ($form_state->getValue(self::CONFIG_COURSE_TEXT_AREA) === '') {
      $form_state->setErrorByName(self::CONFIG_COURSE_TEXT_AREA, $this->t('Not valid'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $user_data = $form_state->getValue(self::CONFIG_COURSE_TEXT_AREA);
    parent::submitForm($form, $form_state);

    $conf = $this->config(self::CONFIG_KEY)->set(self::CONFIG_COURSE_TEXT_AREA, $user_data)->save();
    Cache::invalidateTags(['MY_CUSTOM_UNIQUE_TAG']);
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);

    $config = $this->config(self::CONFIG_KEY);

    $form[self::CONFIG_COURSE_TEXT_AREA] = [
      '#type' => 'textarea',
      '#title' => $this->t('Write somethings'),
      '#default_value' => $config->get(self::CONFIG_COURSE_TEXT_AREA),
  /*    '#cache' => [
        'tags' => ['MY_CUSTOM_UNIQUE_TAG'],
      ],*/
    ];

    return $form;
  }

}
