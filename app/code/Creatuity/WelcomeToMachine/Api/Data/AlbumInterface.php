<?php

namespace Creatuity\WelcomeToMachine\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/** 
 * Description of AlbumInterface
 *
 * @author m.ostrowski   
 */
interface AlbumInterface extends ExtensibleDataInterface {
    
    const ALBUM_ID = 'album_id';
    const YEAR = 'year';
    const TITLE = 'title';
    const TRACKS = 'tracks';
    const ARTIST = 'artist';
    const NUMBER_OF_TRACKS = 'number_of_tracks';

    /**
     * @return int
     */
    public function getAlbumId();
    
    /**
     * @return int
     */
    public function getYear();
    
    /**
     * @return string
     */
    public function getTitle();
    
    /**
     * @return string
     */
    public function getArtist();
    
    /**
     * @return int
     */
    public function getNumberOfTracks();
    
    /**
     * @return \Creatuity\WelcomeToMachine\Api\Data\TrackInterface[]
     */
    public function getTracks();
        
}
