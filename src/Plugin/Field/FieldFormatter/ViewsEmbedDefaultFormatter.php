<?php

namespace Drupal\views_embed_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'views_embed_renderer' formatter.
 *
 * @FieldFormatter(
 *   id = "views_embed_renderer",
 *   label = @Translation("Render view"),
 *   field_types = {
 *     "views_embed",
 *   }
 * )
 */
class ViewsEmbedDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    return [$this->t('Render view entities')];
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    foreach ($items as $delta => $item) {
      $values = $item->getValue();
      if (empty($values['view'])) {
        continue;
      }

      $args = [$values['view']];
      if (!empty($values['display_id'])) {
        $args[] = $values['display_id'];
      }

      if (!empty($values['args'])) {
        $args += explode('/', $values['args']);
      }

      $element[$delta] = call_user_func('views_embed_view', $args);;
    }

    return $element;
  }

}
