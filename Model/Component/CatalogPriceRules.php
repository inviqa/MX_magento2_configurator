<?php
namespace CtiDigital\Configurator\Model\Component;

use Symfony\Component\Yaml\Yaml;
use Magento\Framework\ObjectManagerInterface;
use CtiDigital\Configurator\Model\LoggingInterface;
use Magento\Authorization\Model\UserContextInterface;
use Magento\CatalogRule\Model\ResourceModel\RuleFactory;

class CatalogPriceRules extends YamlComponentAbstract
{
    protected $alias = "catalogpricerules";
    protected $name = "Catalog Price Rules";
    protected $description = "Component to create catalog price rules";

    /**
     * @var RuleFactory
     */
    protected $ruleFactory;

    /**
     * AdminRoles constructor.
     * @param LoggingInterface $log
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(
        LoggingInterface $log,
        ObjectManagerInterface $objectManager,
        RuleFactory $ruleFactory
    ) {
        parent::__construct($log, $objectManager);
        $this->ruleFactory = $ruleFactory;
    }


    /**
     * This method should be used to process the data and populate the Magento Database.
     *
     * @param array $data
     * @return void
     */
    public function processData(array $data = null)
    {
        /** @var RuleModel */
        $ruleModel = $this->ruleFactory->create();
    }

}
