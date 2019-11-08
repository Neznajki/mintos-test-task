<?php declare(strict_types=1);


namespace App\Repository;


use App\Entity\ExternalId;
use App\Entity\FeedTitle;
use App\Entity\TypeCollection;
use App\ValueObject\FeedSummary;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

/**
 * Class FeedTitleRepository
 * @package App\Repository
 *
 * @method FeedTitle|null findOneBy(array $criteria, array $orderBy = null)
 * @method FeedTitle[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method FeedTitle[] findAll()
 * @method FeedTitle|null find($id, $lockMode = null, $lockVersion = null)
 */
class FeedTitleRepository extends EntityRepository
{
    /**
     * @param FeedSummary $feedEntry
     * @param ExternalId $externalId
     * @param TypeCollection $type
     * @return FeedTitle
     * @throws ORMException
     */
    public function getOrCreateEntityByData(
        \App\ValueObject\FeedTitle $feedEntry,
        ExternalId $externalId,
        TypeCollection $type
    ): FeedTitle {
        $existing = $this->findOneBy(
            [
                'external' => $externalId,
            ]
        );

        if ($existing) {
            $existing->setType($type);
            $existing->setContent($feedEntry->getContent());

            return $existing;
        }

        $new = new FeedTitle();

        $new->setExternal($externalId);
        $new->setType($type);
        $new->setContent($feedEntry->getContent());
        $new->setImported(new DateTime());

        $this->getEntityManager()->persist($new);

        return $new;
    }
}
