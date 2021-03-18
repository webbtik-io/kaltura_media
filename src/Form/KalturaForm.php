<?php

namespace Drupal\kaltura_media\Form;

use Drupal\media_library\Form\AddFormBase;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Creates a form to create media entities for Kaltura videos.
 */
class KalturaForm extends AddFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return $this->getBaseFormId() . '_kaltura';
  }

  /**
   * {@inheritdoc}
   */
  protected function buildInputElement(array $form, FormStateInterface $form_state) {
    $media_type = $this->getMediaType($form_state);

    // Add a container to group the input elements for styling purposes.
    $form['container'] = [
      '#type' => 'container',
    ];

    $form['container']['entry_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Entry ID'),
      '#size' => 20,
    ];

    $form['container']['partner_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Kaltura Account ID (partnerId)'),
      '#size' => 20,
    ];

    $form['container']['uiconf_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Kaltura Player ID (uiconf_id)'),
      '#size' => 20,
    ];

    $form['container']['domain'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Kaltura Player Domain'),
      '#default_value' => 'cdnapisec.kaltura.com',
      '#size' => 20,
    ];

    $form['container']['#attached']['library'][] = 'kaltura_media/kaltura_media_kaltura';

    $form['container']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add'),
      '#button_type' => 'primary',
      '#submit' => ['::addButtonSubmit'],
      '#ajax' => [
        'callback' => '::updateFormCallback',
        'wrapper' => 'media-library-wrapper',
        // Add a fixed URL to post the form since AJAX forms are automatically
        // posted to <current> instead of $form['#action'].
        // @todo Remove when https://www.drupal.org/project/drupal/issues/2504115
        //   is fixed.
        'url' => Url::fromRoute('media_library.ui'),
        'options' => [
          'query' => $this->getMediaLibraryState($form_state)->all() + [
            FormBuilderInterface::AJAX_FORM_REQUEST => TRUE,
          ],
        ],
      ],
    ];

    $form['container']['#attributes']['class'][] = 'container-inline';
    return $form;
  }

  /**
   * Submit handler for the add button.
   *
   * @param array $form
   *   The form render array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   */
  public function addButtonSubmit(array $form, FormStateInterface $form_state) {
    $this->processInputValues([[
      'entry_id' => $form_state->getValue('entry_id'),
      'partner_id' => $form_state->getValue('partner_id'),
      'uiconf_id' => $form_state->getValue('uiconf_id'),
      'domain' => $form_state->getValue('domain'),
    ]], $form, $form_state);
  }

}
