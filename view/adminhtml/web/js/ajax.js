/**
 * @copyright Copyright © 2020 CreenSight. All rights reserved.
 * @author CreenSight Development Team <magento@creensight.com>
 */

define([
    'jquery',
    'uiRegistry'
], function ($, registry) {
    'use strict';

    $.widget('creensight.fullPageCacheAjax', {
        options: {
            flushCacheUrl: '',
            flushCacheIndexUrl: '',
            reindexUrl: '',
            reindexListUrl: ''
        },

        /**
         * @inheritDoc
         */
        _create: function () {
            var self   = this,
                body = $('body');

            body.on('click', '#cs-qfc-flush-cache', function () {
                self.quickFlushCacheAndReindex(self.options.flushCacheUrl, 'cache');
            });
            body.on('click', '#cs-qfc-reindex', function () {
                self.quickFlushCacheAndReindex(self.options.reindexUrl, 'reindex');
            });
        },

        /** Ajax quick flush cache & reindex */
        quickFlushCacheAndReindex: function (url, type) {
            var self = this,
                target;

            if (type === 'reindex') {
                $('.notices-wrapper .fullpagecache-image-loader').show();
            }
            $.ajax({
                type: "POST",
                url: url,
                data: {form_key: window.FORM_KEY},
                success: function (response) {
                    if (response.ajaxRedirect) {
                        window.location.href = response.ajaxRedirect;
                    }
                    if (response.success) {
                        target = self.updateGrid();
                        target.on('reloaded', function () {
                            $('.page-content .messages').remove();
                            $(response.message).insertBefore($('.page-columns'));
                            if (type === 'reindex') {
                                $('.notices-wrapper .fullpagecache-image-loader').hide();
                            }
                        });
                        if (type === 'reindex' && typeof gridIndexerJsObject !== 'undefined') {
                            window.gridIndexerJsObject.useAjax = true;
                            window.gridIndexerJsObject.url     = self.options.reindexListUrl;
                            window.gridIndexerJsObject.reload();
                        }
                        if (type === 'cache' && typeof cache_gridJsObject !== 'undefined') {
                            window.cache_gridJsObject.useAjax = true;
                            window.cache_gridJsObject.url     = self.options.flushCacheIndexUrl;
                            window.cache_gridJsObject.reload();
                        }
                    }
                },
                error: function (e) {
                    $(self.errorMessageHtml(e.responseText)).insertBefore($('.page-columns'));
                }
            });
        },

        /** Get error message in html */
        errorMessageHtml: function (messageText) {
            return '<div class="messages">' +
                '<div class="message message-error error">' +
                '<div data-ui-id="magento-framework-view-element-messages-0-message-error">' +
                messageText +
                '</div>' +
                '</div>' +
                '</div>';
        },

        /** Update ui system message */
        updateGrid: function () {
            var target = registry.get('notification_area.notification_area_data_source');

            if (target && typeof target === 'object') {
                target.reload({refresh: 1});
            }

            return target;
        }
    });

    return $.creensight.fullPageCacheAjax;
});