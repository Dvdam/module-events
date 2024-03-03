/**
 * @api
 */

/*global FullCalendar*/
/*global define*/
define([
    'jquery',
    'mage/url',
    'mage/translate',
    'Dvdam_Events/js/lib/sweetalert2.all.min',
    'Dvdam_Events/js/lib/moment.min',
    'Dvdam_Events/js/model/build-event',
    'Dvdam_Events/js/action/ajaxs',
    'Dvdam_Events/js/form/add-event',
    'Dvdam_Events/js/locales/es.global',
    'mage/validation',
    'jquery-ui-modules/widget',
    'domReady!'
], function($, urlBuilder, $t, Swal, moment, buildEvent, serviceAjax, addEventForm) {
    "use strict";

    let self, allEvents, calendar, formKey;

    $.widget('mage.dvdam_events', {
        options: {
            baseUrl: 'full-calendar',
            ajaxUrl: '/ajax/',
            eventsId: '#events',
            bodyClass: '.dvdamevents-index-index',
            calendarEl: document.getElementById('calendar'),
            direction: 'ltr',
            locale: 'es',
            startTime: '16:00:00',
            endTime: '23:00:00',
        },

        _create: function() {
            self = this;
            allEvents = self.fetchEvents();
            calendar = self.handleCalendar(allEvents);
        },

        _init: function () {
            this._super();
            calendar.render();
        },

        handleCalendar: function(calendarEvents) {
            self = this;
            console.log(new Date());
            return new FullCalendar.Calendar(self.options.calendarEl, {
                initialView: 'timeGridWeek',
                nowIndicator: true,
                allDaySlot: false,
                scrollTime: false,
                slotMinTime: self.options.startTime,
                slotMaxTime: self.options.endTime,
                expandRows: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay'
                },
                navLinks: true,
                editable: true,
                selectable: true,
                selectMirror: true,
                dayMaxEvents: 7,
                events: calendarEvents,
                direction: self.options.direction,
                locale: self.options.locale,
                hiddenDays: [ 0, 6 ],
                businessHours: {
                    startTime: self.options.startTime,
                    endTime: self.options.endTime,
                    daysOfWeek: [ 1, 2, 3, 4, 5 ]
                },
                eventClassNames: function ({ event: calendarEvent }) {
                    let colorName = calendarEvent._def.ui.textColor;
                    return ['fc-event-' + colorName];
                },
                validRange: function (nowDate) {
                    return {
                        start: nowDate
                    };
                },
                dateClick: function (info) {
                    self.handleSelectEvent(info);
                },
                eventClick: function (info) {
                    self.handleEventClick(info);
                },
                loading: function(bool) {
                    self.handleLoading(bool);
                },
            });
        },

        handleSelectEvent: function(info) {
            self = this;
            let dateByMoment = moment(info.dateStr);
            let date = new Date(),
                d = parseInt(String(date.getDate()).padStart(2, '0'), 10),
                m = parseInt(String(date.getMonth() + 1).padStart(2, '0'), 10),
                minutes = String(date.getMinutes()).padStart(2, '0'),
                dateCurrent = dateByMoment.format('YYYY-MM-DD'),
                currentStartDate = dateCurrent + ' ' + dateByMoment.hour() + ':' + (minutes !== '00' ? '00' : minutes) + ':' + '00',
                currentEndDate = dateCurrent + ' ' + buildEvent.buildStringEndHourToDate(dateByMoment.hour()) + ':' + '00' + ':' + '00',
                daySelect = dateByMoment.format('YYYY-MM-DD'),
                daySelectDay = dateByMoment.date(),
                daySelectMonth = dateByMoment.month() + 1,
                eventSameTime = self.isAnOverlapEvent(currentStartDate, currentEndDate);

            console.log(eventSameTime);

            if (daySelectDay >= d && daySelectMonth >= m) {
                (async () => {
                    await self.handleCreateEvent(currentStartDate, currentEndDate);
                 })()
            } else {
                console.log('Not allowed to work');
            }
        },

        refreshCalendar: function() {
            allEvents = self.fetchEvents();
            calendar = self.handleCalendar(allEvents);
            calendar.render();
        },

        handleEventClick: function (arg) {
            if (arg.event.id) {
                arg.jsEvent.preventDefault();
                Swal.fire('You can not Edit this Event!', '', 'warning');
            }
        },

        addEvent: function(eventData) {
            self = this;
            allEvents.push(eventData);
            calendar.refetchEvents();
            setTimeout(function() {
                self.refreshCalendar();
            }, 500);
        },

        fetchEvents: function() {
            self = this;
            formKey = self.options.events;
            console.log(formKey);
            const url = `${self.buildUrlSend('events', true)}?form_key=${formKey}`;
            let selectedEvents = serviceAjax.fetchEvents(url);
            if (selectedEvents.responseJSON.status) {
                return selectedEvents.responseJSON.events;
            } else {
                return [];
            }
        },

        handleCreateEvent: async function(currentStartDate, currentEndDate) {
            let process;
            const { value: formValues } = await Swal.fire({
                title: $t('Add Event'),
                confirmButtonText: $t('Add'),
                showCloseButton: true,
                showCancelButton: true,
                html: addEventForm.buildHtml(),
                focusConfirm: false,
                customClass: {
                    container: 'm2fc-container',
                    popup: 'm2fc-popup',
                    closeButton: 'm2fc-close-btn',
                    htmlContainer: 'm2fc-html-container',
                    actions: 'm2fc-actions',
                    confirmButton: "m2fc-confirm-btn",
                    cancelButton: "m2fc-cancel-btn"
                },
                buttonsStyling: false,
                preConfirm: () => {
                    return buildEvent.buildFormObject(document.getElementById('title').value, document.getElementById('desc').value, buildEvent.getTypeValue(document.getElementsByName('labelType')))
                }
            });

            if (formValues) {
                const eventData = {
                    request_type:'addEvent',
                    start: currentStartDate,
                    end: currentEndDate,
                    display: 'block'
                };

                const sendData = Object.assign({}, formValues, eventData);
                // send data --- START
                $(self.options.bodyClass).trigger('processStart');
                process = await serviceAjax.sendRequestService(self.buildUrlSend('create', true), sendData);
                $(self.options.bodyClass).trigger('processStop');
                if (process.status) {
                    let newEvent = buildEvent.buildNewEvent(process);
                    self.addEvent(newEvent);
                    Swal.fire('Event added successfully!', '', 'success');
                } else {
                    Swal.fire(process.error, '', 'error');
                }
            }
        },

        buildUrlSend: function(url, isAjax = false) {
            self = this;
            if (isAjax) {
                return urlBuilder.build(self.options.baseUrl + self.options.ajaxUrl + url)
            } else {
                return urlBuilder.build(self.options.baseUrl + '/' + url)
            }
        },

        getBaseUrl: function() {
            return urlBuilder.build(self.options.baseUrl)
        },

        handleLoading: function (bool) {
            self = this;
            document.getElementById('loading').style.display = bool ? 'block' : 'none';
            $(self.options.bodyClass).trigger('processStop');
        },

        isAnOverlapEvent: function(eventStartDay, eventEndDay) {
            // Events
            let events = allEvents;
    
            for (let i = 0; i < events.length; i++) {
                const eventA = events[i];
    
                if (moment(eventStartDay).isAfter(eventA.start) && moment(eventStartDay).isBefore(eventA.end)) {
                    return true;
                }

                if (moment(eventEndDay).isAfter(eventA.start) && moment(eventEndDay).isBefore(eventA.end)) {
                    return true;
                }
                if (moment(eventStartDay).isSameOrBefore(eventA.start) && moment(eventEndDay).isSameOrAfter(eventA.end)) {
                    return true;
                }
            }
            return false;
        },
    });
    return $.mage.dvdam_events;
});
