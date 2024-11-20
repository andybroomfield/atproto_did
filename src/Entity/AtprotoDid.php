<?php

declare(strict_types=1);

namespace Drupal\atproto_did\Entity;

use Drupal\atproto_did\AtprotoDidInterface;
use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the at protocol did entity type.
 *
 * @ConfigEntityType(
 *   id = "atproto_did",
 *   label = @Translation("At protocol did"),
 *   label_collection = @Translation("At protocol dids"),
 *   label_singular = @Translation("at protocol did"),
 *   label_plural = @Translation("at protocol dids"),
 *   label_count = @PluralTranslation(
 *     singular = "@count at protocol did",
 *     plural = "@count at protocol dids",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\atproto_did\AtprotoDidListBuilder",
 *     "form" = {
 *       "add" = "Drupal\atproto_did\Form\AtprotoDidForm",
 *       "edit" = "Drupal\atproto_did\Form\AtprotoDidForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *   },
 *   config_prefix = "atproto_did",
 *   admin_permission = "administer atproto_did",
 *   links = {
 *     "collection" = "/admin/config/services/atproto-did",
 *     "add-form" = "/admin/config/services/atproto-did/add",
 *     "edit-form" = "/admin/config/services/atproto-did/{atproto_did}",
 *     "delete-form" = "/admin/config/services/atproto-did/{atproto_did}/delete",
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "domain" = "domain",
 *     "did" = "did",
 *     "uuid" = "uuid",
 *   },
 *   config_export = {
 *     "id",
 *     "domain",
 *     "did",
 *     "description",
 *   },
 * )
 */
final class AtprotoDid extends ConfigEntityBase implements AtprotoDidInterface {

  /**
   * The entity ID.
   */
  protected string $id;

  /**
   * The domain to respond with this did.
   *
   * @var string
   */
  protected $domain;

  /**
   * The did txt string.
   *
   * @var string
   */
  protected $did;

  /**
   * Sets the ID.
   */
  public function setId($id) {
    $this->id = $id;
    return $this;
  }

  /**
   * Get the domain for the configuration properties.
   */
  public function getDomain() {
    return $this->domain;
  }

  /**
   * Set the domain for the configuration properties.
   */
  public function setDomain($domain) {
    $this->domain = $domain;
    return $this;
  }

  /**
   * Add get/set methods for your configuration properties here.
   */
  public function label() {
    return $this->getDomain();
  }

  /**
   * Set the setLabel for the configuration.
   */
  public function setLabel($label) {
    return $this->setDomain($label);
  }

  /**
   * Get the did for the configuration properties.
   */
  public function getDid() {
    return $this->did;
  }

  /**
   * Set the Did for the configuration properties.
   */
  public function setDid($did) {
    $this->did = $did;
    return $this;
  }

}
