<?php
/**
 * Daniel Coull <d.coull@Swe.co.uk>
 * 2019-2020
 *
 */

namespace Swe\PriceLists\Block\Adminhtml\PriceList\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveAndContinueButton
 * @package Swe\PriceLists\Block\Adminhtml\PriceList\Edit
 */
class SaveAndContinueButton extends GenericButton implements ButtonProviderInterface
{

    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save and Continue Edit'),
            'class' => 'save',
            'data_attribute' => [
                'mage-init' => [
                    'button' => ['event' => 'saveAndContinueEdit'],
                ],
            ],
            'sort_order' => 80,
        ];
    }
}
