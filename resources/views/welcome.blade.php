<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/sass/app.scss')
    @vite('resources/js/app.js')
    <title>Vehicle search</title>
</head>
<body>
<div id="app">
    <div class="container my-3">
        <h2>Vehicle search</h2>
    </div>
    <div class="container">
        <vehicle-search />
    </div>
</div>
</body>
</html>
