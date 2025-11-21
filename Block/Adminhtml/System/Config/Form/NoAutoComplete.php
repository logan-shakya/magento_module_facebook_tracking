<?php
namespace Hivecraft\FacebookTracking\Block\Adminhtml\System\Config\Form;

use Magento\Framework\Data\Form\Element\AbstractElement;

class NoAutoComplete extends \Magento\Config\Block\System\Config\Form\Field
{
    protected function _getElementHtml(AbstractElement $element)
    {
        $element->setData('autocomplete', 'off');
        return parent::_getElementHtml($element);
    }
}
