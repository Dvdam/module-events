/**
 * @api
 */
define([
    'jquery',
], function ($) {
    'use strict';

    return {

        /**
         * @param {String} url
         * @param {Object} params
         * @param {String|Boolean} method
         * @returns {Promise} Promise
         */
        sendRequestService: async function(url, params, method = false) {
            try {
                let methodToCall = 'POST'
                if (method) {
                    methodToCall = 'GET';
                }

                return await $.ajax({
                    async: true,
                    method: methodToCall,
                    url,
                    data: params
                });
            } catch (error) {
                throw error;
            } finally {
                console.log('From Error Finally ');
            }
        },

        /**
         * @param {String} fetchUrl
         */
        fetchEvents: function (fetchUrl) {
            return $.ajax({
                type: 'GET',
                url: fetchUrl,
                contentType: 'application/json',
                dataType: 'json',
                data: {
                    isAjax: true,
                    requestType: 'getEvents'
                },
                showLoader: false,
                async: false,
                headers: {},
            });
        },
    };
});
