<?php

namespace Drupal\form_subscribe\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;


/**
 * @Block (
 *   id = "subscribe_block",
 *   admin_label = @Translation("Subscribe block"),
 *   category = @Translation("Custom block"),
 * )
 */
class SubscribeBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $builtForm = \Drupal::formBuilder()->getForm('Drupal\form_subscribe\Form\SubscribeForm');
    $renderArray['form'] = $builtForm;

    return $renderArray;



//    return [
//      '#markup' => $this->t('Hello, World!'),
//    ];
  }


//  /**
//   * {@inheritdoc}
//   */
//  protected function blockAccess(AccountInterface $account) {
//    return AccessResult::allowedIfHasPermission($account, 'access content');
//    //$output = AccessResult::allowedIfHasPermission($account, 'access content');
//  }

}
