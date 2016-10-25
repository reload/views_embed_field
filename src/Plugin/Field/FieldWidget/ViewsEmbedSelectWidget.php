<?php

namespace Drupal\views_embed_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Views;

/**
 * Plugin implementation of the 'views_embed_select' widget.
 *
 * @FieldWidget(
 *   id = "views_embed_select",
 *   label = @Translation("Views select list"),
 *   field_types = {
 *     "views_embed"
 *   },
 * )
 */
class ViewsEmbedSelectWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    /* @var \Drupal\views_embed_field\Plugin\Field\FieldType\ViewsEmbedItem $item */
    $item = $items->first();
    $options = Views::getViewsAsOptions($views_only = FALSE, $filter = 'enabled', $exclude_view = NULL, $optgroup = TRUE);

    if (isset($element['#parents']) && in_array('default_value_input', $element['#parents'])) {
      $required = FALSE;
    }
    else {
      $required = TRUE;
    }
    $item_value = $item->getValue();

    $element['view_selector'] = [
      '#title' => $this->t('Available views'),
      '#type' => 'select',
      '#required' => $required,
      '#empty_value' => '',
      '#default_value' => (!empty($item_value['view'])) ? implode(':', $item_value) : NULL,
      '#options' => $options,
    ];
    $element['view_args'] = [
      '#title' => $this->t('Arguments'),
      '#type' => 'textfield',
      '#default_value' => (!empty($item_value['args'])) ? $item_value['args'] : NULL,
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    foreach ($values as $delta => $value) {
      if (!empty($value['view_selector'])) {
        $view = explode(':', $value['view_selector']);
        $values[$delta]['view'] = $view[0];
        $values[$delta]['display_id'] = $view[1];
      }
    }
    return $values;
  }
}
