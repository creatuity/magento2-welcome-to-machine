<?php
namespace Creatuity\WelcomeToMachine\Api;

/**
 *
 * @author m.ostrowski
 */
interface TrackRepositoryInterface {
    
    /**
     * @param \Magento\Framework\Api\SearchCriteria $criteria
     * @return \Creatuity\WelcomeToMachine\Api\Data\TrackSearchResultInterface[]
     */
    public function getList(\Magento\Framework\Api\SearchCriteria $criteria);
    
    /**
     * Load entity
     *
     * @param int $id
     * @return \Creatuity\WelcomeToMachine\Api\Data\TrackInterface
     */
    public function get($id);

    /**
     * Delete entity
     *
     * @param \Creatuity\WelcomeToMachine\Api\Data\TrackInterface $entity
     * @return bool
     */
    public function delete(\Creatuity\WelcomeToMachine\Api\Data\TrackInterface $entity);

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
     * @param \Creatuity\WelcomeToMachine\Api\Data\TrackInterface $entity
     * @return \Creatuity\WelcomeToMachine\Api\Data\TrackInterface
     */
    public function save(\Creatuity\WelcomeToMachine\Api\Data\TrackInterface $entity);
    
}
