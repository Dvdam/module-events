/**
 * @api
 */
define([
    'jquery',
    'domReady!'
], function($) {
    "use strict";

    let self;

    return {

        buildNewEvent: function (newEvent) {
            return  {
                id: newEvent.event_id,
                title: newEvent.event_title,
                allDay: false,
                overlap: false,
                start: newEvent.event_start,
                end: newEvent.event_end,
                color: newEvent.event_type,
                textColor: newEvent.event_type,
                display: 'block'
            };
        },

        buildFormObject: function(formTitle, formContent, formColor) {
            return {
                title: formTitle,
                content: formContent,
                label_type: formColor
            }
        },

        getTypeValue: function(typeElements) {
            let typeSelect;
            for (let i = 0; i < typeElements.length; i++) {
                if (typeElements[i].checked)
                    typeSelect = typeElements[i].value;
            }
            return typeSelect;
        },

        buildStringEndHourToDate: function(hour) {
            self = this;

            let hourEndBuild;
            let intHour = self.buildIntEndHourToDate(hour);
            console.log(intHour);

            if (intHour === 24) {
                hourEndBuild = '00';
            } else {
                hourEndBuild = intHour.toString()
            }

            return hourEndBuild;
        },

        buildIntEndHourToDate: function(hour) {
            return parseInt(hour) + 1;
        },
    };
});
