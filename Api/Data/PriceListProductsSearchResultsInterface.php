<?php
/**
 * Daniel Coull <d.coull@Swe.co.uk>
 * 2019-2020
 *
 */

namespace Swe\PriceLists\Api\Data;

interface PriceListProductsSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get PriceListProducts list.
     * @return \Swe\PriceLists\Api\Data\PriceListProductsInterface[]
     */
    public function getItems();

    /**
     * Set price_list_id list.
     * @param \Swe\PriceLists\Api\Data\PriceListProductsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
