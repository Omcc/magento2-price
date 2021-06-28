<?php
/**
 * Daniel Coull <d.coull@Swe.co.uk>
 * 2019-2020
 *
 */

namespace Swe\PriceLists\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;
use Swe\PriceLists\Api\Data\PriceListInterface;

/**
 * Class PriceList
 * @package Swe\PriceLists\Model\Data
 */
class PriceList extends AbstractExtensibleObject implements PriceListInterface
{

    /**
     * Get pricelist_id
     * @return string|null
     */
    public function getPricelistId()
    {
        return $this->_get(self::PRICELIST_ID);
    }

    /**
     * Set pricelist_id
     * @param string $pricelistId
     * @return \Swe\PriceLists\Api\Data\PriceListInterface
     */
    public function setPricelistId($pricelistId)
    {
        return $this->setData(self::PRICELIST_ID, $pricelistId);
    }

    /**
     * Get name
     * @return string|null
     */
    public function getName()
    {
        return $this->_get(self::NAME);
    }

    /**
     * Set name
     * @param string $name
     * @return \Swe\PriceLists\Api\Data\PriceListInterface
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Swe\PriceLists\Api\Data\PriceListExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Swe\PriceLists\Api\Data\PriceListExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Swe\PriceLists\Api\Data\PriceListExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get description
     * @return string|null
     */
    public function getDescription()
    {
        return $this->_get(self::DESCRIPTION);
    }

    /**
     * Set description
     * @param string $description
     * @return \Swe\PriceLists\Api\Data\PriceListInterface
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }
}
