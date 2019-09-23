<?php
/**
 * Created by PhpStorm.
 * User: konra
 * Date: 23.09.2019 21:19
 */

namespace App\EventListener;

use App\Entity\LikeNotification;
use App\Entity\MicroPost;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\PersistentCollection;

final class LikeNotificationSubscriber implements EventSubscriber
{

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public function getSubscribedEvents()
    {
        return [
            Events::onFlush
        ];
    }

    public function onFlush(OnFlushEventArgs $args)
    {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        /** @var PersistentCollection $collectionUpdate */
        foreach ($uow->getScheduledCollectionUpdates() as $collectionUpdate) {
            if (!$collectionUpdate->getOwner() instanceof MicroPost) {
                continue;
            }

            if ($collectionUpdate->getMapping()['fieldName'] !== 'likedBy') {
                continue;
            }

            $insertDiff = $collectionUpdate->getInsertDiff();

            if (!count($insertDiff)) {
                return;
            }

            /** @var MicroPost $microPost */
            $microPost = $collectionUpdate->getOwner();

            $notification = new LikeNotification();
            $notification->setUser($microPost->getUser());
            $notification->setMicroPost($microPost);
            $notification->setLikedBy(reset($insertDiff));

            $em->persist($notification);

            $uow->computeChangeSet($em->getClassMetadata(LikeNotification::class), $notification);
        }
    }
}