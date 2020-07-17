<?php

namespace AMBERSIVE\Ebinterface\Tests\Unit;

use Ambersive\Ebinterface\Enums\UnitTypes;

use AMBERSIVE\Tests\TestCase;

class EbInterfaceTestUnitTypesEnumTest extends TestCase
{

    public EbInterface $interface;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
    
    /**
     * Test if WEIGHT contains a list of items
     */
    public function testIfEnumWeightCanBeAccessed(): void {

        $result = UnitTypes::WEIGHT();
        
        $this->assertNotNull($result);
        $this->assertTrue(is_array($result->toArray()));
        $this->assertNotEmpty(is_array($result->toArray()));

    }

    /**
     * Test if LENGTH contains a list of items
     */
    public function testIfEnumLengthCanBeAccessed(): void {

        $result = UnitTypes::LENGTH();
        
        $this->assertNotNull($result);
        $this->assertTrue(is_array($result->toArray()));
        $this->assertNotEmpty(is_array($result->toArray()));

    }

    /**
     * Test if VOLUME contains a list of items
     */
    public function testIfEnumVolumeCanBeAccessed(): void {

        $result = UnitTypes::VOLUME();
        
        $this->assertNotNull($result);
        $this->assertTrue(is_array($result->toArray()));
        $this->assertNotEmpty(is_array($result->toArray()));

    }

    /**
     * Test if NUMERIC contains a list of items
     */
    public function testIfEnumNumericCanBeAccessed(): void {

        $result = UnitTypes::NUMERIC();
        
        $this->assertNotNull($result);
        $this->assertTrue(is_array($result->toArray()));
        $this->assertNotEmpty(is_array($result->toArray()));

    }
    
    /**
     * Test if FILESIZE contains a list of items
     */
    public function testIfEnumFilesizeCanBeAccessed(): void {

        $result = UnitTypes::FILESIZE();
        
        $this->assertNotNull($result);
        $this->assertTrue(is_array($result->toArray()));
        $this->assertNotEmpty(is_array($result->toArray()));

    }

    /**
     * Test if CURRENCY contains a list of items
     */
    public function testIfEnumCurrencyCanBeAccessed(): void {

        $result = UnitTypes::CURRENCY();
        
        $this->assertNotNull($result);
        $this->assertTrue(is_array($result->toArray()));
        $this->assertNotEmpty(is_array($result->toArray()));

    }

    /**
     * Test if TIME contains a list of items
     */
    public function testIfEnumTimeCanBeAccessed(): void {

        $result = UnitTypes::TIME();
        
        $this->assertNotNull($result);
        $this->assertTrue(is_array($result->toArray()));
        $this->assertNotEmpty(is_array($result->toArray()));

    }

    /**
     * Test if ENERGY contains a list of items
     */
    public function testIfEnumEnergyCanBeAccessed(): void {

        $result = UnitTypes::ENERGY();
        
        $this->assertNotNull($result);
        $this->assertTrue(is_array($result->toArray()));
        $this->assertNotEmpty(is_array($result->toArray()));

    }

}