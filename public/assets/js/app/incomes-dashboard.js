$(function () {
    'use strict';
    //Widgets
    if($('#weekly-widget')) {
        $('#weekly-widget').sparkline([9,4,8,6,5,6,4,8,3,5,9,5], {
            type: 'bar', eight: 30, barWidth: 3, barColor: '#00c292', barSpacing: 2
        });
    }
    if($('#daily-widget')) {
        $('#daily-widget').sparkline([2,4,8,9,5,7,4,5,2,3,9,5], {
            type: 'bar', height: 30, barWidth: 3, barColor: '#00c292', barSpacing: 2
        });
    }
    if($('#monthly-widget')) {
        $('#monthly-widget').sparkline([1,4,8,3,5,6,4,8,3,3,9,5], {
            type: 'bar', height: 30, barWidth: 3, barColor: '#00c292', barSpacing: 2
        });
    }
    if($('#yearly-widget')) {
        $('#yearly-widget').sparkline([5,2,7,4,5,9,3,8,3,7,9,3], {
            type: 'bar', height: 30, barWidth: 3, barColor: '#00c292', barSpacing: 2
        });
    }
});

let dailyChartRoute = '/dashboard/incomes/daily/fill';
let weeklyChartRoute = '/dashboard/incomes/weekly/fill';
let monthlyChartRoute = '/dashboard/incomes/monthly/fill';
let yearlyChartRoute = '/dashboard/incomes/yearly/fill';
let daysChartRoute = '/dashboard/incomes/days/fill';
let monthsChartRoute = '/dashboard/incomes/months/fill';