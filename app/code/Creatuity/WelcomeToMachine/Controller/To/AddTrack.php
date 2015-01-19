<?php

namespace Creatuity\WelcomeToMachine\Controller\To;

/**
 * Description of newPHPClass
 *
 * @author m.ostrowski
 */
class AddTrack extends \Creatuity\WelcomeToMachine\Controller\Base 
{

    public function execute() 
    {
        try{
            $albumId = $this->_ensureParam('album_id');
            $trackData = (array)$this->_ensureParam('track');

            $track = $this->_getExampleUsage()->addTrackToAlbum($albumId, $trackData);

            return $this->_finishSuccess("Succesfuly added track '{$track->getTitle()}'");
        }catch(Exception $e) {
            return $this->_finishError("Cannot add track. Reason: {$e->getMessage()})", $e);
        }
    }
    
}