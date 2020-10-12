<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Paulo Henrique Alves de Souza">
    <meta name="csrf-token" content="{{ csrf_token() }}">
   <!-- <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">-->

    <title>Crud Produtos API Ajax</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/product/">

    <!-- Bootstrap core CSS -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{asset('css/starter-template.css')}}" rel="stylesheet">
</head>

<body>
    <div class="container">

        @component('component_nav', ['current'=>$current])

        @endcomponent

            <div role="main">

                @hasSection ('body')
                    @yield('body')
                @endif
                
            </div>
    </div>



<script src="{{asset('js/app.js')}}" type="text/javascript"></script>

@hasSection ('javascript')
    @yield('javascript')    
@endif

</body>

</html>
