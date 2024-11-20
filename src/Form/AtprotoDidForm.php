<?php

declare(strict_types=1);

namespace Drupal\atproto_did\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\atproto_did\Entity\AtprotoDid;

/**
 * At protocol did form.
 */
final class AtprotoDidForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state): array {

    $form = parent::form($form, $form_state);

    $atproto_did = $this->entity;

    $form['domain'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Domain'),
      '#default_value' => $atproto_did->getDomain(),
      '#description' => $this->t('The domain to respond with this atproto-did.'),
      '#disabled' => !$atproto_did->isNew(),
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $atproto_did->id(),
      '#maxlength' => EntityTypeInterface::BUNDLE_MAX_LENGTH,
      '#disabled' => !$atproto_did->isNew(),
      '#machine_name' => [
        'exists' => [
          'Drupal\atproto_did\Entity\AtprotoDid',
          'load',
        ],
        'source' => ['domain'],
      ],
      '#description' => $this->t('A unique machine-readable name for this atproto-did. It must only contain lowercase letters, numbers, and underscores.'),
    ];

    $form['did'] = [
      '#type' => 'textfield',
      '#title' => $this->t('did'),
      '#default_value' => $atproto_did->getDid(),
      '#description' => $this->t("Contents of the did."),
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $atproto_did = $this->entity;

    // Check domain is unique.
    if ($atproto_did->isNew()) {
      $domain = $atproto_did->getDomain();
      $exists = $this->entityTypeManager->getStorage('atproto_did')
        ->getQuery()
        ->condition('domain', $domain)
        ->accessCheck(TRUE)
        ->execute();
      if ($exists) {
        $form_state->setErrorByName('domain', $this->t('The domain must be unique.'));
        return FALSE;
      }
    }

    return parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state): int {
    $atproto_did = $this->entity;

    // Set the ID if this is a new entity.
    if ($atproto_did->isNew()) {
      $atproto_did->setId($atproto_did->id());
    }

    $result = parent::save($form, $form_state);
    $message_args = ['%label' => $this->entity->label()];
    $this->messenger()->addStatus(
      match($result) {
        \SAVED_NEW => $this->t('Created new example %label.', $message_args),
        \SAVED_UPDATED => $this->t('Updated example %label.', $message_args),
      }
    );
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));
    return $result;
  }

}
