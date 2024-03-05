<?php

declare(strict_types=1);

namespace Z7\Lalalytics\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
use TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface;

class EventRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    private QuerySettingsInterface $querySettings;

    public function injectQuerySettings(QuerySettingsInterface $querySettings): void
    {
        $this->querySettings = $querySettings;
    }

    public function initializeObject(): void
    {
        $querySettings = clone $this->querySettings;

        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }

    public function findBySite(string $identifier): QueryResult
    {
        $query = $this->createQuery();
        $query->matching($query->logicalOr(...array_values([
            $query->equals('site', ''),
            $query->equals('site', $identifier)
        ])));
        return $query->execute();
    }
}
