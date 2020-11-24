<?php

namespace Drupal\kaltura_media\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'kaltura' field type.
 *
 * @FieldType(
 *   id = "kaltura",
 *   label = @Translation("Kaltura"),
 *   category = @Translation("General"),
 *   default_widget = "kaltura",
 *   default_formatter = "kaltura_default"
 * )
 */
class KalturaItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    if ($this->entry_id !== NULL) {
      return FALSE;
    }
    elseif ($this->partner_id !== NULL) {
      return FALSE;
    }
    elseif ($this->uiconf_id !== NULL) {
      return FALSE;
    }
    elseif ($this->domain !== NULL) {
      return FALSE;
    }
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {

    $properties['entry_id'] = DataDefinition::create('string')
      ->setLabel(t('Entry ID'));
    $properties['partner_id'] = DataDefinition::create('string')
      ->setLabel(t('Kaltura Account ID (partnerId)'));
    $properties['uiconf_id'] = DataDefinition::create('string')
      ->setLabel(t('Kaltura Player ID (uiconf_id)'));
    $properties['domain'] = DataDefinition::create('string')
      ->setLabel(t('Kaltura Domain'));

    return $properties;
  }

  /**
   * {@inheritDoc}
   */
  public static function mainPropertyName() {
    return 'entry_id';
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints() {
    $constraints = parent::getConstraints();

    $options['entry_id']['NotBlank'] = [];

    $options['partner_id']['NotBlank'] = [];

    $options['uiconf_id']['NotBlank'] = [];

    $options['domain']['NotBlank'] = [];

    $constraint_manager = \Drupal::typedDataManager()->getValidationConstraintManager();
    $constraints[] = $constraint_manager->create('ComplexData', $options);
    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {

    $columns = [
      'entry_id' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'partner_id' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'uiconf_id' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'domain' => [
        'type' => 'varchar',
        'length' => 255,
      ],
    ];

    $schema = [
      'columns' => $columns,
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition) {

    $random = new Random();

    $values['entry_id'] = $random->word(mt_rand(1, 10));

    $values['partner_id'] = $random->word(mt_rand(1, 10));

    $values['uiconf_id'] = $random->word(mt_rand(1, 10));

    $values['domain'] = 'cdnapisec.kaltura.com';

    return $values;
  }

}
