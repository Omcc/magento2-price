<?php
/**
 * Daniel Coull <d.coull@Swe.co.uk>
 * 2019-2020
 *
 */

namespace Swe\PriceLists\Plugin\Magento\Catalog\Block\Product;

use Magento\Catalog\Block\Product\View;
use Swe\PriceLists\Model\PriceListData;

class ProductView
{
    /**
     * @var PriceListData
     */
    protected $priceListData;

    /**
     * Product constructor.
     * @param PriceListData $priceListData
     */
    public function __construct(PriceListData $priceListData)
    {
        $this->priceListData = $priceListData;
    }

    /**
     * @param View $subject
     * @param callable $proceed
     * @return string
     */
    public function aroundGetTemplate(
         $subject,
         callable $proceed
    ) {
        $result = $proceed();
        if ($this->priceListData->getGeneralConfig('enable') &&
            $this->priceListData->getGeneralConfig('change_template') &&
            !$this->priceListData->getGeneralConfig('restrict_product_lists')
        ) {
            if ($subject->getNameInLayout() == 'product.info') {
                $cId = $subject->getProduct()->getId();
                $customerIds =  [];
                if ($this->priceListData->isLoggedInId()) {
                    $customerIds = $this->priceListData->getCustomerProductIds();
                }

                if (!in_array($cId, $customerIds)) {
                    $result =  'Swe_PriceLists::product/view/form.phtml';
                }
            }
        }

        return $result;
    }
}
