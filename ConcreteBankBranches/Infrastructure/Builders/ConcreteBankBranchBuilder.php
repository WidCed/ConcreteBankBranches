<?php
namespace ConcreteBankBranches\Infrastructure\Builders;
use ConcreteEntities\Infrastructure\Builders\AbstractEntityBuilder;
use BankBranches\Domain\BankBranches\Builders\BankBranchBuilder;
use Booleans\Domain\Booleans\Adapters\BooleanAdapter;
use ObjectLoaders\Domain\ObjectLoaders\Adapters\ObjectLoaderAdapter;
use Integers\Domain\Integers\Integer;
use Banks\Domain\Banks\Bank;
use Addresses\Domain\Addresses\Address;
use Entities\Domain\Entities\Builders\Exceptions\CannotBuildEntityException;

final class ConcreteBankBranchBuilder extends AbstractEntityBuilder implements BankBranchBuilder {
    
    private $bank;
    private $address;
    private $transitNumber;
    public function __construct(BooleanAdapter $booleanAdapter, ObjectLoaderAdapter $objectLoaderAdapter) {
        parent::__construct($booleanAdapter, $objectLoaderAdapter, 'ConcreteBankBranches\Infrastructure\Objects\ConcreteBankBranch');
    }
    
    public function create() {
        parent::create();
        $this->bank = null;
        $this->address = null;
        $this->transitNumber = null;
        return $this;
    }
    
    public function withBank(Bank $bank) {
        $this->bank = $bank;
        return $this;
    }
    
    public function withAddress(Address $address) {
        $this->address = $address;
        return $this;
    }
    
    public function withTransitNumber(Integer $transitNumber) {
        $this->transitNumber = $transitNumber;
        return $this;
    }
    
    protected function getParamsData() {
        
        $paramsData = array($this->uuid, $this->bank, $this->address, $this->transitNumber, $this->createdOn, $this->booleanAdapter);
        
        if (!empty($this->lastUpdatedOn)) {
            $paramsData[] = $this->lastUpdatedOn;
        }
        
        return $paramsData;
    }
    
    public function now() {
        
        if (empty($this->bank)) {
            throw new CannotBuildEntityException('The bank is mandatory in order to build a BankBranch object.');
        }
        
        if (empty($this->address)) {
            throw new CannotBuildEntityException('The address is mandatory in order to build a BankBranch object.');
        }
        
        if (empty($this->transitNumber)) {
            throw new CannotBuildEntityException('The transitNumber is mandatory in order to build a BankBranch object.');
        }
        
        return parent::now();
        
    }
}
