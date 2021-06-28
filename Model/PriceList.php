<?php
/**
 * Daniel Coull <d.coull@Swe.co.uk>
 * 2019-2020
 *
 */

namespace Swe\PriceLists\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Swe\PriceLists\Api\Data\PriceListInterface;
use Swe\PriceLists\Api\Data\PriceListInterfaceFactory;
use Swe\PriceLists\Model\ResourceModel\PriceList\Collection;

/**
 * Class PriceList
 * @package Swe\PriceLists\Model
 */
class PriceList extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;
    /**
     * @var PriceListInterfaceFactory
     */
    protected $pricelistDataFactory;

    /**
     * @var string
     */
    protected $_eventPrefix = 'Swe_pricelists_pricelist';

    /**
     * @param Context $context
     * @param Registry $registry
     * @param PriceListInterfaceFactory $pricelistDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param ResourceModel\PriceList $resource
     * @param Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        PriceListInterfaceFactory $pricelistDataFactory,
        DataObjectHelper $dataObjectHelper,
        ResourceModel\PriceList $resource,
        Collection $resourceCollection,
        array $data = []
    ) {
        $this->pricelistDataFactory = $pricelistDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve pricelist model with pricelist data
     * @return PriceListInterface
     */
    public function getDataModel()
    {
        $pricelistData = $this->getData();

        $pricelistDataObject = $this->pricelistDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $pricelistDataObject,
            $pricelistData,
            PriceListInterface::class
        );

        return $pricelistDataObject;
    }
}
