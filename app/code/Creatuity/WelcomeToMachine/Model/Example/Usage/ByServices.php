<?php

namespace Creatuity\WelcomeToMachine\Model\Example\Usage;

/**
 * Description of Services
 *
 * @author m.ostrowski
 */
class ByServices implements \Creatuity\WelcomeToMachine\Model\Example\UsageInterface {
    
    /**
     * @var \Creatuity\WelcomeToMachine\Api\AlbumRepositoryInterface
     */
    protected $_albumsRepository;
    
    /**
    * @var \Creatuity\WelcomeToMachine\Api\Data\AlbumInterfaceBuilder
     */
    protected $_albumBuilder;
    
    /**
     * @var \Creatuity\WelcomeToMachine\Api\TrackRepositoryInterface
     */
    protected $_tracksRepository;
    
    /**
    * @var \Creatuity\WelcomeToMachine\Api\Data\TrackInterfaceBuilder
     */
    protected $_trackBuilder;
    
    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $_searchCriteriaBuilder;
    
   /**
     * @var \Magento\Framework\Api\FilterBuilder
     */
    protected $_filterBuilder;
    
    /**
     * @var \Magento\Framework\Api\SortOrderBuilder
     */
    protected $_sortOrderBuilder;
    
    public function __construct(\Creatuity\WelcomeToMachine\Api\AlbumRepositoryInterface $albumsRepository, \Creatuity\WelcomeToMachine\Api\Data\AlbumInterfaceBuilder $albumBuilder, \Creatuity\WelcomeToMachine\Api\TrackRepositoryInterface $tracksRepository, \Creatuity\WelcomeToMachine\Api\Data\TrackInterfaceBuilder $trackBuilder, \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder, \Magento\Framework\Api\FilterBuilder $filterBuilder, \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder) {
        $this->_albumsRepository = $albumsRepository;
        $this->_albumBuilder = $albumBuilder;
        $this->_tracksRepository = $tracksRepository;
        $this->_trackBuilder = $trackBuilder;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_filterBuilder = $filterBuilder;
        $this->_sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * @param type $albumId
     * @param array $trackData
     */
    public function addTrackToAlbum($albumId, array $trackData) 
    {
        try{
            $oldAlbumData = $this->_albumsRepository->get($albumId);
            
            $newTrack = $this->_trackBuilder
                ->populateWithArray($trackData)
                ->create();
            
            $newTracks = array();
            foreach($oldAlbumData->getTracks() as $track) {
                $newTracks[] = $track;
            }
            $newTracks[] = $newTrack;
            
            $newAlbumData = $this->_albumBuilder
                ->populate($oldAlbumData)
                ->setTracks( $newTracks )
                ->create();

            $this->_albumsRepository->save($newAlbumData);
            
            return $newTrack;
        }catch(\Magento\Framework\Exception\NoSuchEntityException $exception) {
            throw new \Magento\Framework\Model\Exception("Cannot Find Album.", array(), $exception);
        }
    }
    
    /**
     * @param int $albumId
     * @param int $trackNumberInAlbum
     */
    public function removeTrackFromAlbum($albumId, $trackNumberInAlbum) {
        try{
            $oldAlbumData = $this->_albumsRepository->get($albumId);
            
            $newTracks = [];
            foreach($oldAlbumData->getTracks() as $track) {
                if ($track->getTrackNumber() !== $trackNumberInAlbum) {
                    $newTracks[] = $track;
                }
            }

            $newAlbumData = $this->_albumBuilder
                ->populate($oldAlbumData)
                ->setTracks($newTracks)
                ->create();

            $this->_albumsRepository->save($newAlbumData);
        }catch(\Magento\Framework\Exception\NoSuchEntityException $exception) {
            throw new \Magento\Framework\Model\Exception("Cannot Find Album.", array(), $exception);
        }
    }
    
    /**
     * @param int $albumId
     */
    public function negateYearOfTheAlbum($albumId) 
    {
        try{
            $oldAlbumData = $this->_albumsRepository->get($albumId);
            
            $newAlbumData = $this->_albumBuilder
                ->populate($oldAlbumData)
                ->setYear(- $oldAlbumData->getYear() )
                ->create();

            $this->_albumsRepository->save($newAlbumData);
        }catch(\Magento\Framework\Exception\NoSuchEntityException $exception) {
            throw new \Magento\Framework\Model\Exception("Cannot Find Album.", array(), $exception);
        }
    }

    /**
     * @return \Creatuity\WelcomeToMachine\Api\Data\AlbumInterface[]
     */
    public function findAlbumsEarlierThan($year) 
    {
        $criteria = $this->_searchCriteriaBuilder
            ->addFilter([
                $this->_filterBuilder
                    ->setField('year')
                    ->setConditionType('lteq')
                    ->setValue($year)
                    ->create()
            ])->setSortOrders([
                $this->_sortOrderBuilder
                    ->setField('year')
                    ->setDirection('desc')
                    ->create()
            ])->create();
        
        return $this->_albumsRepository->getList($criteria);
    }
    
    /**
     * @param string $titleLike
     * @return \Creatuity\WelcomeToMachine\Api\Data\TrackInterface[]
     */
    public function findTracksByTitle($titleLike) 
    {
        $criteria = $this->_searchCriteriaBuilder
            ->addFilter([
                $this->_filterBuilder
                    ->setField('title')
                    ->setConditionType('like')
                    ->setValue($titleLike)
                    ->create()
            ])->setSortOrders([
                $this->_sortOrderBuilder
                    ->setField('track_number')
                    ->setDirection('asc')
            ])->create();
        
        return $this->_tracksRepository->getList($criteria)->getItems();
    }
    
    /**
     * @param int $albumId
     * @param int $numberOfTrackA
     * @param int $numberOfTrackB
     */
    public function swapTracksInAlbum($albumId, $numberOfTrackA, $numberOfTrackB) 
    {
        try{
            $oldAlbumData = $this->_albumsRepository->get($albumId);
            
            $newTracks = array();
            foreach($oldAlbumData->getTracks() as $track) {
                $newTrackNumber = $this->_swapValue($track->getTrackNumber(), 
                            $numberOfTrackA, $numberOfTrackB);
                
                $newTracks[$newTrackNumber] = $this->_trackBuilder
                    ->populate($track)
                    ->create();
                ;
            }
            ksort($newTracks);

            $newAlbumData = $this->_albumBuilder
                ->populate($oldAlbumData)
                ->setTracks($newTracks)
                ->create();

            $this->_albumsRepository->save($newAlbumData);
        }catch(\Magento\Framework\Exception\NoSuchEntityException $exception) {
            throw new \Magento\Framework\Model\Exception("Cannot Find Album.", array(), $exception);
        }
    }
    
    protected function _swapValue($value, $from, $to) {
        if ($value === $from) {
            return $to;
        }elseif($value === $to) {
            return $from;
        }
        return $value;
    }
        

}
