<?php

namespace Creatuity\WelcomeToMachine\Controller;

/**
 * Description of Abstract
 *
 * @author m.ostrowski
 */
abstract class Base extends \Magento\Framework\App\Action\Action {
    
    /**
     * @var \Creatuity\WelcomeToMachine\Model\Example\UsageManager
     */
    protected $usageExampleManager;
    
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Creatuity\WelcomeToMachine\Model\Example\UsageManager $usageExampleManager) 
    {
        parent::__construct($context);
        
        $this->usageExampleManager = $usageExampleManager;
    }

    /**
     * @return \Creatuity\WelcomeToMachine\Model\Example\UsageInterface
     */
    protected function _getExampleUsage() {
        return $this->usageExampleManager->getCurrentUsage();
    }

    protected function _finishError($message, Exception $e) {
        //todo: logging $e
        $this->messageManager->addError($message);
        return $this->_redirect->redirect($this->_response, '*/to/machine');
    }
            
    protected function _finishSuccess($message = null) {
        if ($message) {
            $this->messageManager->addSuccess($message);
        }
        return $this->_redirect->redirect($this->_response, '*/to/machine');
    }
    
    protected function _printMessages() {
        $msgs = $this->messageManager->getMessages(true);
        foreach($msgs->getItems() as $message) {
            $this->_printHtml($message->toString() . '<br><br>');
        }
    }
    
    protected function _printHtml($html) {
        $this->_response->appendBody($html);
    }
    
    protected function _ensureParam($key) {
        $val = $this->getRequest()->getParam($key);
        if (!$val) {
            return $this->_finishError('"album_id" parameter is missing');
        }
        return $val;
    }
    
}
