const colors = [
    'rgb(255, 99, 132)',
    'rgb(54, 162, 235)',
    'rgb(153, 102, 255)',
    'rgb(255, 159, 64)',
    'rgb(255, 205, 86)',
    'rgb(75, 192, 192)',
    'rgb(201, 203, 207)'
];

function legendOnClick(e, legendItem, chart) {
    const index = legendItem.datasetIndex;
    var meta = chart.getDatasetMeta(index);
    meta.hidden = meta.hidden === null ? !chart.data.datasets[index].hidden : null;
    const display = chart.options.scales.yAxes[index].display ? false : true;
    chart.options.scales.yAxes[index].display = display;
    chart.update();
}

function customLegend(chart) {
}

export function drawChart(content, canvasId, animation = true) {
    if(!content.data) {
        return;
    }
    var chart = {}
    const data = content.data;
    const numberOfDatasets = data[0].length - 1;
    const xTitle = data[0][0];
    let yTitles = [];
    let labels = [];
    let values = [];
    let datasets = [];
    let yAxes = [];

    for(var i = 0; i < numberOfDatasets; i++) {
        const label = data[0][i+1];
        yTitles.push(label);
        values[label] = [];
    }

    for(var i = 1; i < data.length; i++) {
        labels.push(data[i][0]);
        for(var j = 0; j < numberOfDatasets; j++) {
            values[yTitles[j]].push(data[i][j+1]);
        }
    }

    for(var i = 0; i < numberOfDatasets; i++) {
        datasets.push({
            data: values[yTitles[i]],
            yAxisID: 'y-axis-' + i,
            label: yTitles[i],
            borderColor: colors[i],
            fill: false,
            hidden: true
        });

        datasets[0].hidden = false;

        yAxes.push({
            display: false,
            scaleLabel: {
                display: true,
                labelString: yTitles[i],
                fontColor: colors[i]
            },
            id: 'y-axis-' + i,
            ticks: {
                min: 0,
                fontColor: colors[i]
            }
        });

        yAxes[0].display = true;
    }

    const ctx = document.getElementById(canvasId).getContext('2d');
    chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            animation: animation,
            events: ['click'],
            title: {
                display: false,
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: xTitle
                    }
                }],
                yAxes: yAxes
            },
            legend: {
                onClick: function(e, legendItem) {
                    legendOnClick(e, legendItem, chart);
                },
                labels: {
                    fontSize: 13,
                    fontColor: '#000',
                    fontFamily: "'Roboto', sans-serif"
                }
            }
        }
    });

    return chart;
}
