<?php
/**
 * @author: daniDLL
 * Date: 30/07/19
 * Time: 14:05
 */

namespace Hiberus\LazyLoad\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Hiberus\LazyLoad\Helper\Data as LazyLoadHelper;

/**
 * Class Js
 * @package Hiberus\LazyLoad\Block
 */
class Js extends Template
{
    /**
     * LazyLoad data
     *
     * @var LazyLoadHelper
     */
    protected $_lazyLoadHelper = null;

    /**
     * @param Context $context
     * @param LazyLoadHelper $lazyLoadHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        LazyLoadHelper $lazyLoadHelper,
        array $data = []
    ) {
        $this->_lazyLoadHelper = $lazyLoadHelper;

        parent::__construct($context, $data);
    }

    /**
     * Render tag manager JS
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->_lazyLoadHelper->isEnabled()) {
            return '';
        }

        return parent::_toHtml();
    }
}
