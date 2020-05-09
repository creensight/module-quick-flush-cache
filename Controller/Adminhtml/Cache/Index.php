<?php
/**
 * @copyright Copyright © 2020 CreenSight. All rights reserved.
 * @author CreenSight Development Team <magento@creensight.com>
 */

namespace CreenSight\QuickFlushCache\Controller\Adminhtml\Cache;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Controller\Adminhtml\Cache;
use Magento\Framework\App\Cache\Frontend\Pool;
use Magento\Framework\App\Cache\StateInterface;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\View\Result\PageFactory;
use CreenSight\QuickFlushCache\Model\Helper\ConfigProvider;
use CreenSight\QuickFlushCache\Model\Config\Source\System\YesNo;

/**
 * Class ListAction
 * @package CreenSight\QuickFlushCache\Controller\Adminhtml\Indexer
 */
class Index extends Cache
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param TypeListInterface $cacheTypeList
     * @param StateInterface $cacheState
     * @param Pool $cacheFrontendPool
     * @param PageFactory $resultPageFactory
     * @param ConfigProvider $configProvider
     */
    public function __construct(
        Context $context,
        TypeListInterface $cacheTypeList,
        StateInterface $cacheState,
        Pool $cacheFrontendPool,
        PageFactory $resultPageFactory,
        ConfigProvider $configProvider
    ) {
        parent::__construct(
            $context,
            $cacheTypeList,
            $cacheState,
            $cacheFrontendPool,
            $resultPageFactory
        );
        $this->configProvider = $configProvider;
    }

    /**
     * Display processes grid action
     *
     * @return void
     */
    public function execute()
    {
        $this->_view->loadLayout();

        if ($this->configProvider->execute(ConfigProvider::XML_PATH_GENERAL_ENABLED_FLUSH_CACHE) === YesNo::MANUAL
            && $this->getRequest()->isAjax()) {
            $gridBlock = $this->_view->getLayout()->getBlock('adminhtml.cache.container');

            return $this->_response->representJson($gridBlock->toHtml());
        }
    }
}
