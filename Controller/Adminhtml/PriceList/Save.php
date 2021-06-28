<?php
/**
 * Daniel Coull <d.coull@Swe.co.uk>
 * 2019-2020
 *
 */

namespace Swe\PriceLists\Controller\Adminhtml\PriceList;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Swe\PriceLists\Api\Data\PriceListCustomersInterface;
use Swe\PriceLists\Api\Data\PriceListCustomersInterfaceFactory;
use Swe\PriceLists\Api\Data\PriceListProductsInterface;
use Swe\PriceLists\Api\Data\PriceListProductsInterfaceFactory;
use Swe\PriceLists\Api\PriceListCustomersRepositoryInterface;
use Swe\PriceLists\Api\PriceListProductsRepositoryInterface;
use Swe\PriceLists\Model\ResourceModel\PriceListProducts\Collection;

/**
 * Class Save
 * @package Swe\PriceLists\Controller\Adminhtml\PriceList
 */
class Save extends Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;
    /**
     * @var PriceListCustomersRepositoryInterface
     */
    protected $priceListCustomersRepository;
    /**
     * @var PriceListProductsRepositoryInterface
     */
    protected $priceListProductsRepository;
    /**
     * @var PriceListProductsInterfaceFactory
     */
    protected $priceListProducts;
    /**
     * @var PriceListCustomersInterfaceFactory
     */
    protected $priceListCustomers;
    /**
     * @var \Swe\PriceLists\Model\ResourceModel\PriceListCustomers\CollectionFactory
     */
    protected $priceListCustomersCollection;
    /**
     * @var \Swe\PriceLists\Model\ResourceModel\PriceListProducts\CollectionFactory
     */
    protected $priceListProductsCollection;

    /**
     * @param Context $context
     * @param PriceListCustomersRepositoryInterface $priceListCustomersRepository
     * @param PriceListProductsRepositoryInterface $priceListProductsRepository
     * @param PriceListProductsInterfaceFactory $priceListProducts
     * @param PriceListCustomersInterfaceFactory $priceListCustomers
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        PriceListCustomersRepositoryInterface $priceListCustomersRepository,
        \Swe\PriceLists\Model\ResourceModel\PriceListCustomers\CollectionFactory $priceListCustomersCollection,
        \Swe\PriceLists\Model\ResourceModel\PriceListProducts\CollectionFactory $priceListProductsCollection,
        PriceListProductsRepositoryInterface $priceListProductsRepository,
        PriceListProductsInterfaceFactory $priceListProducts,
        PriceListCustomersInterfaceFactory $priceListCustomers,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->priceListCustomersRepository = $priceListCustomersRepository;
        $this->priceListProductsRepository = $priceListProductsRepository;
        $this->priceListProducts = $priceListProducts;
        $this->priceListCustomers = $priceListCustomers;
        $this->priceListCustomersCollection = $priceListCustomersCollection;
        $this->priceListProductsCollection = $priceListProductsCollection;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $products = isset($data['products']) ? $data['products'] : null;
            $customers = isset($data['customers']) ? $data['customers'] : null;

            $id = $this->getRequest()->getParam('pricelist_id');

            $model = $this->_objectManager->create(\Swe\PriceLists\Model\PriceList::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Pricelist no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Pricelist.'));
                $this->dataPersistor->clear('Swe_pricelists_pricelist');

                $this->updateProducts($products, $model->getId());
                $this->updateCustomers($customers, $model->getId());

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['pricelist_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Pricelist.'));
            }

            $this->dataPersistor->set('Swe_pricelists_pricelist', $data);
            return $resultRedirect->setPath('*/*/edit', ['pricelist_id' => $this->getRequest()->getParam('pricelist_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /***
     * Update the products table for the newly created price list
     *
     * @param $products
     * @param $id
     */
    public function updateProducts($products, $id)
    {
        /** new product ids */
        $selectedIds = [];
        $priceMap = [];
        foreach ($products as $product) {
            if (is_array($product['product_id'])) {
                foreach ($product['product_id'] as $ipd) {
                    $selectedIds[] = (int)$ipd;
                    $priceMap[$ipd] = [
                        'value'=> $product['product_price'],
                        'type' => $product['rule_type']
                    ];
                }
            } else {
                $selectedIds[] = $product['product_id'];
                $priceMap[ $product['product_id']] = [
                    'value'=> $product['product_price'],
                    'type' => $product['rule_type']
                ];
            }
        }

        /** @var Collection $collection */
        $collection = $this->priceListProductsCollection->create();
        /** Get the collection of non existing ids in the new save */
        $collection->addFieldToFilter('price_list_product_id', ['nin' => $selectedIds]);
        $collection->addFieldToFilter('price_list_id', $id);

        /** @var PriceListProductsInterface $oldItem */
        foreach ($collection as $oldItem) {
            try {
                /** delete the old item via the repository interface */
                $this->priceListProductsRepository->delete($oldItem->getDataModel());
            } catch (\Exception $E) {
            }
        }

        /** @var int $sid */
        foreach ($selectedIds as $sid) {
            /** @var PriceListProductsInterface $item */
            $item = $this->priceListProducts->create();
            try {
                /** @var Collection $collection */
                $collection = $this->priceListProductsCollection->create();
                $collection->addFieldToFilter('price_list_product_id', $sid);
                $collection->addFieldToFilter('price_list_id', $id);
                $original = $collection->getFirstItem();
                if ($original->getPriceListProductId()) {
                    /** Keep the original database id if it alredy exists as there should only be one product per list */
                    /** @var  PriceListProductsInterface $item */
                    $item = $original->getDataModel();
                }
            } catch (\Exception $e) {
            }

            $item->setPriceListProductId($sid);
            $item->setPriceListId($id);
            if (isset($priceMap[$sid])) {
                $item->setPriceListProductPrice($priceMap[$sid]['value']);
                $item->setPriceListProductRuleType($priceMap[$sid]['type']);
            }
            try {
                $this->priceListProductsRepository->save($item);
            } catch (\Exception $E) {
            }
        }
    }

    /**
     * Update the customers table for the newly created price list
     *
     * @param $customers
     * @param $id
     */
    public function updateCustomers($customers, $id)
    {
        /** new product ids */
        $selectedIds = [];
        foreach ($customers as $customer) {
            if (is_array($customer)) {
                foreach ($customer as $cid) {
                    $selectedIds[] = (int)$cid;
                }
            } else {
                $selectedIds[] = $customer;
            }
        }

        /** @var Collection $collection */
        $collection = $this->priceListCustomersCollection->create();
        /** Get the collection of non existing ids in the new save */
        $collection->addFieldToFilter('price_list_customer_id', ['nin' => $selectedIds]);
        $collection->addFieldToFilter('price_list_id', $id);

        /** @var PriceListCustomersInterface $oldItem */
        foreach ($collection as $oldItem) {
            try {
                /** delete the old item via the repository interface */
                $this->priceListCustomersRepository->delete($oldItem->getDataModel());
            } catch (\Exception $E) {
            }
        }

        /** @var int $sid */
        foreach ($selectedIds as $sid) {
            /** @var PriceListCustomersInterface $item */
            $item = $this->priceListCustomers->create();
            try {
                /** @var Collection $collection */
                $collection = $this->priceListCustomersCollection->create();
                $collection->addFieldToFilter('price_list_customer_id', $sid);
                $collection->addFieldToFilter('price_list_id', $id);
                $original = $collection->getFirstItem();
                if ($original->getPriceListCustomerId()) {
                    /** Keep the original database id if it alredy exists as there should only be one product per list */
                    /** @var  PriceListProductsInterface $item */
                    $item = $original->getDataModel();
                }
            } catch (\Exception $e) {
            }

            $item->setPriceListCustomerId($sid);
            $item->setPriceListId($id);

            try {
                $this->priceListCustomersRepository->save($item);
            } catch (\Exception $E) {
            }
        }
    }
}
