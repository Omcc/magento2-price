<?php
/**
 * Daniel Coull <d.coull@Swe.co.uk>
 * 2019-2020
 *
 */

namespace Swe\PriceLists\Api\Data;

interface PriceListCustomersInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const PRICE_LIST_CUSTOMER_ID = 'price_list_customer_id';
    const PRICE_LIST_ID = 'price_list_id';
    const PRICELISTCUSTOMERS_ID = 'pricelistcustomers_id';

    /**
     * Get pricelistcustomers_id
     * @return string|null
     */
    public function getPricelistcustomersId();

    /**
     * Set pricelistcustomers_id
     * @param string $pricelistcustomersId
     * @return \Swe\PriceLists\Api\Data\PriceListCustomersInterface
     */
    public function setPricelistcustomersId($pricelistcustomersId);

    /**
     * Get price_list_id
     * @return string|null
     */
    public function getPriceListId();

    /**
     * Set price_list_id
     * @param string $priceListId
     * @return \Swe\PriceLists\Api\Data\PriceListCustomersInterface
     */
    public function setPriceListId($priceListId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Swe\PriceLists\Api\Data\PriceListCustomersExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Swe\PriceLists\Api\Data\PriceListCustomersExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Swe\PriceLists\Api\Data\PriceListCustomersExtensionInterface $extensionAttributes
    );

    /**
     * Get price_list_customer_id
     * @return string|null
     */
    public function getPriceListCustomerId();

    /**
     * Set price_list_customer_id
     * @param string $priceListCustomerId
     * @return \Swe\PriceLists\Api\Data\PriceListCustomersInterface
     */
    public function setPriceListCustomerId($priceListCustomerId);
}
