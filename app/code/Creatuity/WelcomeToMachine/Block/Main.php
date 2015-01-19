<?php

namespace Creatuity\WelcomeToMachine\Block;

/**
 * Description of Main
 *
 * @author m.ostrowski
 */
class Main extends \Magento\Framework\View\Element\Template 
{
    
    /**
     * @var string
     */
    protected $_template = 'main.phtml';
    
    /**
     * @var \Creatuity\WelcomeToMachine\Model\Example\UsageManager
     */
    protected $usageExampleManager;
    
    public function __construct(
        \Creatuity\WelcomeToMachine\Model\Example\UsageManager $usageExampleManager,
        \Magento\Framework\View\Element\Template\Context $context, array $data = array()) 
    {
        parent::__construct($context, $data);
        $this->usageExampleManager = $usageExampleManager;
        $this->setYear($this->getRequest()->getParam('year', 2015));
    }
    
    public function getAlbums() {
        if (!$this->hasAlbums()) {
            $year = $this->getYear();
            $albums = $this->usageExampleManager->getCurrentUsage()->findAlbumsEarlierThan($year);
            $this->setAlbums($albums);
        }
        
        return parent::getAlbums();
    }
    
    public function hasAlbumsFound() { 
        foreach($this->getAlbums() as $album){
            return true;
        }
        return false;
    }
    
    public function _negateYearUrl(\Creatuity\WelcomeToMachine\Api\Data\AlbumInterface $album) {
        return $this->_urlBuilder->getUrl('*/*/negateYear', array(
            'album_id' => $album->getId()
        ));
    }
    
    public function _swapTracksUrl(\Creatuity\WelcomeToMachine\Api\Data\AlbumInterface $album) {
        return $this->_urlBuilder->getUrl('*/*/swapTracks', array(
            'album_id' => $album->getId(),
            'track_number_a' => 1,
            'track_number_b' => $album->getNumberOfTracks(),
        ));
    } 
    
    public function _prevYearUrl() {
        return $this->_urlBuilder->getUrl('*/*/*', ['year' => $this->getYear() - 1]);
    }
    
    public function _nextYearUrl() {
        return $this->_urlBuilder->getUrl('*/*/*', ['year' => $this->getYear() + 1]);
    }

    public function _deleteAlbumTrackUrl($album, $trackNumber) {
        return $this->_urlBuilder->getUrl('*/*/deleteTrack', array(
            'album_id' => $album->getId(),
            'track_number' => $trackNumber,
        ));
    }
    
    public function _addTrackUrl($album) {
        return $this->_urlBuilder->getUrl('*/*/addTrack', array(
            'album_id' => $album->getId(),
        ));
    }
    
    
}
