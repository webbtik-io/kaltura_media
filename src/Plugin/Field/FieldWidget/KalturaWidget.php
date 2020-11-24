<?php

namespace Drupal\kaltura_media\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Defines the 'kaltura' field widget.
 *
 * @FieldWidget(
 *   id = "kaltura",
 *   label = @Translation("Kaltura"),
 *   field_types = {"kaltura"},
 * )
 */
class KalturaWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    $element['entry_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Entry ID'),
      '#default_value' => isset($items[$delta]->entry_id) ? $items[$delta]->entry_id : NULL,
      '#size' => 20,
    ];

    $element['partner_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Kaltura Account ID (partnerId)'),
      '#default_value' => isset($items[$delta]->partner_id) ? $items[$delta]->partner_id : NULL,
      '#size' => 20,
    ];

    $element['uiconf_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Kaltura Player ID (uiconf_id)'),
      '#default_value' => isset($items[$delta]->uiconf_id) ? $items[$delta]->uiconf_id : NULL,
      '#size' => 20,
    ];

    $element['domain'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Kaltura Player Domain'),
      '#default_value' => isset($items[$delta]->domain) ? $items[$delta]->domain : 'cdnapisec.kaltura.com',
      '#size' => 20,
    ];

    $element['#theme_wrappers'] = ['container', 'form_element'];
    $element['#attributes']['class'][] = 'container-inline';
    $element['#attributes']['class'][] = 'media-entity-kaltura-kaltura-elements';
    $element['#attached']['library'][] = 'kaltura_media/kaltura_media_kaltura';

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function errorElement(array $element, ConstraintViolationInterface $violation, array $form, FormStateInterface $form_state) {
    return isset($violation->arrayPropertyPath[0]) ? $element[$violation->arrayPropertyPath[0]] : $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    foreach ($values as $delta => $value) {
      if ($value['entry_id'] === '') {
        $values[$delta]['entry_id'] = NULL;
      }
      if ($value['partner_id'] === '') {
        $values[$delta]['partner_id'] = NULL;
      }
      if ($value['uiconf_id'] === '') {
        $values[$delta]['uiconf_id'] = NULL;
      }
      if ($value['domain'] === '') {
        $values[$delta]['domain'] = NULL;
      }
    }
    return $values;
  }

}
