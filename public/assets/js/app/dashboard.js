function pieChart(route, loaderID, chartID) { roundChart(route, loaderID, chartID, 'pie'); }
// function doughnutChart(route, loaderID, chartID) { roundChart(route, loaderID, chartID, 'doughnut'); }
function polarChart(route, loaderID, chartID) { roundChart(route, loaderID, chartID, 'polar'); }
function lineChart(route, loaderID, chartID) { inlineChart(route, loaderID, chartID, 'line'); }
function barChart(route, loaderID, chartID) { inlineChart(route, loaderID, chartID, 'bar'); }

function roundChart(route, loaderID, chartID, chartType)
{
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    $.ajax({
        method: 'GET', url: route, dataType: "json",  
        beforeSend: function () { 
            $(loaderID).css('display', 'block'); $(chartID).css('display', 'none');
        }
    })
    .done(function(response) {
        $(loaderID).css('display', 'none'); $(chartID).remove();
        let chartArea = document.createElement('canvas');
        chartArea.setAttribute('id', chartID.substring(1, chartID.length));
        chartArea.setAttribute('class', 'chart-canvas');

        let data = []; let labels = [];
        let backgroundColors = []; let borderColors = []; let hoverBackgroundColors = [];

        if(response.chartData.length > 0)
        {
            response.chartData.forEach(function (chart) {
                let color = chart.color; labels.push(chart.name);
                backgroundColors.push(hexadecimalToRGBa(color, 0.5));
                borderColors.push(hexadecimalToRGBa(color));
                hoverBackgroundColors.push(hexadecimalToRGBa(color, 0.9));
                data.push(chart.data);
            });
        }
        else
        {
            let color = '#c257b8'; labels.push('No data');
            backgroundColors.push(hexadecimalToRGBa(color, 0.5));
            borderColors.push(hexadecimalToRGBa(color));
            hoverBackgroundColors.push(hexadecimalToRGBa(color, 0.9));
            data.push(0);
        }

        let chartData = {
            labels: labels,
            datasets: [{
                data: data, backgroundColor: backgroundColors,
                borderColor: borderColors, hoverBackgroundColor: hoverBackgroundColors,
            }]
        };

        let options = {
            responsive: true, animation: { animateScale: true, animateRotate: true}
        };

        $(loaderID).get(0).parentElement.appendChild(chartArea);
        let chartCanvas = $(chartID).get(0).getContext("2d");
        if(chartType === 'polar') Chart.PolarArea(chartCanvas, { data: chartData, options: options });
        else new Chart(chartCanvas, { type: chartType, data: chartData, options: options });

    })
    .fail(function() { console.warn('Request failed'); });
}

function inlineChart(route, loaderID, chartID, chartType)
{
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    $.ajax({
        method: 'GET', url: route, dataType: "json", 
        beforeSend: function () { 
            $(loaderID).css('display', 'block'); $(chartID).css('display', 'none');
        }
    })
    .done(function(response) {
        $(loaderID).css('display', 'none'); $(chartID).remove();
        let chartArea = document.createElement('canvas');
        chartArea.setAttribute('id', chartID.substring(1, chartID.length));
        chartArea.setAttribute('class', 'chart-canvas');

        let dataSets = []; let labels = [];

        if(response.chartData.length > 0)
        {
            response.chartData.forEach(function (chart) {
                let dataSetData = [];
                chart.data.forEach(function (data) {
                    dataSetData.push(data.amount);
                });
                let color = chart.color;
                dataSets.push({
                    label: chart.name, data: dataSetData,
                    backgroundColor: hexadecimalToRGBa(color, 0.5),
                    borderColor: hexadecimalToRGBa(color),
                    hoverBackgroundColor: hexadecimalToRGBa(color, 0.9),
                    borderWidth: 1
                });
            });

            response.chartData[0].data.forEach(function (data) {
                labels.push(data.label);
            });
        }
        else
        {
            let dataSetData = [];
            dataSetData.push(0);
            let color = '#c257b8';
            dataSets.push({
                label: 'No data', data: dataSetData,
                backgroundColor: hexadecimalToRGBa(color, 0.5),
                borderColor: hexadecimalToRGBa(color),
                hoverBackgroundColor: hexadecimalToRGBa(color, 0.9),
                borderWidth: 1
            });

            labels.push('No data');
        }

        let chartData = { labels: labels, datasets: dataSets };

        let options = {
            scales: {
                yAxes: [{
                    ticks: { beginAtZero: true, },
                    scaleLabel: { display: true, labelString: response.yLabel }}],
                xAxes: [{
                    ticks: { beginAtZero: true, },
                    scaleLabel: { display: true, labelString: response.xLabel } }]
            },
            responsive: true, legend: { display: true },
            elements: { point: { radius: 0 } },
            tooltips: { mode: 'index', intersect: false },
            hover: { mode: 'nearest', intersect: true}
        };

        $(loaderID).get(0).parentElement.appendChild(chartArea);
        let chartCanvas = $(chartID).get(0).getContext("2d");
        new Chart(chartCanvas, { type: chartType, data: chartData, options: options });
    })
    .fail(function() { console.warn('Request failed'); });
}