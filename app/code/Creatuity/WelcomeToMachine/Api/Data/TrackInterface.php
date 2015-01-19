<?php

namespace Creatuity\WelcomeToMachine\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Description of AlbumInterface
 *
 * @author m.ostrowski
 */
interface TrackInterface extends ExtensibleDataInterface {
    
    const TRACK_ID = 'track_id';
    const TITLE = 'title';
    const TRACK_NUMBER = 'track_number';
    
    /**
     * @return int
     */
    public function getTrackId();
    
    /**
     * @return string
     */
    public function getTitle();
    
    /**
     * @return int
     */
    public function getTrackNumber();
    
}
