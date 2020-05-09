<?php
/**
 * @copyright Copyright © 2020 CreenSight. All rights reserved.
 * @author CreenSight Development Team <magento@creensight.com>
 */

namespace CreenSight\QuickFlushCache\Controller\Adminhtml\Indexer;

use Magento\Backend\App\Action\Context;
use Magento\Indexer\Controller\Adminhtml\Indexer;
use CreenSight\QuickFlushCache\Model\Helper\ConfigProvider;

/**
 * Class ListAction
 * @package CreenSight\QuickFlushCache\Controller\Adminhtml\Indexer
 */
class ListAction extends Indexer
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * ListAction constructor.
     *
     * @param Context $context
     * @param ConfigProvider $configProvider
     */
    public function __construct(
        Context $context,
        ConfigProvider $configProvider
    ) {
        $this->configProvider = $configProvider;
        parent::__construct($context);
    }

    /**
     * Display processes grid action
     *
     * @return void
     */
    public function execute()
    {
        $this->_view->loadLayout();

        if ($this->configProvider->execute(ConfigProvider::XML_PATH_GENERAL_ENABLED_REINDEX)
            && $this->getRequest()->isAjax()) {
            $gridBlock = $this->_view->getLayout()->getBlock('adminhtml.indexer.grid.container');

            return $this->_response->representJson($gridBlock->toHtml());
        }
    }
}
