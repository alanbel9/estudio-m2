<?php
/**
 * @author: daniDLL
 * Date: 30/07/19
 * Time: 13:18
 */

namespace Hiberus\LazyLoad\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package Hiberus\LazyLoad\Helper
 */
class Data extends AbstractHelper
{
    const   XML_PATH_ACTIVE     =   'hiberus_lazy_load/general_config/active';
    const   XML_SKIP_AMOUNT     =   'hiberus_lazy_load/general_config/skip_amount';

    /**
     * @var int
     */
    public static $ignoreLazyLoad = 0;

    /**
     * If enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ACTIVE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Ignore first x amount
     *
     * @return int
     */
    public function getSkipAmount()
    {
        return $this->scopeConfig->getValue(
            self::XML_SKIP_AMOUNT,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Check ignore amount
     *
     * @return bool
     */
    public function applyLazyLoad()
    {
        if (self::$ignoreLazyLoad < $this->getSkipAmount() * 2) {
            self::$ignoreLazyLoad++;
            return false;
        }
        return true;
    }

    /**
     * Display JS code
     * @return bool
     */
    public function hasLazyLoadImages()
    {
        return self::$ignoreLazyLoad > 0;
    }
}