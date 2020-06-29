<?php

namespace Drupal\course_module\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

/**
 * Class CourseForm.
 *
 * @package Drupal\course_module\Form
 */
class CourseForm extends ConfigFormBase {

  const CONFIG_KEY = 'course.settings';
  const CONFIG_COURSE_NODE = 'course_node';
  const CONFIG_COURSE_TEXT = 'course_text';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'course_form';
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
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);

    $config = $this->config(self::CONFIG_KEY);

    $form[self::CONFIG_COURSE_NODE] = [
      '#type' => 'entity_autocomplete',
      '#target_type' => 'node',
      '#selection_settings' => [
        'target_bundles' => ['page'],
      ],
      '#defualt_value' => $config->get(self::CONFIG_KEY),
    ];

    $node_id = $config->get(self::CONFIG_COURSE_NODE);
    if ($node_id) {
      $form[self::CONFIG_COURSE_NODE]['#default_value'] = Node::load(self::CONFIG_COURSE_NODE);
    }
    $form['course_text'] = [
      '#type' => 'text_field',
      '#title' => $this->t('Course text'),
      '#default_value' => $config->get(self::CONFIG_COURSE_TEXT),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);

    if ($form_state->getValue(self::CONFIG_COURSE_TEXT) === 'kapsas') {
      $form_state->setErrorByName(self::CONFIG_COURSE_TEXT, $this->t('Not valid'));
    }


  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $config = $this->config(self::CONFIG_KEY);

    $config->set(self::CONFIG_COURSE_TEXT, $form_state->getValue(self::CONFIG_COURSE_TEXT));
    $config->set(self::CONFIG_COURSE_NODE, $form_state->getValue(self::CONFIG_COURSE_NODE));
    $config->save();
    parent::submitForm($form, $form_state);
  }

}
