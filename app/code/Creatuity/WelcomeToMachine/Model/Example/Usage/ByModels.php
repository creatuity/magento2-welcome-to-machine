<?php

namespace Creatuity\WelcomeToMachine\Model\Example\Usage;

/**
 * Description of Services
 *
 * @author m.ostrowski
 */
class ByModels implements \Creatuity\WelcomeToMachine\Model\Example\UsageInterface {
    
    /**
     * @var \Creatuity\WelcomeToMachine\Model\AlbumFactory
     */
    protected $_albumFactory;
    
    /**
     * @var \Creatuity\WelcomeToMachine\Model\TrackFactory
     */
    protected $_trackFactory;
    
    /**
     * @var \Creatuity\WelcomeToMachine\Model\Resource\Album\CollectionFactory
     */
    protected $_albumCollectionFactory;
    
    /**
     * @var \Creatuity\WelcomeToMachine\Model\Resource\Track\CollectionFactory
     */
    protected $_trackCollectionFactory;
    
    public function __construct(\Creatuity\WelcomeToMachine\Model\AlbumFactory $albumFactory, \Creatuity\WelcomeToMachine\Model\TrackFactory $trackFactory, \Creatuity\WelcomeToMachine\Model\Resource\Album\CollectionFactory $albumCollectionFactory, \Creatuity\WelcomeToMachine\Model\Resource\Track\CollectionFactory $trackCollectionFactory) {
        $this->_albumFactory = $albumFactory;
        $this->_trackFactory = $trackFactory;
        $this->_albumCollectionFactory = $albumCollectionFactory;
        $this->_trackCollectionFactory = $trackCollectionFactory;
    }

        
    public function addTrackToAlbum($albumId, array $trackData) {
        $newTrack = $this->_trackFactory->create()->setData($trackData);
        
        $this->_loadAlbum($albumId)
                ->addTrack($newTrack)
                ->save();
        
        return $newTrack;
    }
    
    public function removeTrackFromAlbum($albumId, $trackNumberInAlbum) {
        $this->_loadAlbum($albumId)
                ->removeTrackByNumber($trackNumberInAlbum)
                ->save();
    }
    
    
    public function findAlbumsEarlierThan($year) {
        return $this->_albumCollectionFactory->create()
                ->addFieldToFilter('year', array('lteq' => $year))
                ->addOrder('year', 'desc');
    }

    public function findTracksByTitle($titleLike) {
        return $this->_trackCollectionFactory->create()
            ->addFieldToFilter('title', array('like' => $titleLike))
            ->addOrder('track_number', 'asc');
    }

    public function negateYearOfTheAlbum($albumId) {
        $album = $this->_loadAlbum($albumId);
        $album->setYear( - $album->getYear() )
            ->save();
    }
    

    public function swapTracksInAlbum($albumId, $numberOfTrackA, $numberOfTrackB) {
        $this->_loadAlbum($albumId)
            ->swapTracks($numberOfTrackA, $numberOfTrackB)
            ->save();
    }

    /**
     * @return \Creatuity\WelcomeToMachine\Model\Album
     * @throws \Magento\Framework\Model\Exception
     */
    protected function _loadAlbum($albumId) {
        $album = $this->_albumFactory->create()->load($albumId);
        if ($album->isObjectNew()) {
            throw new \Magento\Framework\Model\Exception("Cannot Find Album.", array(), $exception);
        }
        return $album;
    }
}
