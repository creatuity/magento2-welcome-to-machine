<?php
namespace Creatuity\WelcomeToMachine\Api;

/**
 *
 * @author m.ostrowski
 */
interface AlbumRepositoryInterface {
    
    /**
     * @param \Magento\Framework\Api\SearchCriteria $criteria
     * @return \Creatuity\WelcomeToMachine\Api\Data\AlbumSearchResultInterface[]
     */
    public function getList(\Magento\Framework\Api\SearchCriteria $criteria);

    /**
     * Load entity
     *
     * @param int $id
     * @return \Creatuity\WelcomeToMachine\Api\Data\AlbumInterface
     */
    public function get($id);

    /**
     * Delete entity
     *
     * @param \Creatuity\WelcomeToMachine\Api\Data\AlbumInterface $entity
     * @return bool
     */
    public function delete(\Creatuity\WelcomeToMachine\Api\Data\AlbumInterface $entity);

    /**
     * Delete entity
     *
     * @param int $id
     * @return bool
     */
    public function deleteById($id);

    /**
     * Perform persist operations for one entity
     *
     * @param \Creatuity\WelcomeToMachine\Api\Data\AlbumInterface $entity
     * @return \Creatuity\WelcomeToMachine\Api\Data\AlbumInterface
     */
    public function save(\Creatuity\WelcomeToMachine\Api\Data\AlbumInterface $entity);
    
}
