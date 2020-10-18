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

$(function() {
    $("[name=chart-type").click(handleChartType);
});
