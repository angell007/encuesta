<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon.png') }}" />
    <link href="{{ asset('font/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('css/genetic.light.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('font/iconsmind/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />
    <title>Software para encuestas de satisfación</title>


</head>

<body id="app-container" class="rounded menu-default ltr">

    <div id="app-vue" style="height:100%;">
        <main class="default-transition">
            <sidebar v-if="usuarioAutenticado && (ruta!='login' && ruta!='asistencia' && ruta!='ae' && ruta!='ed')">
            </sidebar>
            <navbar v-if="usuarioAutenticado && (ruta!='login' && ruta!='asistencia' && ruta!='ae' && ruta!='ed')"
                @logout="redireccionar"></navbar>
            <router-view></router-view>
        </main>


    </div>

    <script src="https://www.amcharts.com/lib/version/4.1.8/core.js"></script>
    <script src="https://www.amcharts.com/lib/version/4.1.8/charts.js"></script>
    <script src="https://www.amcharts.com/lib/version/4.1.8/themes/animated.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>

    <script>
        if (document.getElementById('mytextarea') != undefined) {
            var editor = CKEDITOR.replace('mytextarea');
        }
        if (document.getElementById('mytextarea2') != undefined) {
            var editor = CKEDITOR.replace('mytextarea2');
        }
    </script>
</body>

</html>
