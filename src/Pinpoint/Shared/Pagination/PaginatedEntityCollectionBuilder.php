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
    private $totalItemCount;
    private $isTruncated;

    private function __construct(EntityCollection $entityCollection, $totalItemCount, $isTruncated)
    {
        $this->entityCollection = $entityCollection;
        $this->totalItemCount = $totalItemCount;
        $this->isTruncated = $isTruncated;
    }

    public static function withItems(EntityCollection $entityCollection)
    {
        return new static($entityCollection, count($entityCollection), static::IS_NOT_TRUNCATED);
    }

    public static function withTruncatedItems(EntityCollection $entityCollection, $totalItemCount)
    {
        return new static($entityCollection, $totalItemCount, static::IS_TRUNCATED);
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
        $totalItemCount = $this->totalItemCount;
        $itemsPerPage = $this->itemsPerPage ?: 25;
        $firstPage = 1;
        $lastPage = ceil($totalItemCount / $itemsPerPage);
        $currentPage = $this->currentPage ?: 1;

        $items = $this->isTruncated
            ? $this->entityCollection
            : $this->entityCollection->slice(($currentPage - 1) * $itemsPerPage, $itemsPerPage);

        return new PaginatedEntityCollection(
            $items,
            $totalItemCount,
            $itemsPerPage,
            $firstPage,
            $lastPage,
            $currentPage
        );
    }
}
