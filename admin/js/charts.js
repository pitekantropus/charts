var selectedCharts = [];
var editBarVisible = false;

function removeCharts() {
    let chartsToRemove = [];
    selectedCharts.forEach(function(value, index) {
        if(value == true) {
            chartsToRemove.push(index);
        }
    });
    if(!confirm("Potwierdź usunięcie " + chartsToRemove.length + " wykresów.")) {
        return;
    }
    $.post("/admin/php/ajax/remove-charts.php", {chartNumbers: chartsToRemove.join(';')}, function(result) {
        if(result == 'OK') {
            $(".select-checkbox:checked").each(function() {
                let row = $(this).parent().parent();
                row.hide(600, function() {
                    row.remove();
                });
            });
        }
    });
    selectedCharts = [];
}

function editCharts() {
    selectedCharts.forEach(function(value, index) {
        if(value == true) {
            window.open('/edit-charts/' + index + '/');
        }
    });
}

function handleSelectCheckbox() {
    if(this.checked) {
        selectedCharts[this.value] = true;
    } else {
        selectedCharts[this.value] = false;
    }
    if(editBarVisible == false && selectedCharts.includes(true)) {
        editBarVisible = true;
        $("#edit-bar-container").slideDown();
    } else if(editBarVisible == true && !selectedCharts.includes(true)) {
        editBarVisible = false;
        $("#edit-bar-container").slideUp();
    }
}

function initButtons() {
    $("#edit-button").click(editCharts);
    $("#remove-button").click(removeCharts);
}

function initCheckboxes() {
    $(".select-checkbox").change(handleSelectCheckbox);
}

function initTable() {
    initButtons();
    initCheckboxes();
}

$(function() {
    $("#charts-table").load("/admin/php/list-charts.php", initTable);
});