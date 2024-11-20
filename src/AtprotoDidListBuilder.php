<?php

declare(strict_types=1);

namespace Drupal\atproto_did;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of at protocol dids.
 */
final class AtprotoDidListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['Domain'] = $this->t('Domain');
    $header['did'] = $this->t('did');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    /** @var \Drupal\atproto_did\AtprotoDidInterface $entity */
    $row['domain'] = $entity->getDomain();
    $row['did'] = $entity->getDid();
    return $row + parent::buildRow($entity);
  }

}
