import { drawChart } from './chart-utils.js';

$(function() {
    if($('#chart-container').length == 0) {
        return;
    }
    const chartId = $("body").data("id");
    Papa.parse('/data/' + chartId + '/data.csv', {
        download: true,
        complete: function(results) {
            drawChart(results, 'chart-canvas');
        }
    });
});
