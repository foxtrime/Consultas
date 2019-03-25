<!DOCTYPE html>
<html lang="pt-br">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Consultas</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/meu.css') }}">

    <!--CDN.JS   -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    
    
    <script type="text/javascript" src='//code.jquery.com/jquery-1.10.2.min.js'></script>
    <!------ DATA PICKER ------->

    <!--------------------------->

    <body class="nav-md">
        <div class="wrapper">
            <div class="main-panel">
                {{-- Menu Superior --}}   
                @include('includes.topbar')
                    <div class="content" style="padding-top: 10px;padding-bottom: 0px;padding-left: 20px;padding-right: 20px;">
                        <div class="container-fluid">
                            {{-- Conteúdo Principal --}}
                            @yield('content')
                        </div>
                    </div>        
                    {{-- Rodapé --}}
                    @include('includes.footerbar')
            </div>
            <div style="clear:both"></div>
        </div>
    </body>
</html>
