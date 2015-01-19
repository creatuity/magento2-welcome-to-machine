<?php

namespace Creatuity\WelcomeToMachine\Model;

/**
 * Description of Track
 *
 * @method setTitle($title)
 * @method setTrackNumber($trackNumber)
 * @method setAlbumId($albumId)
 * @author m.ostrowski
 */
class Track extends \Magento\Framework\Model\AbstractExtensibleModel 
    implements \Creatuity\WelcomeToMachine\Api\Data\TrackInterface 
{
    const ALBUM = 'album';
    
    protected $_eventObject = 'track';
    
    /**
     * @var \Creatuity\WelcomeToMachine\Model\AlbumFactory
     */
    protected $albumFactory;
    
    public function __construct(
        \Creatuity\WelcomeToMachine\Model\AlbumFactory $albumFactory,
        \Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Api\MetadataServiceInterface $metadataService, \Magento\Framework\Api\AttributeDataBuilder $customAttributeBuilder, \Magento\Framework\Model\Resource\AbstractResource $resource = null, \Magento\Framework\Data\Collection\Db $resourceCollection = null, array $data = array()) 
    {
        parent::__construct($context, $registry, $metadataService, $customAttributeBuilder, $resource, $resourceCollection, $data);
        
        $this->albumFactory = $albumFactory;
        
        $this->_init('\Creatuity\WelcomeToMachine\Model\Resource\Track');
    }
    
    public function getTrackId() {
        return $this->getId();
    }

    /**
     * @return int
     */
    public function getTitle() {
        return $this->_getData(self::TITLE);
    }
    
    /**
     * @return int
     */
    public function getTrackNumber() {
        return $this->_getData(self::TRACK_NUMBER);
    }
        
    /**
     * @return int
     */
    public function getAlbumId() {
        return parent::getAlbumId();
    }
    
    public function setAlbum(\Creatuity\WelcomeToMachine\Model\Album $album) {
        $this->setData(self::ALBUM, $album);
        $this->setAlbumId($album->getId());
        return $this;
    }
    
    /**
     * @return \Creatuity\WelcomeToMachine\Api\Data\AlbumInterface
     */
    public function getAlbum() {
        if (!$this->_getData(self::ALBUM) && $this->getAlbumId()) {
            $album = $this->albumFactory->create()->load($this->getAlbumId());
            if (!$album->getId()) {
                throw new \Magento\Framework\Model\Exception("Cannot load album id='{$this->getAlbumId()}'");
            }
            $this->setData(self::ALBUM, $album);
        }
        return $this->_getData(self::ALBUM);
    }
    
    
    
}
