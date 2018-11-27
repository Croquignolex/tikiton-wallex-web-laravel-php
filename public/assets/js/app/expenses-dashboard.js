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

let dailyChartRoute = '/dashboard/expenses/daily/fill';
let weeklyChartRoute = '/dashboard/expenses/weekly/fill';
let monthlyChartRoute = '/dashboard/expenses/monthly/fill';
let yearlyChartRoute = '/dashboard/expenses/yearly/fill';
let daysChartRoute = '/dashboard/expenses/days/fill';
let monthsChartRoute = '/dashboard/expenses/months/fill';