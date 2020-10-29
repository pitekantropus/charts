import { drawChart } from './chart-utils.js';

function handleChartType() {
    const type = $(this).val();
    let buttonText = '';
    let acceptedTypes = '';
    if(type == 'IMAGE') {
        buttonText = 'Dodaj gotowy wykres';
        acceptedTypes = 'image/*';
    } else if(type == 'DATA') {
        buttonText = 'Dodaj plik csv';
        acceptedTypes = 'text/csv';
    }
    $("#chart-file-label").text(buttonText);
    $("#chart-file-button").attr("accept", acceptedTypes);
}

function drawPreview(content, canvasId) {
    const chart = drawChart(content, canvasId, false);

    const base64 = chart.toBase64Image();
    var image = new Image();
    image.className = 'preview-image';
    var container = $("#chart-preview-area");
    image.src = base64;
    container.append(image);
    $(image).click(function() {
        $("#fake-data-chart").removeClass("invisible");
        $("#fake-data-chart").click(function(e) {
            if(e.target == document.querySelector("#fake-data-chart")) {
                $(this).addClass("invisible");
            }
        });
    })
}

function generatePreviewChart() {
    const container = $("#chart-preview-area");
    container.empty();
    var files = this.files;
    if(files.length < 1) {
        return;
    }
    var type = $("[name=chart-type]:checked").val();
    if(type == 'IMAGE') {
        var reader = new FileReader();
        reader.onload = function (readerEvent) {
            var image = new Image();
            image.className = 'preview-image';
            image.onload = function () {
                var container = $("#chart-preview-area");
                container.append(image);
            }
            image.src = readerEvent.target.result;
        }
        reader.readAsDataURL(files[0]);
    } else if(type == 'DATA') {
        var fakeContainer = document.createElement('div');
        container.append(fakeContainer);
        fakeContainer.id = 'fake-data-chart';
        fakeContainer.className = 'invisible';
        var canvas = document.createElement('canvas');
        canvas.id = 'chart';
        fakeContainer.append(canvas);
        Papa.parse(files[0], {
            complete: function(results) {
                drawPreview(results, 'chart');
            }
        });
    }

    return true;
}

$(function() {
    $("[name=chart-type]").click(handleChartType);
    $("#chart-file-button").change(generatePreviewChart);
});
