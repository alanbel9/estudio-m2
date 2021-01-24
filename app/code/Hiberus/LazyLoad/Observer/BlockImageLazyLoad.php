<?php

namespace Hiberus\LazyLoad\Observer;

use Hiberus\LazyLoad\Helper\Data as LazyLoadHelper;
use Magento\Framework\Event\Observer;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class BlockImageLazyLoad
 *
 * @author vjurado
 *
 */
class BlockImageLazyLoad implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * LazyLoad data
     *
     * @var LazyLoadHelper
     */
    protected $_lazyLoadHelper;

    /**
     * @param Context $context
     * @param LazyLoadHelper $lazyLoadHelper
     * @param array $data
     */
    public function __construct(
        LazyLoadHelper $lazyLoadHelper
    ) {
        $this->_lazyLoadHelper = $lazyLoadHelper;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(Observer $observer)
    {
        if (!$this->_lazyLoadHelper->isEnabled()) {
            return;
        }

        $html = $observer->getData('transport')->getData('html');

        if (!$html) {
            return;
        }

        if (strpos($html, '<img ') === false) {
            return;
        }

        $lazyReplace = 'loading="lazy"';

        if (strpos($html, $lazyReplace) === false) {
            $html = preg_replace_callback('/<img .*?>/s', function ($matches) use ($lazyReplace) {
                $match = $matches[0];

                if (!strpos($match, $lazyReplace)) {
                    $match = str_replace('<img ', '<img ' . $lazyReplace . ' ' , $match);
                }

                return $match;

                //return preg_replace('/\bsrc\s*=\s*[\'"](.*?)[\'"]/',
                  //  'src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP87wMAAlABTQluYBcAAAAASUVORK5CYII=" data-src="$1"', $match);
            }, $html);

            $observer->getData('transport')->setData('html', $html);
        }

        /*if (strpos($html, $lazyReplace) === false) {
            $html = preg_replace_callback('/<img .*?>/s', function ($matches) use ($lazyReplace) {
                $match = $matches[0];

                if (strpos($match, 'no-lazy') !== false) {

                    return $match;
                }

                if (strpos($match, 'class="')) {
                    $match = str_replace('class="', 'class="' . $lazyReplace . ' ', $match);
                } else {
                    $match = str_replace('<img ', '<img class="' . $lazyReplace . '" ', $match);
                }

                return preg_replace('/\bsrc\s*=\s*[\'"](.*?)[\'"]/',
                    'src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP87wMAAlABTQluYBcAAAAASUVORK5CYII=" data-src="$1"', $match);
            }, $html);

            $observer->getData('transport')->setData('html', $html);
        }*/
    }
}
