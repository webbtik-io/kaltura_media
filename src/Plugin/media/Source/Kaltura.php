<?php

namespace Drupal\media_entity_kaltura\Plugin\media\Source;

use Drupal\media\MediaSourceBase;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Field\FieldTypePluginManagerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\media\MediaInterface;

/**
 * Kaltura Media Source.
 *
 * @MediaSource(
 *   id = "kaltura",
 *   label = @Translation("Kaltura"),
 *   description = @Translation("Use Kaltura for reusable media."),
 *   allowed_field_types = {"kaltura"},
 *   default_thumbnail_filename = "no-thumbnail.png",
 * )
 */
class Kaltura extends MediaSourceBase {

  /**
   * Thumbnail API Url.
   *
   * @var string
   */
  protected $thumbnailApiUrl;

  /**
   * Construct.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, EntityFieldManagerInterface $entity_field_manager, FieldTypePluginManagerInterface $field_type_manager, ConfigFactoryInterface $config_factory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $entity_type_manager, $entity_field_manager, $field_type_manager, $config_factory);
    $this->thumbnailApiUrl = 'https://cdnsecakmi.kaltura.com/p/{partner_id}/thumbnail/entry_id/{entry_id}';
  }

  /**
   * {@inheritdoc}
   */
  public function getMetadataAttributes() {
    return [
      'default_name' => $this->t('Default Name'),
      'thumbnail_uri' => $this->t('Thumbnail Uri'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getMetadata(MediaInterface $media, $attribute_name) {
    switch ($attribute_name) {
      case 'default_name':
        return 'media:' . $media->bundle() . ':' . $media->uuid();

      case 'thumbnail_uri':
        // @TODO: FIX THUMBNAIL.
        $default_thumbnail_filename = $this->pluginDefinition['default_thumbnail_filename'];
        return $this->configFactory->get('media.settings')->get('icon_base_uri') . '/' . $default_thumbnail_filename;
    }

    return NULL;
  }

}
