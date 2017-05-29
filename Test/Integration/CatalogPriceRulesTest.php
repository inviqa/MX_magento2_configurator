<?php

namespace CtiDigital\Configurator\Model\Component;

use Magento\Authorization\Model\Role;
use Magento\TestFramework\Helper\Bootstrap;
use Symfony\Component\Yaml\Parser;
use Magento\CatalogRule\Model\ResourceModel\RuleFactory;
use Magento\CatalogRule\Api\CatalogRuleRepositoryInterface;

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
    private $catalogueRuleResourceModel;

    /**
     * @var CatalogRuleRepository
     */
    private $catalogueRuleRepository;

    public function setUp()
    {
        $this->testCatalogPriceRulesYamlPath = sprintf("%s/../../Samples/Components/CatalogPriceRules/catalogpricerules.yaml", __DIR__);
        $this->catalogPriceRulesComponent = Bootstrap::getObjectManager()
            ->get('CtiDigital\Configurator\Model\Component\CatalogPriceRules');

        $this->catalogueRuleRepository = Bootstrap::getObjectManager()
            ->get('Magento\CatalogRule\Api\CatalogRuleRepositoryInterface');

        $this->catalogueRuleResourceModel = Bootstrap::getObjectManager()
            ->get('\Magento\CatalogRule\Model\ResourceModel\Rule');

        //fwrite(STDERR, var_dump(gettype($this->rulesResourceModel)), true);
        //fwrite(STDERR, var_dump($this->rulesResourceModel->getMainTable()), true);


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

        // and some sample products

        // and some customer groups

        // when we run the AdminRoles component
        $this->catalogPriceRulesComponent->processData($testCatalogPriceRules);

        // then it should enter new catalog price rules into the database
        fwrite(STDERR, var_export(get_class_methods($this->catalogueRuleResourceModel->getMainTable()), true));

        fwrite(STDERR, var_export($this->catalogueRuleResourceModel->getRulesFromProduct(
            now(),
            $websiteId,
            $customerGroupId,
            $productId
        )));
    }

}
