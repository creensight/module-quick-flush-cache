<?php
/**
 * @copyright Copyright © 2020 CreenSight. All rights reserved.
 * @author CreenSight Development Team <magento@creensight.com>
 */

namespace CreenSight\QuickFlushCache\Controller\Adminhtml\Indexer;

use Exception;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Element\Messages;
use CreenSight\QuickFlushCache\Controller\Adminhtml\AbstractController;

/**
 * Class Reindex
 * @package CreenSight\QuickFlushCache\Controller\Adminhtml\Indexer
 */
class Reindex extends AbstractController
{
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

        $this->_processor->reindexAllInvalid();
        $this->_synchronizeSystemMessage->execute();

        /** @var Messages $messageBlock */
        $messageBlock = $this->_layout->createBlock(Messages::class);
        $messageBlock->addSuccess(__('You have reindexed successfully.'));
        $result = [
            'success' => true,
            'message' => $messageBlock->toHtml()
        ];

        return $this->_resultJson->setData($result);
    }
}
