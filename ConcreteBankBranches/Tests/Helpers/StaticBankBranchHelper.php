<?php
namespace ConcreteBankBranches\Tests\Helpers;
use ConcreteFunctionalTestHelpers\Tests\Helpers\ConcreteDependencyInjectionFunctionalTestHelper;
use ConcreteBanks\Tests\Helpers\StaticBankHelper;
use ConcreteAddresses\Tests\Helpers\StaticAddressHelper;

final class StaticBankBranchHelper {
    
    private static $objectsData;
    private static $uuidObjectsData;
    private static $integerObjectsData;
    private static $dateTimeObjectsData;
    private static $booleanObjectsData;
    private static $object = null;
    
    public static function isSetUp() {
        return !empty(self::$object);
    }
    
    public static function setUp(
        ConcreteDependencyInjectionFunctionalTestHelper $depdendencyInjectionFunctionalTestHelper,
        $jsonFilePathElement,
        $floatJsonFilePathElement,
        $stringJsonFilePathElement,
        $americanPostalCodeJsonFilePathElement,
        $neighborhoodJsonFilePathElement,
        $cityJsonFilePathElement,
        $regionJsonFilePathElement,
        $countryJsonFilePathElement,
        $coordinateJsonFilePathElement,
        $uuidJsonFilePathElement,
        $integerJsonFilePathElement,
        $bankJsonFilePathElement,
        $addressJsonFilePathElement,
        $dateTimeFilePathElement,
        $booleanFilePathElement
    ) {
        
        if (self::isSetUp()) {
            return;
        }
        
        StaticBankHelper::setUp($depdendencyInjectionFunctionalTestHelper, $bankJsonFilePathElement, $uuidJsonFilePathElement, $stringJsonFilePathElement, $dateTimeFilePathElement, $booleanFilePathElement);
        StaticAddressHelper::setUp($depdendencyInjectionFunctionalTestHelper, $addressJsonFilePathElement, $uuidJsonFilePathElement,  $stringJsonFilePathElement, $floatJsonFilePathElement, $dateTimeFilePathElement, $americanPostalCodeJsonFilePathElement, $neighborhoodJsonFilePathElement, $cityJsonFilePathElement,
        $regionJsonFilePathElement,
        $countryJsonFilePathElement,
        $coordinateJsonFilePathElement,
        $booleanFilePathElement);
        
        self::$objectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($jsonFilePathElement);
        self::$uuidObjectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($uuidJsonFilePathElement);
        self::$integerObjectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($integerJsonFilePathElement);
        self::$dateTimeObjectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($dateTimeFilePathElement);
        self::$booleanObjectsData = $depdendencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($booleanFilePathElement);
        
        self::$object = self::build();
    }
    
    public static function getObject() {
        return self::$object;
    }
    
    public static function getObjectWithSubObjects() {
        $objectsData = StaticBankHelper::getObjectWithSubObjects();
        $objectsData2 = StaticAddressHelper::getObjectWithSubObjects();
        return array_merge(array(self::$object), $objectsData, $objectsData2);
    }
    
    private static function build() {
        
        $uuidElement = 'ca3497a0-b00b-11e3-a5e2-0800200c9a66';
        $transitNumberElement = "12354";
        $createdOnTimestampElement = time() - (24 * 60 * 60);
        $lastUpdatedOnTimestampElement = time();
        
        $bank = StaticBankHelper::getObject();
        $address = StaticAddressHelper::getObject();
        
        $uuid = self::$uuidObjectsData['adapter']->convertElementToUuid($uuidElement);
        $transitNumber = self::$integerObjectsData['adapter']->convertElementToPrimitive($transitNumberElement);
        $createdOn = self::$dateTimeObjectsData['adapter']->convertTimestampElementToDateTime($createdOnTimestampElement);
        $lastUpdatedOn = self::$dateTimeObjectsData['adapter']->convertTimestampElementToDateTime($lastUpdatedOnTimestampElement);
        
        return self::$objectsData['builderfactory']->create()
                                                    ->create()
                                                    ->withUuid($uuid)
                                                    ->withBank($bank)
                                                    ->withAddress($address)
                                                    ->withTransitNumber($transitNumber)
                                                    ->createdOn($createdOn)
                                                    ->lastUpdatedOn($lastUpdatedOn)
                                                    ->now();
    }
    
}