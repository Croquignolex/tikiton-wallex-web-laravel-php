$(function () {
    'use strict';
    //Widgets
    if($('#weekly-widget')) {
        $('#weekly-widget').sparkline([9,5,7,6,7,6,5,8,3,4,9,5], {
            type: 'bar', height: 30, barWidth: 3, barColor: '#F44336', barSpacing: 2
        });
    }
    if($('#daily-widget')) {
        $('#daily-widget').sparkline([4,6,8,9,5,9,4,5,2,7,9,5], {
            type: 'bar', height: 30, barWidth: 3, barColor: '#F44336', barSpacing: 2
        });
    }
    if($('#monthly-widget')) {
        $('#monthly-widget').sparkline([8,6,8,6,5,6,7,8,9,7,4,5], {
            type: 'bar', height: 30, barWidth: 3, barColor: '#F44336', barSpacing: 2
        });
    }
    if($('#yearly-widget')) {
        $('#yearly-widget').sparkline([5,8,7,9,5,9,5,7,5,7,9,4], {
            type: 'bar', height: 30, barWidth: 3, barColor: '#F44336', barSpacing: 2
        });
    }
});

let currentDayChartRoute = '/dashboard/expenses/current/day';
let currentWeekChartRoute = '/dashboard/expenses/current/week';
let currentMonthChartRoute = '/dashboard/expenses/current/month';
let currentYearChartRoute = '/dashboard/expenses/current/year';
let currentWeekDaysChartRoute = '/dashboard/expenses/current/year/months';
let currentYearMonthsChartRoute = '/dashboard/expenses/current/week/days';