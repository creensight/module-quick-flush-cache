<?php
/**
 * @copyright Copyright © 2020 CreenSight. All rights reserved.
 * @author CreenSight Development Team <magento@creensight.com>
 */

namespace CreenSight\QuickFlushCache\Plugin\Model\System\Message;

use Magento\AdminNotification\Model\System\Message\CacheOutdated as SystemCacheOutdated;
use CreenSight\QuickFlushCache\Model\Helper\ConfigProvider;
use CreenSight\QuickFlushCache\Model\Config\Source\System\YesNo;

/**
 * Class CacheOutdated
 * @package CreenSight\QuickFlushCache\Plugin\Model\System\Message
 */
class CacheOutdated
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
     * @param SystemCacheOutdated $subject
     * @param $result
     * @SuppressWarnings(Unused)
     *
     * @return mixed
     */
    public function afterGetText(
        SystemCacheOutdated $subject,
        $result
    ) {
        if ($this->configProvider->execute(ConfigProvider::XML_PATH_GENERAL_ENABLED_FLUSH_CACHE) === YesNo::MANUAL) {
            $result .= ' <a id="cs-qfc-flush-cache" href="#">' . __('Flush Now!') . '</a>';
        }

        return $result;
    }
}
