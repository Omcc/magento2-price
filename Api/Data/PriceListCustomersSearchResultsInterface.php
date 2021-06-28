<?php
/**
 * Daniel Coull <d.coull@Swe.co.uk>
 * 2019-2020
 *
 */

namespace Swe\PriceLists\Api\Data;

interface PriceListCustomersSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get PriceListCustomers list.
     * @return \Swe\PriceLists\Api\Data\PriceListCustomersInterface[]
     */
    public function getItems();

    /**
     * Set price_list_id list.
     * @param \Swe\PriceLists\Api\Data\PriceListCustomersInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
