<?php
namespace Creatuity\WelcomeToMachine\Model\Resource\Track;

use Creatuity\WelcomeToMachine\Api\Data\TrackSearchResultInterface;


/**
 * Description of Collection
 *
 * @author m.ostrowski
 */
class Collection extends \Magento\Framework\Model\Resource\Db\Collection\AbstractCollection
    implements TrackSearchResultInterface
{
    
    protected $_eventObject = 'track';
    
    protected $_albumFilter;
    
    protected function _construct() {
        $this->_init(
            '\Creatuity\WelcomeToMachine\Model\Track', 
            '\Creatuity\WelcomeToMachine\Model\Resource\Track'
        );
    }
    
    /**
     * Set customer filter
     *
     * @param \Creatuity\WelcomeToMachine\Api\Data\AlbumInterface|array
     * @return $this
     */
    public function setAlbumFilter($album)
    {
        $this->_albumFilter = $album;
        return $this;
    }
    
    protected function _beforeLoad() 
    {
        parent::_beforeLoad();
        
        if (is_array($this->_albumFilter)) {
            $this->addFieldToFilter('album_id', array('in' => $this->_albumFilter));
        } elseif ($this->_albumFilter->getId()) {
            $this->addFieldToFilter('album_id', $this->_albumFilter->getId());
        } else {
            $this->addFieldToFilter('album_id', '-1');
        }
    }
    
    public function sortByTrackNumber($isReverse = false) 
    {
        $this->addOrder('track_number', $isReverse ? 'desc' : 'asc');
        return $this;
    }
    
    public function getTotalCount() 
    {
        return $this->getSize();
    }

    public function getSearchCriteria() 
    {
        return null;
    }
    
}
