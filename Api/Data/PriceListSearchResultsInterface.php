<?php
/**
 * Daniel Coull <d.coull@Swe.co.uk>
 * 2019-2020
 *
 */

namespace Swe\PriceLists\Api\Data;

interface PriceListSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get PriceList list.
     * @return \Swe\PriceLists\Api\Data\PriceListInterface[]
     */
    public function getItems();

    /**
     * Set name list.
     * @param \Swe\PriceLists\Api\Data\PriceListInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
