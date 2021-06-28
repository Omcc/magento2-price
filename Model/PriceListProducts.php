<?php
/**
 * Daniel Coull <d.coull@Swe.co.uk>
 * 2019-2020
 *
 */

namespace Swe\PriceLists\Model;

use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Swe\PriceLists\Api\Data\PriceListProductsInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Swe\PriceLists\Api\Data\PriceListProductsInterface;
use Swe\PriceLists\Model\ResourceModel\PriceListProducts\Collection;

/**
 * Class PriceListProducts
 * @package Swe\PriceLists\Model
 */
class PriceListProducts extends \Magento\Framework\Model\AbstractModel
{

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;
    /**
     * @var PriceListProductsInterfaceFactory
     */
    protected $pricelistproductsDataFactory;

    /**
     * @var string
     */
    protected $_eventPrefix = 'Swe_pricelists_pricelistproducts';

    /**
     * @param Context $context
     * @param Registry $registry
     * @param PriceListProductsInterfaceFactory $pricelistproductsDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param ResourceModel\PriceListProducts $resource
     * @param Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        PriceListProductsInterfaceFactory $pricelistproductsDataFactory,
        DataObjectHelper $dataObjectHelper,
        ResourceModel\PriceListProducts $resource,
        Collection $resourceCollection,
        array $data = []
    ) {
        $this->pricelistproductsDataFactory = $pricelistproductsDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve pricelistproducts model with pricelistproducts data
     * @return PriceListProductsInterface
     */
    public function getDataModel()
    {
        $pricelistproductsData = $this->getData();

        $pricelistproductsDataObject = $this->pricelistproductsDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $pricelistproductsDataObject,
            $pricelistproductsData,
            PriceListProductsInterface::class
        );

        return $pricelistproductsDataObject;
    }
}
