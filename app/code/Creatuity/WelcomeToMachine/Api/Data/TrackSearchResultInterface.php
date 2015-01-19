<?php

namespace Creatuity\WelcomeToMachine\Api\Data;

/**
 *
 * @author m.ostrowski
 */
interface TrackSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get customer groups list.
     *
     * @return \Creatuity\WelcomeToMachine\Api\Data\TrackInterface[]
     */
    public function getItems();
    
}

