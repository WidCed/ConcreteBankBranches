<?php
namespace ConcreteBankBranches\Tests\Tests\Unit\Builders;
use ConcreteBankBranches\Infrastructure\Builders\ConcreteBankBranchBuilder;
use DateTimes\Tests\Helpers\DateTimeHelper;
use Primitives\Tests\Helpers\PrimitiveHelper;
use ObjectLoaders\Tests\Helpers\ObjectLoaderAdapterHelper;
use ObjectLoaders\Tests\Helpers\ObjectLoaderHelper;
use Entities\Domain\Entities\Builders\Exceptions\CannotBuildEntityException;

final class ConcreteBankBranchBuilderTest extends \PHPUnit_Framework_TestCase {
    
    private $objectLoaderAdapterMock;
    private $objectLoaderMock;
    private $uuidMock;
    private $integerMock;
    private $bankMock;
    private $dateTimeMock;
    private $booleanAdapterMock;
    private $classNameElement;
    private $createdOnTimestampElement;
    private $lastUpdatedOnTimestampElement;
    private $addressMock;
    private $builder;
    private $transitNumberElement;
    private $objectLoaderAdapterHelper;
    private $objectLoaderHelper;
    private $dateTimeHelper;
    private $integerHelper;
    private $bankBranchMock;
    public function setUp() {
        
        $this->objectLoaderAdapterMock = $this->getMock('ObjectLoaders\Domain\ObjectLoaders\Adapters\ObjectLoaderAdapter');
        $this->objectLoaderMock = $this->getMock('ObjectLoaders\Domain\ObjectLoaders\ObjectLoader');
        $this->uuidMock = $this->getMock('Uuids\Domain\Uuids\Uuid');
        $this->integerMock = $this->getMock('Integers\Domain\Integers\Integer');
        $this->bankMock = $this->getMock('Banks\Domain\Banks\Bank');
        $this->dateTimeMock = $this->getMock('DateTimes\Domain\DateTimes\DateTime');
        $this->booleanAdapterMock = $this->getMock('Booleans\Domain\Booleans\Adapters\BooleanAdapter');
        $this->addressMock = $this->getMock('Addresses\Domain\Addresses\Address');
        $this->bankBranchMock = $this->getMock('BankBranches\Domain\BankBranches\BankBranch');
        
        $this->classNameElement = 'ConcreteBankBranches\Infrastructure\Objects\ConcreteBankBranch';
        $this->createdOnTimestampElement = time() - (24 * 60 * 60);
        $this->lastUpdatedOnTimestampElement = time();
        $this->transitNumberElement = 125;
        
        $this->builder = new ConcreteBankBranchBuilder($this->booleanAdapterMock, $this->objectLoaderAdapterMock);
        
        $this->objectLoaderAdapterHelper = new ObjectLoaderAdapterHelper($this, $this->objectLoaderAdapterMock);
        $this->objectLoaderHelper = new ObjectLoaderHelper($this, $this->objectLoaderMock);
        $this->dateTimeHelper = new DateTimeHelper($this, $this->dateTimeMock);
        $this->integerHelper = new PrimitiveHelper($this, $this->integerMock);
        
    }
    
    public function tearDown() {
        
    }
    
    public function testBuild_Success() {
        
        $this->objectLoaderAdapterHelper->expects_convertClassNameElementToObjectLoader_Success($this->objectLoaderMock, $this->classNameElement);
        $this->objectLoaderHelper->expects_instantiate_Success($this->bankBranchMock, array($this->uuidMock, $this->bankMock, $this->addressMock, $this->integerMock, $this->dateTimeMock, $this->booleanAdapterMock));
        $this->integerHelper->expectsGet_multiple_Success(array($this->transitNumberElement));
        
        $bankBranch = $this->builder->create()
                                ->withUuid($this->uuidMock)
                                ->withBank($this->bankMock)
                                ->withAddress($this->addressMock)
                                ->withTransitNumber($this->integerMock)
                                ->createdOn($this->dateTimeMock)
                                ->now();
        
        $this->assertEquals($this->bankBranchMock, $bankBranch);
        
    }
    
    public function testBuild_throwsCannotInstantiateObjectException_throwsCannotBuildEntityException() {
        
        $this->objectLoaderAdapterHelper->expects_convertClassNameElementToObjectLoader_Success($this->objectLoaderMock, $this->classNameElement);
        $this->objectLoaderHelper->expects_instantiate_throwsCannotInstantiateObjectException(array($this->uuidMock, $this->bankMock, $this->addressMock, $this->integerMock, $this->dateTimeMock, $this->booleanAdapterMock));
        
        $asserted = false;
        try {
        
            $this->builder->create()
                            ->withUuid($this->uuidMock)
                            ->withBank($this->bankMock)
                            ->withAddress($this->addressMock)
                            ->withTransitNumber($this->integerMock)
                            ->createdOn($this->dateTimeMock)
                            ->now();
            
        } catch (CannotBuildEntityException $exception) {
            $asserted = true;
        }
        
        $this->assertTrue($asserted);
        
    }
    
    public function testBuild_throwsCannotConvertClassNameElementToObjectLoaderException_throwsCannotBuildEntityException() {
        
        $this->objectLoaderAdapterHelper->expects_convertClassNameElementToObjectLoader_throwsCannotConvertClassNameElementToObjectLoaderException($this->classNameElement);
        
        $asserted = false;
        try {
        
            $this->builder->create()
                            ->withUuid($this->uuidMock)
                            ->withBank($this->bankMock)
                            ->withAddress($this->addressMock)
                            ->withTransitNumber($this->integerMock)
                            ->createdOn($this->dateTimeMock)
                            ->now();
            
        } catch (CannotBuildEntityException $exception) {
            $asserted = true;
        }
        
        $this->assertTrue($asserted);
        
    }
    
    public function testBuild_withoutBank_throwsCannotBuildEntityException() {
        
        $asserted = false;
        try {
        
            $this->builder->create()
                            ->withUuid($this->uuidMock)
                            ->withAddress($this->addressMock)
                            ->withTransitNumber($this->integerMock)
                            ->createdOn($this->dateTimeMock)
                            ->now();
            
        } catch (CannotBuildEntityException $exception) {
            $asserted = true;
        }
        
        $this->assertTrue($asserted);
        
    }
    
    public function testBuild_withoutAddress_throwsCannotBuildEntityException() {
        
        $asserted = false;
        try {
        
            $this->builder->create()
                            ->withUuid($this->uuidMock)
                            ->withBank($this->bankMock)
                            ->withTransitNumber($this->integerMock)
                            ->createdOn($this->dateTimeMock)
                            ->now();
            
        } catch (CannotBuildEntityException $exception) {
            $asserted = true;
        }
        
        $this->assertTrue($asserted);
        
    }
    
    public function testBuild_withoutTransitNumber_throwsCannotBuildEntityException() {
        
        $asserted = false;
        try {
        
            $this->builder->create()
                            ->withUuid($this->uuidMock)
                            ->withBank($this->bankMock)
                            ->withAddress($this->addressMock)
                            ->createdOn($this->dateTimeMock)
                            ->now();
            
        } catch (CannotBuildEntityException $exception) {
            $asserted = true;
        }
        
        $this->assertTrue($asserted);
        
    }
    
    public function testBuild_withLastUpdatedOn_Success() {
        
        $this->objectLoaderAdapterHelper->expects_convertClassNameElementToObjectLoader_Success($this->objectLoaderMock, $this->classNameElement);
        $this->objectLoaderHelper->expects_instantiate_Success($this->bankBranchMock, array($this->uuidMock, $this->bankMock, $this->addressMock, $this->integerMock, $this->dateTimeMock, $this->booleanAdapterMock, $this->dateTimeMock));
        $this->integerHelper->expectsGet_multiple_Success(array($this->transitNumberElement));
        
        $bankBranch = $this->builder->create()
                                ->withUuid($this->uuidMock)
                                ->withBank($this->bankMock)
                                ->withAddress($this->addressMock)
                                ->withTransitNumber($this->integerMock)
                                ->createdOn($this->dateTimeMock)
                                ->lastUpdatedOn($this->dateTimeMock)
                                ->now();
        
        $this->assertEquals($this->bankBranchMock, $bankBranch);
        
    }
    
}