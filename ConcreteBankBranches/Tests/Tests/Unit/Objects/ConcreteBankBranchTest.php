<?php
namespace ConcreteBankBranches\Tests\Tests\Unit\Objects;
use ConcreteBankBranches\Infrastructure\Objects\ConcreteBankBranch;
use DateTimes\Tests\Helpers\DateTimeHelper;
use Primitives\Tests\Helpers\PrimitiveHelper;
use Entities\Domain\Entities\Exceptions\CannotCreateEntityException;

final class ConcreteBankBranchTest extends \PHPUnit_Framework_TestCase {
    
    private $uuidMock;
    private $integerMock;
    private $dateTimeMock;
    private $booleanAdapterMock;
    private $bankMock;
    private $addressMock;
    private $createdOnTimestampElement;
    private $lastUpdatedOnTimestampElement;
    private $transitNumberElement;
    private $emptyTransitNumberElement;
    private $dateTimeHelper;
    private $integerHelper;
    public function setUp() {
        
        $this->uuidMock = $this->getMock('Uuids\Domain\Uuids\Uuid');
        $this->integerMock = $this->getMock('Integers\Domain\Integers\Integer');
        $this->dateTimeMock = $this->getMock('DateTimes\Domain\DateTimes\DateTime');
        $this->booleanAdapterMock = $this->getMock('Booleans\Domain\Booleans\Adapters\BooleanAdapter');
        $this->bankMock = $this->getMock('Banks\Domain\Banks\Bank');
        $this->addressMock = $this->getMock('Addresses\Domain\Addresses\Address');
        
        $this->createdOnTimestampElement = time() - (24 * 60 * 60);
        $this->lastUpdatedOnTimestampElement = time();
        $this->transitNumberElement = 125;
        $this->emptyTransitNumberElement = null;
        
        $this->dateTimeHelper = new DateTimeHelper($this, $this->dateTimeMock);
        $this->integerHelper = new PrimitiveHelper($this, $this->integerMock);
        
    }
    
    public function tearDown() {
        
    }
    
    public function testCreate_Success() {
        
        $this->integerHelper->expectsGet_multiple_Success(array($this->transitNumberElement));
        
        $bankBranch = new ConcreteBankBranch($this->uuidMock, $this->bankMock, $this->addressMock, $this->integerMock, $this->dateTimeMock, $this->booleanAdapterMock);
        
        $this->assertEquals($this->uuidMock, $bankBranch->getUuid());
        $this->assertEquals($this->bankMock, $bankBranch->getBank());
        $this->assertEquals($this->addressMock, $bankBranch->getAddress());
        $this->assertEquals($this->integerMock, $bankBranch->getTransitNumber());
        $this->assertEquals($this->dateTimeMock, $bankBranch->createdOn());
        $this->assertNull($bankBranch->lastUpdatedOn());
        
        $this->assertTrue($bankBranch instanceof \BankBranches\Domain\BankBranches\BankBranch);
        $this->assertTrue($bankBranch instanceof \ConcreteEntities\Infrastructure\Objects\AbstractEntity);
        
    }
    
    public function testCreate_withEmptyTransitNumberElement_Success() {
        
        $this->integerHelper->expectsGet_Success($this->emptyTransitNumberElement);
        
        $asserted = false;
        try {
        
            new ConcreteBankBranch($this->uuidMock, $this->bankMock, $this->addressMock, $this->integerMock, $this->dateTimeMock, $this->booleanAdapterMock);
            
        } catch (CannotCreateEntityException $exception) {
            $asserted = true;
        }
        
        $this->assertTrue($asserted);
        
    }
    
    
    public function testCreate_withLastUpdatedOn_Success() {
        
        $this->dateTimeHelper->expectsGetTimestamp_multiple_Success(array($this->integerMock, $this->integerMock));
        $this->integerHelper->expectsGet_multiple_Success(array($this->transitNumberElement, $this->createdOnTimestampElement, $this->lastUpdatedOnTimestampElement));
        
        $bankBranch = new ConcreteBankBranch($this->uuidMock, $this->bankMock, $this->addressMock, $this->integerMock, $this->dateTimeMock, $this->booleanAdapterMock, $this->dateTimeMock);
        
        $this->assertEquals($this->uuidMock, $bankBranch->getUuid());
        $this->assertEquals($this->bankMock, $bankBranch->getBank());
        $this->assertEquals($this->addressMock, $bankBranch->getAddress());
        $this->assertEquals($this->integerMock, $bankBranch->getTransitNumber());
        $this->assertEquals($this->dateTimeMock, $bankBranch->createdOn());
        $this->assertEquals($this->dateTimeMock, $bankBranch->lastUpdatedOn());
        
    }
}