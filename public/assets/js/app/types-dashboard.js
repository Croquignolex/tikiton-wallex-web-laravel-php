new Vue({
    el: '#chart-refresh',
    data: {},
    methods: {
        current_day_refresh: function () { loadCurrentDayChart(); },
        current_week_refresh: function () { loadCurrentWeekChart(); },
        current_month_refresh: function () { loadCurrentMonthChart(); },
        current_year_refresh: function () { loadCurrentYearChart(); },
        current_week_days_refresh: function () { loadCurrentWeekDaysChart(); },
        current_year_months_refresh: function () { loadCurrentYearMonthsChart(); }
    }
});

loadCurrentDayChart(); loadCurrentWeekChart(); loadCurrentMonthChart();
loadCurrentYearChart(); loadCurrentWeekDaysChart(); loadCurrentYearMonthsChart();

function loadCurrentDayChart() { pieChart(currentDayChartRoute, '#current-day-loader', '#current-day-chart'); }
function loadCurrentWeekChart() { pieChart(currentWeekChartRoute, '#current-week-loader', '#current-week-chart'); }
function loadCurrentMonthChart() { pieChart(currentMonthChartRoute, '#current-month-loader', '#current-month-chart'); }
function loadCurrentYearChart() { pieChart(currentYearChartRoute, '#current-year-loader', '#current-year-chart'); }
function loadCurrentWeekDaysChart() { lineChart(currentWeekDaysChartRoute, '#current-week-days-loader', '#current-week-days-chart'); }
function loadCurrentYearMonthsChart() { lineChart(currentYearMonthsChartRoute, '#current-year-months-loader', '#current-year-months-chart'); }
