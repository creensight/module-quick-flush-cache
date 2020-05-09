<?php
/**
 * @copyright Copyright © 2020 CreenSight. All rights reserved.
 * @author CreenSight Development Team <magento@creensight.com>
 */

namespace CreenSight\QuickFlushCache\Model\Config\Source\System;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class YesNo
 * @package CreenSight\QuickFlushCache\Model\Config\Source\System
 */
class YesNo implements ArrayInterface
{
    const AUTO   = '1';
    const MANUAL = '2';
    const NO     = '0';

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [
            self::AUTO   => __('Yes (Automatic)'),
            self::MANUAL => __('Yes (Manual)'),
            self::NO     => __('No'),
        ];
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        foreach ($this->toArray() as $value => $label) {
            $options[] = compact('value', 'label');
        }

        return $options;
    }
}
