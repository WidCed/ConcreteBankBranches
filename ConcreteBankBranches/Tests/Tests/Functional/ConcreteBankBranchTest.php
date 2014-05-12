<?php
namespace ConcreteBankBranches\Tests\Tests\Functional;
use ConcreteFunctionalTestHelpers\Tests\Helpers\ConcreteDependencyInjectionFunctionalTestHelper;
use ConcreteBankBranches\Tests\Helpers\StaticBankBranchHelper;

final class ConcreteBankBranchTest extends \PHPUnit_Framework_TestCase {
    
    private $objectsData;
    public function setUp() {
        
        $dependencyInjectionFunctionalTestHelper = new ConcreteDependencyInjectionFunctionalTestHelper(__DIR__.'/../../../../vendor');
        
        $jsonFilePathElement = realpath(__DIR__.'/../../../../dependencyinjection.json');
        $integerJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concreteintegers/dependencyinjection.json');
        $uuidJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concreteuuids/dependencyinjection.json');
        $bankJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretebanks/dependencyinjection.json');
        $addressJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concreteaddresses/dependencyinjection.json');
        $stringJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretestrings/dependencyinjection.json');
        $dateTimeFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretedatetimes/dependencyinjection.json');
        $booleanFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretebooleans/dependencyinjection.json');
        $americanPostalCodeJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concreteamericanpostalcodes/dependencyinjection.json');
        $neighborhoodJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concreteneighborhoods/dependencyinjection.json');
        $cityJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretecities/dependencyinjection.json');
        $regionJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concreteregions/dependencyinjection.json');
        $countryJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretecountries/dependencyinjection.json');
        $coordinateJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretecoordinates/dependencyinjection.json');
        $floatJsonFilePathElement = realpath(__DIR__.'/../../../../vendor/irestful/concretefloats/dependencyinjection.json');

        
        StaticBankBranchHelper::setUp(
                $dependencyInjectionFunctionalTestHelper,
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
        );
        
        $this->objectsData = $dependencyInjectionFunctionalTestHelper->getMultipleFileDependencyInjectionApplication()->execute($jsonFilePathElement);
        $this->objectsData['irestful.concreteobjectmetadatacompilerapplications.application']->compile();
    }
    
    public function tearDown() {
        
    }
    
    public function testConvertBankBranch_toHashMap_toBankBranch_Success() {
        
        $bankBranch = StaticBankBranchHelper::getObject();
        
        //convert the object into hashmap:
        $hashMap = $this->objectsData['irestful.concreteentities.adapter']->convertEntityToHashMap($bankBranch);
        $this->assertTrue($hashMap instanceof \HashMaps\Domain\HashMaps\HashMap);
        
        //convert hashmap back to a BankBranch object:
        $convertedBankBranch = $this->objectsData['irestful.concreteentities.adapter']->convertHashMapToEntity($hashMap);
        $this->assertEquals($bankBranch, $convertedBankBranch);
        
    }
    
}