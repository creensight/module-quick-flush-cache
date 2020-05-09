<?php
/**
 * @copyright Copyright © 2020 CreenSight. All rights reserved.
 * @author CreenSight Development Team <magento@creensight.com>
 */

namespace CreenSight\QuickFlushCache\Plugin\Model\Message;

use Magento\Indexer\Model\Message\Invalid as IndexerInvalid;
use CreenSight\QuickFlushCache\Model\Helper\ConfigProvider;

/**
 * Class Invalid
 * @package CreenSight\QuickFlushCache\Plugin\Model\Message
 */
class Invalid
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * Invalid constructor.
     *
     * @param ConfigProvider $configProvider
     */
    public function __construct(
        ConfigProvider $configProvider
    ) {
        $this->configProvider = $configProvider;
    }

    /**
     * @param IndexerInvalid $subject
     * @param $result
     * @SuppressWarnings(Unused)
     *
     * @return mixed
     */
    public function afterGetText(
        IndexerInvalid $subject,
        $result
    ) {
        if ($this->configProvider->execute(ConfigProvider::XML_PATH_GENERAL_ENABLED_REINDEX)) {
            $result .= ' <a id="cs-qfc-reindex" href="#">' . __('Reindex Now!') . '</a>';
        }

        return $result;
    }
}
