/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'uiComponent',
    'ko'
], function ($, Component, ko) {
    'use strict';

    return Component.extend({
        /** @inheritdoc */
        initialize: function () {
            this._super();

            this.customerStatus = ko.observable();
            this.getStatus();
        },

        getStatus: function () {
            $.ajax({
                url: '/custom_customer/status/get',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    if(data.status) {
                        this.customerStatus(data.status);
                    }
                }.bind(this)
            });
        }
    });
});
