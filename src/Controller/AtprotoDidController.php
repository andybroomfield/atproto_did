<?php

namespace Drupal\atproto_did\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class .well-known atproto-did controller.
 */
class AtprotoDidController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Entity type manager.
   *
   * @var Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   Entity type manager service.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Well Known output.
   *
   * @param Symfony\Component\HttpFoundation\Request $request
   *   Request object.
   */
  public function wellKnown(Request $request) {

    // Find the domain.
    $domain = $request->server->get('HTTP_HOST');

    // Load the entity.
    $storage = $this->entityTypeManager->getStorage('atproto_did');
    $result = $storage->getQuery()->condition('domain', $domain)->execute();

    // This should always be the first entity with the domain.
    if (is_array($result)) {
      $atproto_did = $storage->load(reset($result));
    }

    // If the entity exists...
    if (!empty($atproto_did)) {

      // Output the .txt file.
      $did = $atproto_did->getDid();
      $response = new Response($did, 200, ['Content-Type' => 'text/plain']);
      return $response;
    }

    // If no domain found, send 404.
    throw new NotFoundHttpException();
  }

}
