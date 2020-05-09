<?php
/**
 * @copyright Copyright © 2020 CreenSight. All rights reserved.
 * @author CreenSight Development Team <magento@creensight.com>
 */

namespace CreenSight\QuickFlushCache\Controller\Adminhtml\Cache;

use Exception;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Element\Messages;
use CreenSight\QuickFlushCache\Controller\Adminhtml\AbstractController;

/**
 * Class FlushSystem
 * @package CreenSight\QuickFlushCache\Controller\Adminhtml\Cache
 */
class FlushSystem extends AbstractController
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Magento_Backend::flush_magento_cache';

    /**
     * @return ResponseInterface|Json|ResultInterface
     * @throws Exception
     */
    public function execute()
    {
        /** @var Http $request */
        $request = $this->getRequest();

        if (!$request->isAjax()) {
            return $this->_resultForwardFactory->create()->forward('noroute');
        }

        $invalidCaches = [];
        foreach ($this->_cacheTypeList->getInvalidated() as $type) {
            $invalidCaches[] = $type->getId();
        }

        foreach ($invalidCaches as $typeId) {
            $this->_cacheTypeList->cleanType($typeId);
        }

        $this->_eventManager->dispatch('adminhtml_cache_flush_system');
        $this->_synchronizeSystemMessage->execute();

        /** @var Messages $messageBlock */
        $messageBlock = $this->_layout->createBlock(Messages::class);
        $messageBlock->addSuccess(__('The Magento cache storage has been flushed.'));

        $result = [
            'success' => true,
            'message' => $messageBlock->toHtml()
        ];

        return $this->_resultJson->setData($result);
    }
}
