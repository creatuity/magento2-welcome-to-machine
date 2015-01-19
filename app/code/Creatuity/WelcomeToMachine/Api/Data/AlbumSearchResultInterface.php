<?php

namespace Creatuity\WelcomeToMachine\Api\Data;

/**
 *
 * @author m.ostrowski
 */
interface AlbumSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get customer groups list.
     *
     * @return \Creatuity\WelcomeToMachine\Api\Data\AlbumInterface[]
     */
    public function getItems();
    
}

