<?php

namespace Creatuity\WelcomeToMachine\Model\Resource;


/**
 * 
 * @author m.ostrowski
 */
class Track extends \Magento\Framework\Model\Resource\Db\AbstractDb 
    implements \Creatuity\WelcomeToMachine\Model\Spi\TrackResourceInterface
{
    
    protected $_eventObject = 'track';
    
    protected function _construct() {
        $this->_init('welcome_tracks', 'track_id');
    }
    
}
