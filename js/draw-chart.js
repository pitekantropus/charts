import { drawChart } from './chart-utils.js?v=3';

$(function() {
    if($('#chart-container').length == 0) {
        return;
    }
    const chartId = $("body").data("id");
    const title = $("#title").text();
    Papa.parse('/data/' + chartId + '/data.csv', {
        download: true,
        complete: function(results) {
            drawChart(results, 'chart-canvas', title);
        }
    });
});
