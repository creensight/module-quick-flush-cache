<?php
/**
 * @copyright Copyright © 2020 CreenSight. All rights reserved.
 * @author CreenSight Development Team <magento@creensight.com>
 */

namespace CreenSight\QuickFlushCache\Observer;

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use CreenSight\QuickFlushCache\Model\Helper\ConfigProvider;
use CreenSight\QuickFlushCache\Model\Config\Source\System\YesNo;

/**
 * Class ControllerActionPredispatch
 * @package CreenSight\QuickFlushCache\Observer\Backend
 */
class ControllerActionPredispatch implements ObserverInterface
{
    /**
     * @var ManagerInterface
     */
    private $eventManager;

    /**
     * @var MessageManagerInterface
     */
    private $messageManager;

    /**
     * @var TypeListInterface
     */
    private $cacheTypeList;

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * ControllerActionPredispatch constructor.
     *
     * @param ManagerInterface $eventManager
     * @param MessageManagerInterface $messageManager
     * @param TypeListInterface $cacheTypeList
     * @param ConfigProvider $configProvider
     */
    public function __construct(
        ManagerInterface $eventManager,
        MessageManagerInterface $messageManager,
        TypeListInterface $cacheTypeList,
        ConfigProvider $configProvider
    ) {
        $this->eventManager = $eventManager;
        $this->messageManager = $messageManager;
        $this->cacheTypeList = $cacheTypeList;
        $this->configProvider = $configProvider;
    }

    /**
     * @param EventObserver $observer
     */
    public function execute(EventObserver $observer)
    {
        /** @var RequestInterface $request */
        $request = $observer->getEvent()->getRequest();

        $notAllowedController = [
            'adminhtml_auth_login',
            'adminhtml_auth_forgotpassword',
            'mui_index_render',
            'quickflushcache_cache_flushsystem',
            'quickflushcache_indexer_reindex'
        ];

        if ($this->configProvider->execute(ConfigProvider::XML_PATH_GENERAL_ENABLED_FLUSH_CACHE) === YesNo::AUTO
            && !$request->isAjax()
            && !in_array($request->getFullActionName(), $notAllowedController, true)) {
            $invalidCaches = [];
            foreach ($this->cacheTypeList->getInvalidated() as $type) {
                $invalidCaches[] = $type->getId();
            }
            if ($invalidCaches) {
                foreach ($invalidCaches as $typeId) {
                    $this->cacheTypeList->cleanType($typeId);
                }
                $this->eventManager->dispatch('adminhtml_cache_flush_system');
                $this->messageManager->addSuccessMessage(__('The Magento cache storage has been automatically flushed.'));
            }
        }
    }
}
