<?php
/**
 * Daniel Coull <d.coull@Swe.co.uk>
 * 2019-2020
 *
 */

namespace Swe\PriceLists\Plugin\Magento\Catalog\Model;

class Product
{
    /**
     * @var \Swe\PriceLists\Model\PriceListData
     */
    protected $priceListData;

    /**
     * Product constructor.
     * @param \Swe\PriceLists\Model\PriceListData $priceListData
     */
    public function __construct(\Swe\PriceLists\Model\PriceListData $priceListData)
    {
        $this->priceListData = $priceListData;
    }

    /**
     * @param \Magento\Catalog\Model\Product $subject
     * @param $result
     * @return int
     */
    public function afterGetPrice(
        \Magento\Catalog\Model\Product $subject,
        $result
    ) {
        $price = $result;

        if (!$this->priceListData->getGeneralConfig('enable')) {
            return $result;
        }

        $newPrice = $this->priceListData->getProductPrice($subject->getId(), $price);

        /** get the lowest price */
        if ($newPrice < $price || $price == 0) {
            $price = $newPrice;
        }

        if ($this->priceListData->getGeneralConfig('disable_tier_pricing')) {
            $subject->setTierPrices([]);
        }

        return $price > 0 ? $price : $result;
    }
}
