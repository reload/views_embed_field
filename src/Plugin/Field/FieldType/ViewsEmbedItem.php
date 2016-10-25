<?php

namespace Drupal\views_embed_field\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Defines the 'views_embed' entity field type.
 *
 * @FieldType(
 *   id = "views_embed",
 *   label = @Translation("View embed"),
 *   default_widget = "views_embed_select",
 *   default_formatter = "views_embed_renderer"
 * )
 */
class ViewsEmbedItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = [];
    $schema['columns'] = [
      'view' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'display_id' => [
        'type' => 'varchar',
        'length' => 255,
      ],
      'args' => [
        'type' => 'varchar',
        'length' => 255,
      ],
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties = [];
    $properties['view'] = DataDefinition::create('string')
      ->setLabel(t('View'))
      ->setDescription(t('The view that should be rendered.'));
    $properties['display_id'] = DataDefinition::create('string')
      ->setLabel(t('Display ID'))
      ->setDescription(t('The display of the view we want to render.'));
    $properties['args'] = DataDefinition::create('string')
      ->setLabel(t('View arguments'))
      ->setDescription(t('Arguments for the view, seperated by /'));

    return $properties;
  }

}
