<?php

namespace MakinaCorpus\Drupal\Sf\EventDispatcher;

use Drupal\Core\Entity\EntityInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class EntityEvent extends GenericEvent
{
    use EntityEventTrait;

    const EVENT_DELETE      = 'entity:delete';
    const EVENT_INSERT      = 'entity:insert';
    const EVENT_PREINSERT   = 'entity:preinsert';
    const EVENT_PREPARE     = 'entity:prepare';
    const EVENT_PREUPDATE   = 'entity:preupdate';
    const EVENT_PRESAVE     = 'entity:presave';
    const EVENT_SAVE        = 'entity:save';
    const EVENT_UPDATE      = 'entity:update';
    const EVENT_VIEW        = 'entity:view';

    /**
     * Default constructor
     */
    public function __construct(string $eventName, string $entityType, EntityInterface $entity, $userId = null, array $arguments = [])
    {
        $this->setEventName($eventName);
        $this->setEntityType($entityType);
        $this->setUserId($userId);

        // Keeping the 'uid' in arguments allows compatibility with the
        // makinacorpus/apubsub API, using subject too
        parent::__construct($entity, $arguments + ['uid' => $userId, 'id' => $entity->id(), 'bundle' => $entity->bundle()]);
    }

    /**
     * Get original entity
     */
    public function getOriginalEntity(): EntityInterface
    {
        $entity = $this->getEntity();

        if ($entity->isNew()) {
            throw new \LogicException(sprintf('entity is new for event %s', $this->getEventName()));
        }

        return \Drupal::entityTypeManager()->getStorage($entity->getEntityTypeId())->loadUnchanged($entity->id());
    }

    /**
     * Get entity bundle
     */
    final public function getEntityBundle(): string
    {
        return $this->getArgument('bundle') ?? '';
    }

    /**
     * Get entity id
     *
     * @return int|string
     */
    final public function getEntityId()
    {
        return $this->getArgument('id');
    }

    /**
     * Get the entity
     */
    final public function getEntity(): EntityInterface
    {
        return $this->subject;
    }
}
