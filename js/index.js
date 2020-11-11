function loadCategoryCharts(containerId, category, count = 8) {
    $("#" + containerId).load("/php/ajax/load-category-line.php", {category: category, count: count});
}

$(function() {
    loadCategoryCharts('this-week-charts', 'health');
})