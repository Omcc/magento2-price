<?php
/**
 * Daniel Coull <d.coull@Swe.co.uk>
 * 2019-2020
 *
 */

namespace Swe\PriceLists\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface PriceListCustomersRepositoryInterface
{

    /**
     * Save PriceListCustomers
     * @param \Swe\PriceLists\Api\Data\PriceListCustomersInterface $priceListCustomers
     * @return \Swe\PriceLists\Api\Data\PriceListCustomersInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Swe\PriceLists\Api\Data\PriceListCustomersInterface $priceListCustomers
    );

    /**
     * Retrieve PriceListCustomers
     * @param string $pricelistcustomersId
     * @return \Swe\PriceLists\Api\Data\PriceListCustomersInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($pricelistcustomersId);

    /**
     * Retrieve PriceListCustomers matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Swe\PriceLists\Api\Data\PriceListCustomersSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete PriceListCustomers
     * @param \Swe\PriceLists\Api\Data\PriceListCustomersInterface $priceListCustomers
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Swe\PriceLists\Api\Data\PriceListCustomersInterface $priceListCustomers
    );

    /**
     * Delete PriceListCustomers by ID
     * @param string $pricelistcustomersId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($pricelistcustomersId);
}
