<?php
/**
 * Daniel Coull <d.coull@Swe.co.uk>
 * 2019-2020
 *
 */

namespace Swe\PriceLists\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface PriceListRepositoryInterface
{

    /**
     * Save PriceList
     * @param \Swe\PriceLists\Api\Data\PriceListInterface $priceList
     * @return \Swe\PriceLists\Api\Data\PriceListInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Swe\PriceLists\Api\Data\PriceListInterface $priceList
    );

    /**
     * Retrieve PriceList
     * @param string $pricelistId
     * @return \Swe\PriceLists\Api\Data\PriceListInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($pricelistId);

    /**
     * Retrieve PriceList matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Swe\PriceLists\Api\Data\PriceListSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete PriceList
     * @param \Swe\PriceLists\Api\Data\PriceListInterface $priceList
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Swe\PriceLists\Api\Data\PriceListInterface $priceList
    );

    /**
     * Delete PriceList by ID
     * @param string $pricelistId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($pricelistId);
}
