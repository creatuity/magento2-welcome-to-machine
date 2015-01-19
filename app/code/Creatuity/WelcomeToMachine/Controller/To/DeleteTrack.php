<?php

namespace Creatuity\WelcomeToMachine\Controller\To;

/**
 * Description of newPHPClass
 *
 * @author m.ostrowski
 */
class DeleteTrack extends \Creatuity\WelcomeToMachine\Controller\Base {
    
    public function execute() {
        try{
            $albumId = $this->_ensureParam('album_id');
            $trackNumber = $this->_ensureParam('track_number');
            
            $this->_getExampleUsage()->removeTrackFromAlbum($albumId, $trackNumber);
            
            return $this->_finishSuccess("Track deleted");
        } catch(Exception $e) {
            return $this->_finishError("Cannot Delete tracks. Reason: {$e->getMessage()})", $e);
        }
    }
    
}
