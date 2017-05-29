<?php
namespace CtiDigital\Configurator\Model\Component;

use Magento\CatalogRule\Api\CatalogRuleRepositoryInterface;
use Symfony\Component\Yaml\Yaml;
use Magento\Framework\ObjectManagerInterface;
use CtiDigital\Configurator\Model\LoggingInterface;
use Magento\Authorization\Model\UserContextInterface;
use Magento\CatalogRule\Model\ResourceModel\RuleFactory;
use Magento\CatalogRule\Model\Rule;

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
     * @var CatalogRuleRepositoryInterface
     */

    protected $catalogRuleRepository;

    /**
     * AdminRoles constructor.
     * @param LoggingInterface $log
     * @param ObjectManagerInterface $objectManager
     * @param CatalogRuleRepositoryInterface $catalogRuleRepository
     */
    public function __construct(
        LoggingInterface $log,
        ObjectManagerInterface $objectManager,
        CatalogRuleRepositoryInterface $catalogRuleRepository
    ) {
        parent::__construct($log, $objectManager);
        $this->catalogRuleRepository = $catalogRuleRepository;
    }


    /**
     * This method should be used to process the data and populate the Magento Database.
     *
     * @param array $data
     * @return void
     */
    public function processData(array $data = null)
    {
        foreach ($data as $website => $catalogRules)
        {
            $this->insertCatalogRulesIntoWebsite($website, $catalogRules);
        }
    }

    private function insertCatalogRulesIntoWebsite($website, array $catalogRules)
    {
        fwrite(STDERR, $website);
        fwrite(STDERR, var_export($catalogRules, true));

        foreach($catalogRules as $catalogRule) {

            /** @var \Magento\CatalogRule\Model\Rule $model */
            $ruleModel = $this->objectManager->create('Magento\CatalogRule\Model\Rule');
            $ruleModel->setName($catalogRule['name']);
            $this->catalogRuleRepository->save($ruleModel);
        }
    }
}
