<?php

namespace Creatuity\WelcomeToMachine\Controller\To;

/**
 * Description of newPHPClass
 *
 * @author m.ostrowski
 */
class SwapTracks extends \Creatuity\WelcomeToMachine\Controller\Base {
    
    public function execute() {
        try{
            $albumId = $this->_ensureParam('album_id');
            $trackNumberA = $this->_ensureParam('track_number_a');
            $trackNumberB = $this->_ensureParam('track_number_b');
            
            $this->_getExampleUsage()->swapTracksInAlbum(
                    $albumId, $trackNumberA, $trackNumberB);
            
            return $this->_finishSuccess("Tracks swaped");
        }catch(Exception $e) {
            return $this->_finishError("Cannot Swap tracks. Reason: {$e->getMessage()})", $e);
        }
    }
    
}
