<?php

namespace Drupal\media_entity_kaltura\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'kaltura_default' formatter.
 *
 * @FieldFormatter(
 *   id = "kaltura_default",
 *   label = @Translation("Default"),
 *   field_types = {"kaltura"}
 * )
 */
class KalturaDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    foreach ($items as $delta => $item) {
      $element[$delta] = [
        '#theme' => 'kaltura_player',
      ];
      if ($item->entry_id) {
        $element[$delta]['#entryId'] = $item->entry_id;
      }

      if ($item->partner_id) {
        $element[$delta]['#partnerId'] = $item->partner_id;
      }

      if ($item->uiconf_id) {
        $element[$delta]['#uiConfId'] = $item->uiconf_id;
      }

    }
    return $element;
  }

}
