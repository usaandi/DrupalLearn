<?php

namespace Drupal\course_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "hello_block",
 *   admin_label = @Translation("Hello block"),
 *   category = @Translation("Hello World"),
 * )
 */
class HelloBlock extends BlockBase
{

  const CONFIG_COURSE_TITLE = 'course_title';

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#markup' => $this->t('Hello, World! course') . $this->configuration['course_title'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['course_title'] = $form_state->getvalue('course_title');
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $form['course_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Course Title'),
      '#default_value' => $this->configuration[self::CONFIG_COURSE_TITLE],
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => TRUE,
    ];
    return $form;
  }

}