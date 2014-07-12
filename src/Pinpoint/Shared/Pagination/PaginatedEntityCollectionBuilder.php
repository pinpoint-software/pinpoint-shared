<?php

namespace Pinpoint\Shared\Pagination;

use Pinpoint\Shared\EntityCollection;

class PaginatedEntityCollectionBuilder
{
    const IS_TRUNCATED = true;
    const IS_NOT_TRUNCATED = false;

    private $entityCollection;
    private $itemsPerPage;
    private $currentPage;
    private $totalItems;
    private $isTruncated;

    private function __construct(EntityCollection $entityCollection, $totalItems, $isTruncated)
    {
        $this->entityCollection = $entityCollection;
        $this->totalItems = $totalItems;
        $this->isTruncated = $isTruncated;
    }

    public static function withItems(EntityCollection $entityCollection)
    {
        return new static($entityCollection, count($entityCollection), static::IS_NOT_TRUNCATED);
    }

    public static function withTruncatedItems(EntityCollection $entityCollection, $totalItems)
    {
        return new static($entityCollection, $totalItems, static::IS_TRUNCATED);
    }

    public function itemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;

        return $this;
    }

    public function currentPage($currentPage)
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    public function build()
    {
        $totalItems = $this->totalItems;
        $itemsPerPage = $this->itemsPerPage ?: 25;
        $firstPage = 1;
        $lastPage = ceil($totalItems / $itemsPerPage);
        $currentPage = $this->currentPage ?: 1;

        $items = $this->isTruncated
            ? $this->entityCollection
            : $this->entityCollection->slice(($currentPage - 1) * $itemsPerPage, $itemsPerPage);

        return new PaginatedEntityCollection(
            $items,
            $totalItems,
            $itemsPerPage,
            $firstPage,
            $lastPage,
            $currentPage
        );
    }
}
