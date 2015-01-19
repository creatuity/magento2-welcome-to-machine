<?php

namespace Creatuity\WelcomeToMachine\Model\Example;

use Magento\Framework\Api\ObjectFactory;

/**
 * Description of UsageFactory
 *
 * @author m.ostrowski
 */
class UsageManager { 
    
    const MODELS = 'models';
    const SERVICES = 'services';
    
    protected $usageTypes = [
        self::MODELS => [
            'title' => 'Magento1 way: Models',
            'class' => '\Creatuity\WelcomeToMachine\Model\Example\Usage\ByModels'
        ]
        ,
        self::SERVICES => [
            'title' => 'Magento2 way: Service Interfaces',
            'class' => '\Creatuity\WelcomeToMachine\Model\Example\Usage\ByServices'
        ]
    ];
    
    
    /**
     * @var ObjectFactory
     */
    protected $objectFactory;

    /**
     * Session
     *
     * @var \Magento\Framework\Session\SessionManagerInterface
     */
    protected $_session;
    
    /**
     * @var string
     */
    protected $currentType;
    
    /**
     * @var UsageInterface
     */
    protected $currentUsage;

    
    public function __construct(ObjectFactory $objectFactory, \Magento\Framework\Session\SessionManagerInterface $session) {
        $this->objectFactory = $objectFactory;
        $this->_session = $session;
    }

    
    /**
     * @return UsageInterface
     */
    public function getCurrentUsage() {
        $this->_initCurrent();
        return $this->currentUsage;
    }
    
    public function setCurrentType($key) {
        $this->_ensureCorrectUsage($key);
        
        $this->_currentUsage = $this->createUsage($key);
        $this->currentType = $key;
        
        $this->_session->setData('usage_type', $key);
    }
    
    protected function _initCurrent() {
        if ($this->currentUsage) {
            return $this->currentUsage;
        }
        
        $typeFromSession = $this->_session->getData('usage_type');
        if ($typeFromSession) {
            $this->currentType = $typeFromSession;
            $this->currentUsage = $this->createUsage($typeFromSession);
        } else {
            $this->currentUsage = $this->objectFactory->create(
                    '\Creatuity\WelcomeToMachine\Model\Example\UsageInterface', []);
            
            $this->currentType = null;
            foreach($this->usageTypes as $type => $info) {
                if ($this->currentUsage instanceof $info['class']) {
                    $this->currentType = $type;
                    break;
                }
            }
        }
    }
    
    
    /**
     * @return UsageInterface
     */
    public function createUsage($usageKey, array $args = []) {
        $this->_ensureCorrectUsage($usageKey);
        
        return $this->objectFactory->create($this->usageTypes[$usageKey]['class'], $args);
    }
    
    public function getTitle($usageKey) {
        return $this->usageTypes[$usageKey]['title'];
    }
    
    public function getCurrentUsageKey() {
        $this->_initCurrent();
        
        return $this->currentType;
    }
    
    public function getCurrentTitle() {
        $this->_initCurrent();
        
        return $this->getTitle($this->currentType);
    }
    
    public function getAllPossibleUsageKeys() {
        return array_keys($this->usageTypes);
    }
    
    protected function _ensureCorrectUsage($key) {
        if (!isset($this->usageTypes[$key])) {
            throw new \Magento\Framework\Model\Exception('Unknown type');
        }
    }
    
    
    
}
