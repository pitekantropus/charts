const colors = [
    'rgb(255, 99, 132)',
'rgb(255, 159, 64)',
'rgb(255, 205, 86)',
'rgb(75, 192, 192)',
'rgb(54, 162, 235)',
'rgb(153, 102, 255)',
'rgb(201, 203, 207)'];

var chart = {}

function drawChart(content) {
    let labels = [];
    let values = [];
    let xLabel = '';
    let yLabels = [];

    const data = content.data;
    const numberOfDatasets = data[0].length - 1;
    for(i = 0; i < numberOfDatasets; i++) {
        label = data[0][i+1];
        yLabels.push(label);
        values[label] = [];
    }
    xLabel = data[0][0];
    for(i = 1; i < data.length; i++) {
        labels.push(data[i][0]);
        for(j = 0; j < numberOfDatasets; j++) {
            values[yLabels[j]].push(data[i][j+1]);
        }
    }

    datasets = []
    for(i = 0; i < numberOfDatasets; i++) {
        datasets.push({
            data: values[yLabels[i]],
            yAxisID: 'y-axis-' + i,
            label: yLabels[i],
            borderColor: colors[i],
            fill: false
        });
    }

    var ctx = document.getElementById('chart-canvas').getContext('2d');
    chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            title: {
                display: true,
                text: 'Rak w USA'
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Rok'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Rate'
                    },
                    id: 'y-axis-0',
                    ticks: {
                        min: 0
                    }
                }, {
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Liczba zachorowań'
                    },
                    id: 'y-axis-1',
                    ticks: {
                        min: 0
                    }
                }, {
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Populacja'
                    },
                    id: 'y-axis-2',
                    ticks: {
                        min: 0
                    }
                }]
            }
        }
    });
}

$(function() {
    if($('#chart-container').length == 0) {
        return;
    }
    const chartId = $("body").data("id");
    Papa.parse('/data/' + chartId + '/data.csv', {
        download: true,
        complete: function(results) {
            drawChart(results);
        }
    });
});
