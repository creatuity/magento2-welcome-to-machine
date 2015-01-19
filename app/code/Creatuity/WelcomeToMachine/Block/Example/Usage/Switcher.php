<?php

namespace Creatuity\WelcomeToMachine\Block\Example\Usage;

/**
 * @author m.ostrowski
 */
class Switcher extends \Magento\Framework\View\Element\Template 
{
    
    /**
     * @var string
     */
    protected $_template = 'example_switcher.phtml';
    
    /**
     * @var \Creatuity\WelcomeToMachine\Model\Example\UsageManager
     */
    protected $usageExampleManager;
    
    public function __construct(
        \Creatuity\WelcomeToMachine\Model\Example\UsageManager $usageExampleManager,
        \Magento\Framework\View\Element\Template\Context $context, array $data = array()) 
    {
        parent::__construct($context, $data);
        $this->usageExampleManager = $usageExampleManager;
    }
    
    public function getSwitchers() {
        return $this->usageExampleManager->getAllPossibleUsageKeys();
    }
    
    public function isCurrent($key) {
        return $this->usageExampleManager->getCurrentUsageKey() == $key;
    }
    
    public function getTitle($key) {
        return $this->usageExampleManager->getTitle($key);
    }
    
    public function getSwitchUrl($key) {
        if ($this->isCurrent($key)) {
            return '#';
        }
        
        return $this->_urlBuilder->getUrl('*/example/usageSwitch', array(
            'usage_key' => $key,
        ));
    }
    
}