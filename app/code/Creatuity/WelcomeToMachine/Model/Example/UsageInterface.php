<?php

namespace Creatuity\WelcomeToMachine\Model\Example;

/**
 * Description of Interface
 *
 * @author m.ostrowski
 */
interface UsageInterface {
    
    /**
    /**
     * @return \Creatuity\WelcomeToMachine\Api\Data\AlbumInterface[]
     */
    public function findAlbumsEarlierThan($year);
    
    /**
     * @param string $titleLike
     * @return \Creatuity\WelcomeToMachine\Api\Data\TrackInterface[]
     */
    public function findTracksByTitle($titleLike);
    
    /**
     * @param int $albumId
     * @param array $trackData
     * @return \Creatuity\WelcomeToMachine\Api\Data\TrackInterface
     */
    public function addTrackToAlbum($albumId, array $trackData);
    
    /**
     * @param int $albumId
     * @param int $trackNumberInAlbum
     */
    public function removeTrackFromAlbum($albumId, $trackNumberInAlbum);
    
    /**
     * @param int $albumId
     */
    public function negateYearOfTheAlbum($albumId);
    
    /**
     * @param int $albumId
     * @param int $numberOfTrackA
     * @param int $numberOfTrackB
     */
    public function swapTracksInAlbum($albumId, $numberOfTrackA, $numberOfTrackB);
    
}
