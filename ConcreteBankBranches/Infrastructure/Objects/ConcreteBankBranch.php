<?php
namespace ConcreteBankBranches\Infrastructure\Objects;
use ConcreteEntities\Infrastructure\Objects\AbstractEntity;
use BankBranches\Domain\BankBranches\BankBranch;
use Addresses\Domain\Addresses\Address;
use Banks\Domain\Banks\Bank;
use Integers\Domain\Integers\Integer;
use Uuids\Domain\Uuids\Uuid;
use DateTimes\Domain\DateTimes\DateTime;
use Booleans\Domain\Booleans\Adapters\BooleanAdapter;
use Entities\Domain\Entities\Exceptions\CannotCreateEntityException;
use ConcreteClassAnnotationObjects\Infrastructure\Objects\ConcreteContainer;
use ConcreteMethodAnnotationObjects\Infrastructure\Objects\ConcreteKeyname;
use ConcreteMethodAnnotationObjects\Infrastructure\Objects\ConcreteTransform;

/**
 * @ConcreteContainer("bankbranch") 
 */
final class ConcreteBankBranch extends AbstractEntity implements BankBranch {
    
    private $bank;
    private $address;
    private $transitNumber;
    public function __construct(Uuid $uuid, Bank $bank, Address $address, Integer $transitNumber, DateTime $createdOn, BooleanAdapter $booleanAdapter, DateTime $lastUpdatedOn = null) {
        
        if ($transitNumber->get() == '') {
            throw new CannotCreateEntityException('The transitNumber must be a non-empty Integer object.');
        }
        
        parent::__construct($uuid, $createdOn, $booleanAdapter, $lastUpdatedOn);
        $this->bank = $bank;
        $this->address = $address;
        $this->transitNumber = $transitNumber;
        
    }
    
    /**
     * @ConcreteKeyname(name="bank", argument="bank")
     **/
    public function getBank() {
        return $this->bank;
    }
    
    /**
     * @ConcreteKeyname(name="address", argument="address")
     **/
    public function getAddress() {
        return $this->address;
    }
    
    /**
     * @ConcreteKeyname(name="transit_number", argument="transitNumber")
     * @ConcreteTransform(reference="irestful.concreteintegers.adapter", method="convertElementToPrimitive")
     **/
    public function getTransitNumber() {
        return $this->transitNumber;
    }
}