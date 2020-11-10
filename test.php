<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Wykresy</title>
    </head>
    <body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $.post("php/ajax/text.php", function(result) {
                console.log(result);
            }).done(function() {
                console.log( "second success" );
            })
            .fail(function() {
                console.log( "error" );
            })
            .always(function() {
                console.log( "finished" );
            });
            console.log("After test");
        </script>
    </body>
</html>
