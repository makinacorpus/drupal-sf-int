<?php

namespace MakinaCorpus\Drupal\Sf\EventDispatcher;

use Symfony\Component\EventDispatcher\GenericEvent;

class EntityCollectionEvent extends GenericEvent
{
    use EntityEventTrait;

    const EVENT_LOAD        = 'entity:load';
    const EVENT_PREPAREVIEW = 'entity:prepareview';

    private $idList;
    private $bundleList;
    private $bundleMap;

    /**
     * Default constructor
     */
    public function __construct(string $eventName, string $entityType, array $entities, $userId = null, array $arguments = [])
    {
        $this->setEventName($eventName);
        $this->setEntityType($entityType);
        $this->setUserId($userId);

        // Keeping the 'uid' in arguments allows compatibility with the
        // makinacorpus/apubsub API, using subject too
        parent::__construct($entities, $arguments + ['uid' => $userId]);
    }

    /**
     * Prepare internal bundle and id list cache
     */
    private function buildListCache()
    {
        if (null !== $this->idList) {
            return;
        }

        /** @var \Drupal\Core\Entity\EntityInterface $entity */
        foreach ($this->subject as $entity) {
            $this->idList[] = $id = $entity->id();
            $this->bundleList[$id] = $bundle = $entity->bundle();
            $this->bundleList = $bundle;
            $this->bundleList = array_unique($this->bundleList);
        }
    }

    /**
     * Get an array of all entity identifiers
     *
     * @return int[]|string[]
     */
    final public function getEntityIdList(): array
    {
        $this->buildListCache();

        return $this->idList;
    }

    /**
     * Get an array of all bundles
     *
     * @return int[]|string[]
     */
    final public function getEntityBundleList(): array
    {
        $this->buildListCache();

        return $this->bundleList;
    }

    /**
     * Get an array of bundles, keyed by entity identifiers
     *
     * @return string[]
     */
    final public function getEntityBundleMap(): array
    {
        $this->buildListCache();

        return $this->bundleMap;
    }

    /**
     * Get the nodes
     *
     * @return \Drupal\Core\Entity\EntityInterface[]
     */
    final public function getEntities(): array
    {
        return $this->subject;
    }
}
