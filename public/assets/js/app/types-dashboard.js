new Vue({
    el: '#chart-refresh',
    data: {},
    methods: {
        daily_refresh: function () { loadDailyChart(); },
        weekly_refresh: function () { loadWeeklyChart(); },
        monthly_refresh: function () { loadMonthlyChart(); },
        yearly_refresh: function () { loadYearlyChart(); },
        days_refresh: function () { loadDaysChart(); },
        months_refresh: function () { loadMonthsChart(); }
    }
});

loadDailyChart(); loadWeeklyChart(); loadMonthlyChart();
loadYearlyChart(); loadDaysChart(); loadMonthsChart();

function loadDailyChart() { pieChart(dailyChartRoute, '#daily-loader', '#daily-chart'); }
function loadWeeklyChart() { pieChart(weeklyChartRoute, '#weekly-loader', '#weekly-chart'); }
function loadMonthlyChart() { pieChart(monthlyChartRoute, '#monthly-loader', '#monthly-chart'); }
function loadYearlyChart() { pieChart(yearlyChartRoute, '#yearly-loader', '#yearly-chart'); }
function loadDaysChart() { lineChart(daysChartRoute, '#days-loader', '#days-chart'); }
function loadMonthsChart() { lineChart(monthsChartRoute, '#months-loader', '#months-chart'); }
