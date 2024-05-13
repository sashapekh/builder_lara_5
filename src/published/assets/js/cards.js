"use strict";

var Cards =
    {
        init: function()
        {
            Cards.rangeChange();

            $(".datepicker_trend").datepicker({
                changeMonth: true,
                numberOfMonths: 1,
                prevText: '<i class="fa fa-chevron-left"></i>',
                nextText: '<i class="fa fa-chevron-right"></i>',
                dateFormat: "yy-mm-dd",
                //showButtonPanel: true,
                regional: ["ru"],
                onClose: function (selectedDate) {}
            });

            $('.datepicker_trend').change(function () {
                var contentTrend = $(this).parents('article');
                Cards.loadChart(contentTrend);
            });


            $('.trends').each(function( index ) {
                var contentTrend = $(this).parents('article');
                Cards.loadChart(contentTrend);
            });
        },

        rangeChange : function () {
            $('[name=range]').change(function () {

                var data = {
                    'model': $(this).attr('data-model'),
                    'range' :  $(this).val(),
                };

                var cardId = $('#' + $(this).attr('data-card-id'));

                var $posting = jQuery.post('/admin/change-range-card', data);

                $posting.done(function (response) {
                    cardId.find('.value_current').html(response.current);
                    cardId.find('.value_difference').html(response.difference);
                });
            });
        },

        loadChart : function (contentTrend)
        {
            var data = {
                'from' : contentTrend.find('[name=trend_from]').val(),
                'to' : contentTrend.find('[name=trend_to]').val(),
                'model' : contentTrend.find('[name=trend_model]').val(),
            }

            var $posting = jQuery.post('/admin/change-range-trend', data);

            $posting.done(function (response) {

                var data = {
                    "xScale": "time",
                    "yScale": "linear",
                    "main": [{
                        className: ".stats",
                        "data": response
                    }]
                };

                var opts = {
                    paddingLeft: 25,
                    paddingTop: 10,
                    paddingRight: 15,
                    axisPaddingLeft: 25,
                    //tickHintX: 4, // How many ticks to show horizontally
                    tickHintY: 6,
                    dataFormatX: function (x) {
                        return Date.create(x);
                    },

                    tickFormatX: function (x) {
                        return x.format('{dd}/{MM}');
                    },

                    "mouseover": function (d, i) {

                    },

                    "mouseout": function (x) {

                    }
                };

                var chartTrend = contentTrend.find('.trends').attr('id');

                new xChart('line-dotted', data, '#' + chartTrend, opts);
            });
        }

};
Cards.init();
