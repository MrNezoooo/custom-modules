<?php

namespace Drupal\module_article\Plugin\Block;

use Drupal\Core\Block\BlockBase;

use Drupal\Core\Form\FormStateInterface;


/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "module_article",
 *   admin_label = @Translation("Module Articles"),
 *   category = @Translation("Custom block"),
 * )
 */
class ModuleArticleBlock extends BlockBase {


  /**
   * {@inheritdoc}
   */
  public function build() {

    // Config block.
    $config = $this->getConfiguration();
    // Node storage
    $nodeStorage = \Drupal::entityTypeManager()->getStorage('node');

    $ids = $nodeStorage->getQuery()
      ->condition('status', 1)
      ->condition('type', 'article')
      ->range(0, $config["quantity_nodes"])  // 5
      ->execute();

    $nodes = $nodeStorage->loadMultiple($ids);

    $build = [];
    /** @var \Drupal\node\Entity\Node $node */
    foreach ($nodes as $node) {
      $link = [
        '#type' => 'link',
        '#url' => $node->toUrl(),
        '#title' => $node->getTitle(),
      ];

      $build[] = $link;
    }

    return [
      '#theme' => 'my_custom_block',
      '#titles' => $build,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    // Retrieve existing configuration for this block. Отримати існуючу конфігурацію для цього блоку.
    $config = $this->getConfiguration();


    // Format options for quantity nodes form field.
    $quantity_nodes_options = [
      '5' => '5 nodes',
      '10' => '10 nodes',
      '15' => '15 nodes'
    ];


    $form['quantity_nodes'] = [
      '#type' => 'select',
      '#options' => $quantity_nodes_options,
      '#title' => $this->t('Quantity nodes'),
      '#default_value' => $config['quantity_nodes'] ?? $quantity_nodes_options[1],
    ];

    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    // Save our custom settings when the form is submitted.
    $this->setConfigurationValue('quantity_nodes', $form_state->getValue('quantity_nodes'));
  }
}
