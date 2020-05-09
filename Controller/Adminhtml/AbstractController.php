<?php
/**
 * @copyright Copyright © 2020 CreenSight. All rights reserved.
 * @author CreenSight Development Team <magento@creensight.com>
 */

namespace CreenSight\QuickFlushCache\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\View\Layout;
use Magento\Indexer\Model\Processor;
use CreenSight\QuickFlushCache\Model\SynchronizeSystemMessage;

/**
 * Class AbstractController
 * @package CreenSight\QuickFlushCache\Controller\Adminhtml
 */
abstract class AbstractController extends Action
{
    /**
     * @var ForwardFactory
     */
    protected $_resultForwardFactory;

    /**
     * @var TypeListInterface
     */
    protected $_cacheTypeList;

    /**
     * @var Json
     */
    protected $_resultJson;

    /**
     * @var Layout
     */
    protected $_layout;

    /**
     * @var Processor
     */
    protected $_processor;

    /**
     * @var SynchronizeSystemMessage
     */
    protected $_synchronizeSystemMessage;

    /**
     * FlushSystem constructor.
     *
     * @param Context $context
     * @param ForwardFactory $resultForwardFactory
     * @param TypeListInterface $cacheTypeList
     * @param Json $resultJson
     * @param Layout $layout
     * @param Processor $processor
     * @param SynchronizeSystemMessage $synchronizeSystemMessage
     */
    public function __construct(
        Context $context,
        ForwardFactory $resultForwardFactory,
        TypeListInterface $cacheTypeList,
        Json $resultJson,
        Layout $layout,
        Processor $processor,
        SynchronizeSystemMessage $synchronizeSystemMessage
    ) {
        parent::__construct($context);

        $this->_resultForwardFactory = $resultForwardFactory;
        $this->_cacheTypeList = $cacheTypeList;
        $this->_resultJson = $resultJson;
        $this->_layout = $layout;
        $this->_processor = $processor;
        $this->_synchronizeSystemMessage = $synchronizeSystemMessage;
    }
}
