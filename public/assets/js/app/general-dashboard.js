new Vue({
    el: '#chart-refresh',
    data: {},
    methods: {
        accounts_refresh: function () { loadAccountsBalanceChart(); },
        daily_category_refresh: function () { loadDailyCategoriesChart(); },
        weekly_category_refresh: function () { loadWeeklyCategoriesChart(); },
        monthly_category_refresh: function () { loadMonthlyCategoriesChart(); },
        yearly_category_refresh: function () { loadYearlyCategoriesChart(); },
        days_category_refresh: function () { loadDaysCategoriesChart(); },
        months_category_refresh: function () { loadMonthsCategoriesChart(); },
    }
});

loadAccountsBalanceChart(); loadDailyCategoriesChart();
loadWeeklyCategoriesChart(); loadMonthlyCategoriesChart(); loadYearlyCategoriesChart();
loadDaysCategoriesChart(); loadMonthsCategoriesChart();

function loadAccountsBalanceChart() { barChart('/dashboard/general/accounts/fill', '#accounts-loader', '#accounts-chart'); }
function loadDailyCategoriesChart() { polarChart('/dashboard/general/categories/daily/fill', '#daily-category-loader', '#daily-category-chart'); }
function loadWeeklyCategoriesChart() { polarChart('/dashboard/general/categories/weekly/fill', '#weekly-category-loader', '#weekly-category-chart'); }
function loadMonthlyCategoriesChart() { polarChart('/dashboard/general/categories/monthly/fill', '#monthly-category-loader', '#monthly-category-chart'); }
function loadYearlyCategoriesChart() { polarChart('/dashboard/general/categories/yearly/fill', '#yearly-category-loader', '#yearly-category-chart'); }
function loadDaysCategoriesChart() { lineChart('/dashboard/general/categories/days/fill', '#days-category-loader', '#days-category-chart'); }
function loadMonthsCategoriesChart() { lineChart('/dashboard/general/categories/months/fill', '#months-category-loader', '#months-category-chart'); }

$(function () {
    //Widgets
    if($('#accounts-balance-widget')) {
        $('#accounts-balance-widget').sparkline([9,4,8,6,5,6,4,8,3,5,9,5], {
            type: 'bar', height: 30, barWidth: 3, barColor: '#7eca48', barSpacing: 2
        });
    }
    if($('#accounts-widget')) {
        $('#accounts-widget').sparkline([9,7,5,6,5,4,9,8,5,8,7,5], {
            type: 'bar', height: 30, barWidth: 3, barColor: '#7eca48', barSpacing: 2
        });
    }
    if($('#categories-widget')) {
        $('#categories-widget').sparkline([6,5,7,6,8,9,5,8,7,5,9,4], {
            type: 'bar', height: 30, barWidth: 3, barColor: '#7eca48', barSpacing: 2
        });
    }
});