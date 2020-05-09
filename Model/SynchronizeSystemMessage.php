<?php
/**
 * @copyright Copyright © 2020 CreenSight. All rights reserved.
 * @author CreenSight Development Team <magento@creensight.com>
 */

namespace CreenSight\QuickFlushCache\Model;

use Magento\Framework\Notification\MessageList;
use Magento\AdminNotification\Model\ResourceModel\System\Message as SystemMessageResource;
use Magento\AdminNotification\Model\ResourceModel\System\Message\Collection\SynchronizedFactory as SynchronizedColFact;

/**
 * Class SynchronizeSystemMessage
 * @package CreenSight\QuickFlushCache\Model
 */
class SynchronizeSystemMessage
{
    /**
     * @var MessageList
     */
    private $messageList;

    /**
     * @var SystemMessageResource
     */
    private $messageResource;

    /**
     * @var SynchronizedColFact
     */
    private $synchronizedColFact;

    /**
     * SynchronizeSystemMessage constructor.
     *
     * @param MessageList $messageList
     * @param SystemMessageResource $messageResource
     * @param SynchronizedColFact $synchronizedColFact
     */
    public function __construct(
        MessageList $messageList,
        SystemMessageResource $messageResource,
        SynchronizedColFact $synchronizedColFact
    ) {
        $this->messageList = $messageList;
        $this->messageResource = $messageResource;
        $this->synchronizedColFact = $synchronizedColFact;
    }

    /**
     * @param string $path
     * @return mixed
     */
    public function execute()
    {
        $messages  = $this->messageList->asArray();
        $persisted = [];
        $items     = $this->synchronizedColFact->create()->getItems();

        foreach ($messages as $message) {
            if ($message->isDisplayed()) {
                foreach ($items as $persistedKey => $persistedMessage) {
                    if ($message->getIdentity() === $persistedMessage->getIdentity()) {
                        $persisted[$persistedKey] = $persistedMessage;
                        continue 2;
                    }
                }
            }
        }

        $removed = array_diff_key($items, $persisted);

        foreach ($removed as $removedItem) {
            /** @var SystemMessageModel $removedItem */
            $this->messageResource->delete($removedItem);
        }
    }
}
