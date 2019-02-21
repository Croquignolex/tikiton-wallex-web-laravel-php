new Vue({
    el: '#chart-refresh',
    data: {},
    methods: {
        accounts_balance_refresh: function () { loadAccountsBalanceChart(); },
        current_day_category_refresh: function () { loadCurrentDayCategoriesChart(); },
        current_week_category_refresh: function () { loadCurrentWeekCategoriesChart(); },
        current_month_category_refresh: function () { loadCurrentMonthCategoriesChart(); },
        current_year_category_refresh: function () { loadCurrentYearCategoriesChart(); },
        current_week_days_category_refresh: function () { loadCurrentWeekDaysCategoriesChart(); },
        current_year_months_category_refresh: function () { loadCurrentYearMonthsCategoriesChart(); },
    }
});

loadAccountsBalanceChart(); loadCurrentDayCategoriesChart();
loadCurrentWeekCategoriesChart(); loadCurrentMonthCategoriesChart(); loadCurrentYearCategoriesChart();
loadCurrentYearMonthsCategoriesChart(); loadCurrentWeekDaysCategoriesChart();

function loadAccountsBalanceChart() { barChart('/dashboard/general/accounts/balance', '#accounts-balance-loader', '#accounts-balance-chart'); }
function loadCurrentDayCategoriesChart() { polarChart('/dashboard/general/categories/current/day', '#current-day-category-loader', '#current-day-category-chart'); }
function loadCurrentWeekCategoriesChart() { polarChart('/dashboard/general/categories/current/week', '#current-week-category-loader', '#current-week-category-chart'); }
function loadCurrentMonthCategoriesChart() { polarChart('/dashboard/general/categories/current/month', '#current-month-category-loader', '#current-month-category-chart'); }
function loadCurrentYearCategoriesChart() { polarChart('/dashboard/general/categories/current/year', '#current-year-category-loader', '#current-year-category-chart'); }
function loadCurrentWeekDaysCategoriesChart() { lineChart('/dashboard/general/categories/current/week/days', '#current-week-days-category-loader', '#current-week-days-category-chart'); }
function loadCurrentYearMonthsCategoriesChart() { lineChart('/dashboard/general/categories/current/year/months', '#current-year-months-category-loader', '#current-year-months-category-chart'); }

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