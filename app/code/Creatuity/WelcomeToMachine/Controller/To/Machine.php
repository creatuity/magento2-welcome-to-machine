<?php

namespace Creatuity\WelcomeToMachine\Controller\To;

/**
 * Description of newPHPClass
 *
 * @author m.ostrowski
 */
class Machine extends \Creatuity\WelcomeToMachine\Controller\Base {
    
    public function execute() 
    {
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
    
}
