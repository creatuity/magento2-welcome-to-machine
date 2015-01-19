<?php

namespace Creatuity\WelcomeToMachine\Model\Resource;

/**
 * Description of Setup
 *
 * @author m.ostrowski
 */
class Setup extends \Magento\Framework\Module\DataSetup { 
    
    public function createAlbums(array $data) {
        foreach($data as $albumData) {
            $this->createAlbum($albumData);
        }
    }
    
    public function createAlbum(array $data) {
        $this->getConnection()->insert(
            $this->getTable('welcome_albums'), [
                'title' => $data['title'],
                'year' => $data['year']
            ]
        );
        
        $this->createTracks(
            $this->getConnection()->lastInsertId(), 
            $data['tracks']
        );
    }
    
    public function createTracks($albumId, array $data) {
        $rows = [];
        
        $trackNumber = 0;
        foreach($data as $title) {
            $rows[] = [
                'album_id' => $albumId,                
                'track_number' => ++$trackNumber,
                'title' => $title,
            ];
        }
        
        $this->getConnection()->insertMultiple(
            $this->getTable('welcome_tracks'), 
            $rows
        );
    }
    
}
