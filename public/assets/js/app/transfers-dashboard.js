$(function () {
    'use strict';
    //Widgets
    if($('#weekly-widget')) {
        $('#weekly-widget').sparkline([7,5,8,6,9,6,4,8,9,5,9,5], {
            type: 'bar', height: 30, barWidth: 3, barColor: '#2196F3', barSpacing: 2
        });
    }
    if($('#daily-widget')) {
        $('#daily-widget').sparkline([4,7,8,6,8,7,5,9,7,6,9,5], {
            type: 'bar', height: 30, barWidth: 3, barColor: '#2196F3', barSpacing: 2
        });
    }
    if($('#monthly-widget')) {
        $('#monthly-widget').sparkline([3,4,8,5,9,6,4,8,7,5,9,4], {
            type: 'bar', height: 30, barWidth: 3, barColor: '#2196F3', barSpacing: 2
        });
    }
    if($('#yearly-widget')) {
        $('#yearly-widget').sparkline([9,6,7,5,5,9,7,8,3,7,9,4], {
            type: 'bar', height: 30, barWidth: 3, barColor: '#2196F3', barSpacing: 2
        });
    }
});

let currentDayChartRoute = '/dashboard/transfers/current/day';
let currentWeekChartRoute = '/dashboard/transfers/current/week';
let currentMonthChartRoute = '/dashboard/transfers/current/month';
let currentYearChartRoute = '/dashboard/transfers/current/year';
let currentWeekDaysChartRoute = '/dashboard/transfers/current/year/months';
let currentYearMonthsChartRoute = '/dashboard/transfers/current/week/days';