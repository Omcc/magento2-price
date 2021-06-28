<?php
/**
 * Daniel Coull <d.coull@Swe.co.uk>
 * 2019-2020
 *
 */

namespace Swe\PriceLists\Api\Data;

interface PriceListInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const DESCRIPTION = 'description';
    const NAME = 'name';
    const PRICELIST_ID = 'pricelist_id';

    /**
     * Get pricelist_id
     * @return string|null
     */
    public function getPricelistId();

    /**
     * Set pricelist_id
     * @param string $pricelistId
     * @return \Swe\PriceLists\Api\Data\PriceListInterface
     */
    public function setPricelistId($pricelistId);

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return \Swe\PriceLists\Api\Data\PriceListInterface
     */
    public function setName($name);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Swe\PriceLists\Api\Data\PriceListExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Swe\PriceLists\Api\Data\PriceListExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Swe\PriceLists\Api\Data\PriceListExtensionInterface $extensionAttributes
    );

    /**
     * Get description
     * @return string|null
     */
    public function getDescription();

    /**
     * Set description
     * @param string $description
     * @return \Swe\PriceLists\Api\Data\PriceListInterface
     */
    public function setDescription($description);
}
