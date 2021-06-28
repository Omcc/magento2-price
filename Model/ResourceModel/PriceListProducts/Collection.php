<?php
/**
 * Daniel Coull <d.coull@Swe.co.uk>
 * 2019-2020
 *
 */

namespace Swe\PriceLists\Model\ResourceModel\PriceListProducts;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Swe\PriceLists\Model\PriceListProducts::class,
            \Swe\PriceLists\Model\ResourceModel\PriceListProducts::class
        );
    }
}
