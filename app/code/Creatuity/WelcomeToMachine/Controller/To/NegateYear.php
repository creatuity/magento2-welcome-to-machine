<?php

namespace Creatuity\WelcomeToMachine\Controller\To;

/**
 * Description of newPHPClass
 *
 * @author m.ostrowski
 */
class NegateYear extends \Creatuity\WelcomeToMachine\Controller\Base {
    
    public function execute() {
        try{
            $albumId = $this->_ensureParam('album_id');
            
            $this->_getExampleUsage()->negateYearOfTheAlbum($albumId);
            
            return $this->_finishSuccess("Silly operation of year negation succedded");
        }catch(Exception $e) {
            return $this->_finishError("Cannot Find Album. Reason: {$e->getMessage()})", $e);
        }
    }
            
}
