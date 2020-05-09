<?php
/**
 * @copyright Copyright © 2020 CreenSight. All rights reserved.
 * @author CreenSight Development Team <magento@creensight.com>
 */

namespace CreenSight\QuickFlushCache\Model\Helper;

use CreenSight\Core\Model\Helper\ConfigProvider as CoreConfigProvider;

/**
 * Class ConfigProvider
 * @package CreenSight\QuickFlushCache\Model\Helper
 */
class ConfigProvider
{
    /**
     * @var string
     */
    const XML_PATH_GENERAL_ENABLED_FLUSH_CACHE = 'quickflushcache/general/enabled_flush_cache';
    const XML_PATH_GENERAL_ENABLED_REINDEX = 'quickflushcache/general/enabled_reindex';

    /**
     * @var CoreConfigProvider
     */
    protected $configProvider;

    /**
     * ConfigProvider constructor.
     *
     * @param CoreConfigProvider $configProvider
     */
    public function __construct(
        CoreConfigProvider $configProvider
    ) {
        $this->configProvider = $configProvider;
    }

    /**
     * @param string $path
     * @return mixed
     */
    public function execute($path)
    {
        return $this->configProvider->execute($path);
    }
}
