<?php
namespace Pinpoint\Shared;

class EntityCollectionTest extends \PHPUnit_Framework_TestCase
{
    protected function createEntityMock($sameIdAs = null)
    {
        $entity = $this
            ->getMockBuilder('Pinpoint\Shared\\Entity')
            ->disableOriginalConstructor()
            ->getMock();

        if (!is_null($sameIdAs)) {
            $entity
                ->expects($this->once())
                ->method('sameIdAs')
                ->will($this->returnValue($sameIdAs));
        }

        return $entity;
    }

    public function testEmptyCount()
    {
        $entityCollection = new EntityCollection();

        $this->assertEquals(
            0,
            count($entityCollection)
        );
    }

    public function testEmptySeek()
    {
        $entityCollection = new EntityCollection();

        $this->setExpectedException('OutOfBoundsException');

        $entityCollection->seek(0);
    }

    public function testEmptyValid()
    {
        $entityCollection = new EntityCollection();

        $this->assertFalse($entityCollection->valid());
    }

    public function testSingleCount()
    {
        $entity = $this->createEntityMock();

        $entityCollection = new EntityCollection();

        $entityCollection->addEntity($entity);

        $this->assertEquals(
            1,
            count($entityCollection)
        );
    }

    public function testSingleSeek()
    {
        $entity = $this->createEntityMock();

        $entityCollection = new EntityCollection();

        $entityCollection->addEntity($entity);

        $entityCollection->seek(0);

        $this->assertTrue($entityCollection->valid());

        $this->assertEquals(
            0,
            $entityCollection->key()
        );
    }

    public function testSingleCurrent()
    {
        $entity = $this->createEntityMock();

        $entityCollection = new EntityCollection();

        $entityCollection->addEntity($entity);

        $this->assertSame(
            $entity,
            $entityCollection->current()
        );
    }

    public function testDoubleCount()
    {
        $entity1 = $this->createEntityMock();
        $entity2 = $this->createEntityMock();

        $entityCollection = new EntityCollection();

        $entityCollection->addEntity($entity1);
        $entityCollection->addEntity($entity2);

        $this->assertEquals(
            2,
            count($entityCollection)
        );
    }

    public function testDoubleSeek()
    {
        $entity1 = $this->createEntityMock();
        $entity2 = $this->createEntityMock();

        $entityCollection = new EntityCollection();

        $entityCollection->addEntity($entity1);
        $entityCollection->addEntity($entity2);

        $entityCollection->seek(1);

        $this->assertTrue($entityCollection->valid());

        $this->assertEquals(
            1,
            $entityCollection->key()
        );
    }

    public function testNext()
    {
        $entity1 = $this->createEntityMock();
        $entity2 = $this->createEntityMock();

        $entityCollection = new EntityCollection();

        $entityCollection->addEntity($entity1);
        $entityCollection->addEntity($entity2);

        $entityCollection->next();

        $this->assertTrue($entityCollection->valid());

        $this->assertEquals(
            1,
            $entityCollection->key()
        );
    }

    public function testRewind()
    {
        $entity1 = $this->createEntityMock();
        $entity2 = $this->createEntityMock();

        $entityCollection = new EntityCollection();

        $entityCollection->addEntity($entity1);
        $entityCollection->addEntity($entity2);

        $entityCollection->next();

        $this->assertTrue($entityCollection->valid());

        $this->assertEquals(
            1,
            $entityCollection->key()
        );

        $entityCollection->rewind();

        $this->assertEquals(
            0,
            $entityCollection->key()
        );
    }

    public function testRemove()
    {
        $entity1 = $this->createEntityMock(true);
        $entity2 = $this->createEntityMock(false);

        $entityCollection = new EntityCollection();

        $entityCollection->addEntity($entity1);
        $entityCollection->addEntity($entity2);
        $entityCollection->removeEntity($entity1);

        $this->assertTrue($entityCollection->valid());

        $this->assertEquals(
            0,
            $entityCollection->key()
        );

        $this->assertSame(
            $entity2,
            $entityCollection->current()
        );
    }

    public function testOffsetExists()
    {
        $entity1 = $this->createEntityMock();
        $entity2 = $this->createEntityMock();

        $entityCollection1 = new EntityCollection();
        $entityCollection1->addEntity($entity1);
        $entityCollection1->addEntity($entity2);

        $this->assertTrue(isset($entityCollection1[0]));
        $this->assertTrue(isset($entityCollection1[1]));
        $this->assertFalse(isset($entityCollection1[2]));
    }

    public function testOffsetSet()
    {
        $entity1 = $this->createEntityMock();
        $entity2 = $this->createEntityMock();

        $entityCollection1 = new EntityCollection();
        $entityCollection1[] = $entity1;
        $entityCollection1[1] = $entity2;

        $this->assertCount(2, $entityCollection1);
        $this->assertTrue($entity1 === $entityCollection1[0]);
        $this->assertTrue($entity2 === $entityCollection1[1]);
    }

    public function testOffsetUnset()
    {
        $entity1 = $this->createEntityMock();
        $entity2 = $this->createEntityMock();

        $entityCollection1 = new EntityCollection();
        $entityCollection1->addEntity($entity1);
        $entityCollection1->addEntity($entity2);

        unset($entityCollection1[0]);

        $this->assertCount(1, $entityCollection1);

        // This is weird because if we remove index 0, the other
        // entity stays at index 1. I think this is as expected
        // for PHP in general, though?
        $this->assertTrue($entity2 === $entityCollection1[1]);
    }

    public function testSameAsHashSuccess()
    {
        $entity1 = $this->createEntityMock();
        $entity2 = $this->createEntityMock();

        $entityCollection1 = new EntityCollection();
        $entityCollection1->addEntity($entity1);
        $entityCollection1->addEntity($entity2);

        $entityCollection2 = new EntityCollection();
        $entityCollection2->addEntity($entity1);
        $entityCollection2->addEntity($entity2);

        $this->assertTrue($entityCollection1->sameHashAs($entityCollection2));
    }

    public function testSameAsHashFailure()
    {
        $entity1 = $this->createEntityMock();
        $entity2 = $this->createEntityMock();

        $entityCollection1 = new EntityCollection();
        $entityCollection1->addEntity($entity1);
        $entityCollection1->addEntity($entity2);

        $entityCollection2 = new EntityCollection();
        $entityCollection2->addEntity($entity1);

        $this->assertFalse($entityCollection1->sameHashAs($entityCollection2));
    }
}
