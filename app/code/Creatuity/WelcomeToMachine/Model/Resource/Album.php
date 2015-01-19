<?php

namespace Creatuity\WelcomeToMachine\Model\Resource;


/**
 * Description of Album
 *
 * @author m.ostrowski
 */
class Album extends \Magento\Framework\Model\Resource\Db\AbstractDb 
    implements \Creatuity\WelcomeToMachine\Model\Spi\AlbumResourceInterface
{
    
    protected $_eventObject = 'album';
    
    protected function _construct() {
        $this->_init('welcome_albums', 'album_id');
    }
    
    protected function _afterLoad(\Magento\Framework\Model\AbstractModel $object) {
        parent::_afterLoad($object);
        
        $object->unsetData(\Creatuity\WelcomeToMachine\Api\Data\AlbumInterface::TRACKS);
        return $this;
    }
    
    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object) {
        parent::_afterSave($object);
        
        $this->bindTracks($object);
        $this->normalizeTrackNumbers($object);
        $this->saveTracks($object);
        $this->processDeletedTracks($object);
        
        return $this;
    }
    
    public function bindTracks(\Creatuity\WelcomeToMachine\Model\Album $album) {
        foreach($album->getTracks() as $track) {
            $track->setAlbum($album);
        }
        return $this;
    }
    
    public function normalizeTrackNumbers(\Creatuity\WelcomeToMachine\Model\Album $album) {
        $cnt = 0;
        foreach($album->getTracks() as $track) {
            $track->setTrackNumber(++$cnt);
        }
        return $this;
    }
    
    public function saveTracks(\Creatuity\WelcomeToMachine\Model\Album $album) {
        foreach($album->getTracks() as $track) {
            $track->save();
        }
        return $this;
    }
    
    public function processDeletedTracks(\Creatuity\WelcomeToMachine\Model\Album $album) {
        if ($album->isObjectNew()) {
            return ;
        }
        
        $keepTrackIds = array();
        foreach($album->getTracks() as $track) {
            $keepTrackIds[] = $track->getTrackId();
        }
        
        $trackTbl = $this->getTable('welcome_tracks');
        $selectIdsToDelete = $this->_getWriteAdapter()->select()
            ->from($trackTbl)
            ->where('`track_id` NOT IN (?)', $keepTrackIds ? $keepTrackIds : [-1])
            ->where('`album_id` = ?', $album->getAlbumId())
        ;
        
        $sql = $this->_getWriteAdapter()->deleteFromSelect($selectIdsToDelete, $trackTbl);
                
        $this->_getWriteAdapter()->query($sql);
        return $this;
    }
    
}
