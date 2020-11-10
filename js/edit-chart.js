import { drawChart } from './chart-utils.js';

function handleChartType() {
    const type = $(this).val();
    setChartType(type);
}

function setChartType(type, setRadio) {
    let buttonText = '';
    let acceptedTypes = '';
    if(type == 'IMAGE') {
        buttonText = 'Wybierz gotowy wykres';
        acceptedTypes = 'image/*';
    } else if(type == 'DATA') {
        buttonText = 'Wybierz plik csv';
        acceptedTypes = 'text/csv';
    }
    $("#chart-file-label").text(buttonText);
    $("#chart-file-button").attr("accept", acceptedTypes);
    if(setRadio) {
        $("input[name=chart-type][value=" + type + "]").prop('checked', true);
    }
}

function drawPreview(content, canvasId) {
    const title = $("[name=title]").val();
    const chart = drawChart(content, canvasId, title, false);

    const base64 = chart.toBase64Image();
    var image = new Image();
    image.id = 'preview-image';
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

function generateCurrentChartPreview(type) {
    const id = $("body").data("id");
    var container = $("#chart-preview-area");
    if(type == 'IMAGE') {
        var image = new Image();
        image.id = 'preview-image';
        image.src = '/data/' + id + '/image.jpg';
        container.append(image);
    } else if(type == 'DATA') {
        var fakeContainer = document.createElement('div');
        container.append(fakeContainer);
        fakeContainer.id = 'fake-data-chart';
        fakeContainer.className = 'invisible';
        var canvas = document.createElement('canvas');
        canvas.id = 'chart';
        fakeContainer.append(canvas);
        Papa.parse('/data/' + id + '/data.csv', {
            download: true,
            complete: function(results) {
                console.log(results);
                drawPreview(results, 'chart');
            }
        });
    }
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
            image.id = 'preview-image';
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

function validate() {
    const type = $("[name=chart-type]:checked").val();
    if(type == 'DATA') {
        const base64Data = ("#preview-image").attr("src");
        $.post("/php/ajax/save-base64-image.php", {data: base64Data, path: "data/image.png"});
    }
}

function init() {
    const type = $("#edit-chart-area").data("chart-type");
    setChartType(type, true);
    generateCurrentChartPreview(type);
}

$(function() {
    $("[name=chart-type]").click(handleChartType);
    $("#chart-file-button").change(generatePreviewChart);
    init();
});
