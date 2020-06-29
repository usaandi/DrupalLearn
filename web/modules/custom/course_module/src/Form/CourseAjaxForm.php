<?php

namespace Drupal\course_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;



/**
 * Course module ajax form.
 */
class CourseAjaxForm extends FormBase {


  const NUMBER_1 = 'number_1';
  const NUMBER_2 = 'number_2';

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {


    $form['errors'] = [
      '#type' => 'label',
      '#title' => $this->t('Write something'),
      '#default_value' => 'asd',

    ];

    $form['message'] = [
      '#type' => 'markup',
      '#markup' => '<div class="result_message"></div>',
    ];

    $form[self::NUMBER_1] = [
      '#type' => 'number',
      '#title' => $this->t('First number'),
    ];
    $form[self::NUMBER_2] = [
      '#type' => 'number',
      '#title' => $this->t('Second number'),
    ];

    $form['actions'] = [
      '#type' => 'button',
      '#value' => $this->t('Calculate'),
      '#ajax' => [
        'callback' => '::setMessage',
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

    parent::validateForm($form, $form_state);

    if (is_numeric($form_state->getValue(self::NUMBER_1)) &&
      is_numeric($form_state->getValue(self::NUMBER_2))) {
      $a = 1;
    }
    else {
      $form_state->setErrorByName('errors', $this->t('Not valid'));

    }
    return $form_state;

  }

  /**
   * Calculate answer.
   */
  public function setMessage(array $form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    $response->addCommand(
        new HtmlCommand(
          '.result_message',
          '<div class="top_message">'
          . $this->t('Result is @result',
            ['@result' => ($form_state->getValue(self::NUMBER_1) + $form_state->getValue(self::NUMBER_2))])
          . '</div>'
        )
      );
    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'course_module_ajax_form';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  }
}