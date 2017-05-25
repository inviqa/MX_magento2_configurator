<?php

namespace CtiDigital\Configurator\Model\Component;

use Magento\Authorization\Model\Role;
use Magento\TestFramework\Helper\Bootstrap;
use Symfony\Component\Yaml\Parser;
use Magento\CatalogRule\Model\ResourceModel\RuleFactory;

class CatalogPriceRulesTest extends \PHPUnit_Framework_TestCase
{
    const ROLE_NAME_KEY = "role_name";
    const TAX_MANAGER_TEST_ROLE_NAME = "Tax Manager";
    const ROLE_ID_KEY = "role_id";
    const ROLE_NAMES_DIFFERENT_MESSAGE = "Actual role name was different from expected role name";
    const RESOURCES_DIFFERENT_MESSAGE = "Actual resources were different to expected resources";
    const SALES_USERS_TEST_ROLE_NAME = "Sales Users";

    private $testCatalogPriceRulesYamlPath;

    /**
     * CatalogPriceRules is the class under test
     *
     * @var CatalogPriceRules
     */
    private $catalogPriceRulesComponent;

    /**
     * Rules resource model
     *
     * @var
     */
    private $rulesResourceModel;

    public function setUp()
    {
        $this->testCatalogPriceRulesYamlPath = sprintf("%s/../../Samples/Components/CatalogPriceRules/catalogpricerules.yaml", __DIR__);
        $this->catalogPriceRulesComponent = Bootstrap::getObjectManager()
            ->get('CtiDigital\Configurator\Model\Component\CatalogPriceRules');

        $ruleFactory = Bootstrap::getObjectManager()
            ->get('Magento\CatalogRule\Model\ResourceModel\RuleFactory');

        /** @var \Magento\CatalogRule\Model\Rule $rule */
        $this->rulesResourceModel = $ruleFactory->create();


        /**
            $this->ruleResourceMock = $this->getMock('Magento\CatalogRule\Model\ResourceModel\Rule', [], [], '', false);
            $this->ruleFactoryMock = $this->getMock('Magento\CatalogRule\Model\RuleFactory', ['create'], [], '', false);
            $this->ruleMock = $this->getMock('Magento\CatalogRule\Model\Rule', [], [], '', false);
            $this->repository = new \Magento\CatalogRule\Model\CatalogRuleRepository(
            $this->ruleResourceMock,
            $this->ruleFactoryMock
            );
         */
    }

    public function testShouldCreateNewCatalogPriceRulesFromYamlFile()
    {
        // given a yaml file containing AdminRoles
        $yamlParser = new Parser();
        $testCatalogPriceRules = $yamlParser->parse(file_get_contents($this->testCatalogPriceRulesYamlPath), true);

        // when we run the AdminRoles component
        $this->catalogPriceRulesComponent->processData($testCatalogPriceRules);

        // then it should enter new catalog price rules into the database
    }

}
