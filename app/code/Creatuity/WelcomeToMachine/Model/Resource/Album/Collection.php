<?php
namespace Creatuity\WelcomeToMachine\Model\Resource\Album;

use Creatuity\WelcomeToMachine\Api\Data\AlbumSearchResultInterface;


/**
 * Description of Collection
 *
 * @author m.ostrowski
 */
class Collection extends \Magento\Framework\Model\Resource\Db\Collection\AbstractCollection
    implements AlbumSearchResultInterface
{
    
    protected function _construct() {
        $this->_init(
            '\Creatuity\WelcomeToMachine\Model\Album', 
            '\Creatuity\WelcomeToMachine\Model\Resource\Album'
        );
    }
    
    public function getSearchCriteria() {
        return null;
    }
    
    public function getTotalCount() {
        return $this->getSize();
    }

    public function addFieldToFilter($field, $condition = null) {
        if ($field == 'artist') {
            throw new Exception("You cannot filter by artist. for the glory of Pink Floyd");
        }
        return parent::addFieldToFilter($field, $condition);
    }

}
