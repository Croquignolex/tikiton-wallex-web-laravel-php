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

let dailyChartRoute = '/dashboard/transfers/daily/fill';
let weeklyChartRoute = '/dashboard/transfers/weekly/fill';
let monthlyChartRoute = '/dashboard/transfers/monthly/fill';
let yearlyChartRoute = '/dashboard/transfers/yearly/fill';
let daysChartRoute = '/dashboard/transfers/days/fill';
let monthsChartRoute = '/dashboard/transfers/months/fill';