<?php
namespace Pinpoint\Shared\Pagination;

use Pinpoint\Shared\Entity;
use Pinpoint\Shared\EntityCollection;

class PaginatedEntityCollectionBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function getTestEntityCollection($startingValue, $numberOfEntities)
    {
        $entityCollection = new EntityCollection();

        foreach (range($startingValue, $numberOfEntities) as $value) {
            $entityCollection->addEntity(new FakeEntity($value));
        }

        return $entityCollection;
    }

    public function testPaginatedItems()
    {
        $entityCollection = $this->getTestEntityCollection(1, 100);

        $paginatedEntityCollection = PaginatedEntityCollectionBuilder::withItems($entityCollection)
            ->itemsPerPage(10)
            ->build();

        $items = $paginatedEntityCollection->getItems();
        $this->assertEquals(1, $paginatedEntityCollection->getFirstPage());
        $this->assertEquals(10, $paginatedEntityCollection->getLastPage());
        $this->assertEquals(10, count($items));
        $this->assertEquals(1, $items[0]->getValue());
        $this->assertEquals(100, $paginatedEntityCollection->getTotalItems());
        $this->assertEquals(10, $paginatedEntityCollection->getItemsPerPage());
        $this->assertEquals(1, $paginatedEntityCollection->getCurrentPage());
    }

    public function testPaginatedItemsSecondPage()
    {
        $entityCollection = $this->getTestEntityCollection(1, 100);

        $paginatedEntityCollection = PaginatedEntityCollectionBuilder::withItems($entityCollection)
            ->itemsPerPage(10)
            ->currentPage(2)
            ->build();

        $items = $paginatedEntityCollection->getItems();
        $this->assertEquals(1, $paginatedEntityCollection->getFirstPage());
        $this->assertEquals(10, $paginatedEntityCollection->getLastPage());
        $this->assertEquals(10, count($items));
        $this->assertEquals(11, $items[0]->getValue());
        $this->assertEquals(100, $paginatedEntityCollection->getTotalItems());
        $this->assertEquals(10, $paginatedEntityCollection->getItemsPerPage());
        $this->assertEquals(2, $paginatedEntityCollection->getCurrentPage());
    }

    public function testTruncatedPaginatedItems()
    {
        $entityCollection = $this->getTestEntityCollection(1, 10);

        $paginatedEntityCollection = PaginatedEntityCollectionBuilder::withTruncatedItems($entityCollection, 100)
            ->itemsPerPage(10)
            ->build();

        $items = $paginatedEntityCollection->getItems();
        $this->assertEquals(1, $paginatedEntityCollection->getFirstPage());
        $this->assertEquals(10, $paginatedEntityCollection->getLastPage());
        $this->assertEquals(10, count($items));
        $this->assertEquals(1, $items[0]->getValue());
        $this->assertEquals(100, $paginatedEntityCollection->getTotalItems());
        $this->assertEquals(10, $paginatedEntityCollection->getItemsPerPage());
        $this->assertEquals(1, $paginatedEntityCollection->getCurrentPage());
    }

    public function testTruncatedPaginatedItemsSecondPage()
    {
        $entityCollection = $this->getTestEntityCollection(11, 20);

        $paginatedEntityCollection = PaginatedEntityCollectionBuilder::withTruncatedItems($entityCollection, 100)
            ->itemsPerPage(10)
            ->currentPage(2)
            ->build();

        $items = $paginatedEntityCollection->getItems();
        $this->assertEquals(1, $paginatedEntityCollection->getFirstPage());
        $this->assertEquals(10, $paginatedEntityCollection->getLastPage());
        $this->assertEquals(10, count($items));
        $this->assertEquals(11, $items[0]->getValue());
        $this->assertEquals(100, $paginatedEntityCollection->getTotalItems());
        $this->assertEquals(10, $paginatedEntityCollection->getItemsPerPage());
        $this->assertEquals(2, $paginatedEntityCollection->getCurrentPage());
    }
}

class FakeEntity implements Entity
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getId()
    {
        throw new \RuntimeException("Not implemented.");
    }

    public function sameIdAs($other = null)
    {
        throw new \RuntimeException("Not implemented.");
    }
}
