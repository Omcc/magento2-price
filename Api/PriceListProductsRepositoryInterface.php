<?php
/**
 * Daniel Coull <d.coull@Swe.co.uk>
 * 2019-2020
 *
 */

namespace Swe\PriceLists\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface PriceListProductsRepositoryInterface
{

    /**
     * Save PriceListProducts
     * @param \Swe\PriceLists\Api\Data\PriceListProductsInterface $priceListProducts
     * @return \Swe\PriceLists\Api\Data\PriceListProductsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Swe\PriceLists\Api\Data\PriceListProductsInterface $priceListProducts
    );

    /**
     * Retrieve PriceListProducts
     * @param string $pricelistproductsId
     * @return \Swe\PriceLists\Api\Data\PriceListProductsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($pricelistproductsId);

    /**
     * Retrieve PriceListProducts matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Swe\PriceLists\Api\Data\PriceListProductsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete PriceListProducts
     * @param \Swe\PriceLists\Api\Data\PriceListProductsInterface $priceListProducts
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Swe\PriceLists\Api\Data\PriceListProductsInterface $priceListProducts
    );

    /**
     * Delete PriceListProducts by ID
     * @param string $pricelistproductsId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($pricelistproductsId);
}
