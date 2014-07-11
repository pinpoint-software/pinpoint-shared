<?php

namespace Pinpoint\Shared\Pagination;

use Pinpoint\Shared\EntityCollection;

class PaginatedEntityCollection
{
    private $items;
    private $totalItemCount;
    private $itemsPerPage;
    private $firstPage;
    private $lastPage;
    private $currentPage;

    public function __construct(
        EntityCollection $items,
        $totalItemCount,
        $itemsPerPage,
        $firstPage,
        $lastPage,
        $currentPage
    ) {
        $this->items = $items;
        $this->totalItemCount = $totalItemCount;
        $this->itemsPerPage = $itemsPerPage;
        $this->firstPage = $firstPage;
        $this->lastPage = $lastPage;
        $this->currentPage = $currentPage;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function getTotalItemCount()
    {
        return $this->totalItemCount;
    }

    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    public function getFirstPage()
    {
        return $this->firstPage;
    }

    public function getLastPage()
    {
        return $this->lastPage;
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }
}
