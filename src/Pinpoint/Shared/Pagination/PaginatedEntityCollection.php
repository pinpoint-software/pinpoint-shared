<?php

namespace Pinpoint\Shared\Pagination;

use Pinpoint\Shared\EntityCollection;

class PaginatedEntityCollection
{
    private $items;
    private $totalItems;
    private $itemsPerPage;
    private $firstPage;
    private $lastPage;
    private $currentPage;

    public function __construct(
        EntityCollection $items,
        $totalItems,
        $itemsPerPage,
        $firstPage,
        $lastPage,
        $currentPage
    ) {
        $this->items = $items;
        $this->totalItems = $totalItems;
        $this->itemsPerPage = $itemsPerPage;
        $this->firstPage = $firstPage;
        $this->lastPage = $lastPage;
        $this->currentPage = $currentPage;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function getTotalItems()
    {
        return $this->totalItems;
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
