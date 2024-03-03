/**
 * @api
 */
/*global define*/
define([
    'jquery',
    'mage/translate',
], function ($, $t) {
    'use strict';

    const data = {
        titlePlaceHolder: $t('Enter title'),
        titleLabel: $t('Title'),
        contentPlaceHolder: $t('Enter description'),
        contentLabel: $t('Description'),
        personalTitle: $t('Personal'),
        businessTitle: $t('Business'),
        familyTitle: $t('Family'),
        holidayTitle: $t('Holiday'),
        freeTitle: $t('Free')
    }

    return {

        /**
         * Build custom form html to use in popup
         *
         * @returns {String}
         */
        buildHtml: function() {
            return `<form>
                <div class="content-swal">
                    <div class="form-group">
                        <input id="title" name="title" class="swal2-input" placeholder="${data.titlePlaceHolder}" type="text" required/>
                        <label for="title" class="label">${data.titleLabel}</label>
                    </div>

                    <div class="form-group">
                        <textarea id="desc" name="desc" class="swal2-input" placeholder="${data.contentPlaceHolder}" rows="2"></textarea>
                        <label for="desc" class="label">${data.contentLabel}</label>
                    </div>

                    <div class="color-group">
                        <input type="radio" name="labelType" id="personal" value="personal" checked>
                        <label for="personal" class="personal" title="${data.personalTitle}">
                            <span class="personal"></span>
                        </label>

                        <input type="radio" name="labelType" id="business" value="business">
                        <label for="business" class="business" title="${data.businessTitle}"><span class="business"></span></label>

                        <input type="radio" name="labelType" id="family" value="family">
                        <label for="family" class="family" title="${data.familyTitle}">
                            <span class="family"></span>
                        </label>

                        <input type="radio" name="labelType" id="holiday" value="holiday">
                        <label for="holiday" class="holiday" title="${data.holidayTitle}">
                            <span class="holiday"></span>
                        </label>

                        <input type="radio" name="labelType" id="free" value="free">
                        <label for="free" class="free">
                            <span class="free" title="${data.freeTitle}"></span>
                        </label>
                    </div>
                </div>
            </form>`
        }
    };
});
