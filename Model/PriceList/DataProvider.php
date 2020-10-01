<?php
/**
 * Daniel Coull <d.coull@suttonsilver.co.uk>
 * 2019-2020
 *
 */

namespace SuttonSilver\PriceLists\Model\PriceList;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\UrlInterface;

use SuttonSilver\PriceLists\Model\ResourceModel\PriceList\CollectionFactory;
use SuttonSilver\PriceLists\Model\ResourceModel\PriceList\Collection;

/**
 * Class DataProvider
 * @package SuttonSilver\PriceLists\Model\PriceList
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    protected $loadedData;
    protected $url;
    protected $priceListCustomersCollection;
    protected $priceListProductsCollection;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        UrlInterface $url,
        \SuttonSilver\PriceLists\Model\ResourceModel\PriceListCustomers\CollectionFactory $priceListCustomersCollection,
        \SuttonSilver\PriceLists\Model\ResourceModel\PriceListProducts\CollectionFactory $priceListProductsCollection,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->url = $url;
        $this->priceListCustomersCollection = $priceListCustomersCollection;
        $this->priceListProductsCollection = $priceListProductsCollection;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        foreach ($items as $model) {
            $this->loadedData[$model->getPricelistId()] = $model->getData();
            $collection = $this->priceListCustomersCollection->create()
                ->addFieldToFilter('price_list_id', $model->getPricelistId());

            foreach ($collection as $key => $customer) {
                $this->loadedData[$model->getPricelistId()]['customers'][] = $customer->getPriceListCustomerId();
            }

            $collection = $this->priceListProductsCollection->create()
                ->addFieldToFilter('price_list_id', $model->getPricelistId());

            $p = [];
            foreach ($collection as $products) {
                $p[$products->getPriceListProductPrice()][] = [
                    'product_id' => $products->getPriceListProductId(),
                    'rule_type' => $products->getPriceListProductRuleType()
                ];
            }

            foreach ($p as $key => $productSet) {
                $productIds = array_column($productSet, 'product_id');
                $ruleTypes = array_column($productSet, 'rule_type');

                $this->loadedData[$model->getPricelistId()]['products'][] = [
                    'product_id' => $productIds,
                    'product_price' => $key,
                    'rule_type' => $ruleTypes
                ];
            }
        }
        $data = $this->dataPersistor->get('suttonsilver_pricelists_pricelist');

        $model = false;
        if (!empty($data)) {

            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getPricelistId()] = $model->getData();

            $this->dataPersistor->clear('suttonsilver_pricelists_pricelist');
        }

        return $this->loadedData;
    }

    public function getMeta()
    {
        $meta = parent::getMeta();
        $meta["general"]['children']["customers"]['arguments']['data']['config']['searchUrl'] =
            $this->url->getUrl('suttonsilver_pricelists/pricelist/searchcustomers');

        $meta["general"]['children']["products"]['children']['record']['children']['product_id']['arguments']['data']['config']['searchUrl'] =
            $this->url->getUrl('suttonsilver_pricelists/pricelist/searchproducts');

        $meta["general"]['children']["products"]['children']['record']['children']['product_id']['arguments']['data']['config']['validationUrl'] =
            $this->url->getUrl('suttonsilver_pricelists/pricelist/validateproducts');

        return $meta;
    }
}
