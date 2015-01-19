<?php

namespace Creatuity\WelcomeToMachine\Controller\Example;

/**
 * Description of newPHPClass
 *
 * @author m.ostrowski
 */
class UsageSwitch extends \Creatuity\WelcomeToMachine\Controller\Base {
    
    
    public function execute() {
        try{
            $key = $this->_ensureParam('usage_key');
            $this->usageExampleManager->setCurrentType($key);
            return $this->_finishSuccess(
                "Current Example Usage Implementation has been changed to: '{$this->usageExampleManager->getCurrentTitle()}' ");
        }catch(Exception $e) {
            return $this->_finishError("Cannot switch impl", $e);
        }
    }
    
}
