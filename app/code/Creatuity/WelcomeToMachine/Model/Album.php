<?php

namespace Creatuity\WelcomeToMachine\Model;

/**
 * Description of Album
 *
 * 
 * @author m.ostrowski
 */
class Album extends \Magento\Framework\Model\AbstractExtensibleModel 
    implements \Creatuity\WelcomeToMachine\Api\Data\AlbumInterface 
{
    
    protected $_eventObject = 'album';
    
    /**
     * @var \Creatuity\WelcomeToMachine\Model\Resource\Track\CollectionFactory
     */
    protected $_tracksCollectionFactory;
    
    public function __construct(
        \Creatuity\WelcomeToMachine\Model\Resource\Track\CollectionFactory $tracksCollectionFactory,
        \Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Api\MetadataServiceInterface $metadataService, \Magento\Framework\Api\AttributeDataBuilder $customAttributeBuilder, \Creatuity\WelcomeToMachine\Model\Resource\Track\Collection $trackCollection, \Magento\Framework\Model\Resource\AbstractResource $resource = null, \Magento\Framework\Data\Collection\Db $resourceCollection = null, array $data = array()) 
    {
        parent::__construct($context, $registry, $metadataService, $customAttributeBuilder, $resource, $resourceCollection, $data);
        
        $this->_init('\Creatuity\WelcomeToMachine\Model\Resource\Album');
        
        $this->_tracksCollectionFactory = $tracksCollectionFactory;
    }
    
    public function getAlbumId() 
    {
        return $this->getId();
    }
    
    public function getArtist() 
    {
        return "Pink Floyd";
    }
    
    /**
     * @return int
     */
    public function getYear() 
    {
        return $this->_getData(self::YEAR);
    }

    /**
     * @return string
     */
    public function getTitle() 
    {
        return $this->_getData(self::TITLE);
    }
    
    public function addTrack(\Creatuity\WelcomeToMachine\Model\Track $track) 
    {
        $track->setAlbum($this)
            ->setTrackNumber($this->getNumberOfTracks() + 1);
        
        $this->setTracks(array_merge($this->getTracks(), [$track]));
        $this->getResource()->normalizeTrackNumbers($this);
        return $this;
    }
    
    public function removeTrackByNumber($trackNumber) {
        $track = $this->getTrackByNumber($trackNumber);
        $this->removeTrack($track);
        return $this;
    }
    
    /**
     * @return \Creatuity\WelcomeToMachine\Model\Track
     */
    public function getTrackByNumber($trackNumber) 
    {
        foreach($this->getTracks() as $track) {
            if ($track->getTrackNumber() == $trackNumber) {
                return $track;
            }
        }
        throw new \Magento\Framework\Model\Exception("Invalid track number");
    }
    
    public function removeTrack(\Creatuity\WelcomeToMachine\Model\Track $track) 
    {
        if ($track->getAlbumId() != $this->getId()) {
            throw new \Magento\Framework\Model\Exception("Track doesn't belong to album");
        }
        
        $trackWithoutDeleted = [];
        foreach($this->getTracks() as $tr) {
            if ($tr->getTrackId() != $track->getTrackId()) {
                $trackWithoutDeleted[] = $tr;
            }
        }
        
        $this->setTracks($trackWithoutDeleted);
        $this->getResource()->normalizeTrackNumbers($this);
        return $this;
    }
    
    /**
     * @param \Creatuity\WelcomeToMachine\Api\Data\TrackInterface[]
     */
    public function setTracks($tracks) 
    {
        if (is_array($tracks)) {
            $this->setData(self::TRACKS, $tracks);
        } else {
            $this->setData(self::TRACKS, iterator_to_array($tracks));
        }
        return $this;
    }
    
    /**
     * @return \Creatuity\WelcomeToMachine\Api\Data\TrackInterface[]
     */
    public function getTracks() 
    {
        $tracks = $this->_getData(self::TRACKS);
        if (null === $tracks) {
            $this->setData(self::TRACKS,  iterator_to_array($this->getTracksCollection()) );
        }elseif(!is_array($tracks)) {
            $this->setData(self::TRACKS,  iterator_to_array($this->_getData(self::TRACKS)));
        }
        return $this->_getData(self::TRACKS);
    }
    
    public function swapTracks($trackNumberA, $trackNumberB) {
        $trackA = $this->getTrackByNumber($trackNumberA);
        $trackB = $this->getTrackByNumber($trackNumberB);
        
        $newOrderOfTracks = [];
        foreach($this->getTracks() as $track) {
            if ($track === $trackA) {
                $newOrderOfTracks[]= $trackB;
            }elseif ($track === $trackB) {
                $newOrderOfTracks[]= $trackA;
            }else{
                $newOrderOfTracks[]= $track;
            }
        }
        $this->setTracks($newOrderOfTracks);
        return $this;
    }
    
    /**
     * @param \Creatuity\WelcomeToMachine\Model\Resource\Track\Collection
     */
    public function getTracksCollection() {
        return $this->_tracksCollectionFactory->create()
            ->setAlbumFilter($this)
            ->sortByTrackNumber();
    }
    
    /**
     * @return int
     */
    public function getNumberOfTracks() 
    {
        return count($this->getTracks());
    }


}
