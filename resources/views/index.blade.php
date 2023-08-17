<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
  
    <title>{{ config('app.name', 'Laravel') }}</title>

    <style>
       .btn-danger-sombre{
        background-color: #a52834;
       }
       .btn-lg{
        color: white !important;
       }
       .danger{
        color: red !important;
        font-weight: bold;
       }
    </style>
     @livewireStyles

  
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <script type="module">
        $(document).ready(function() {
            function maFonction() {
                // Sélectionnez les boutons ayant un attribut name similaire
                var valeur = "Not Defined (X)";
                var boutons = $('button[name^="' + valeur + '"]');
                
                // Faites quelque chose avec les boutons sélectionnés
                boutons.addClass('btn-danger');
            }
            

        $("button").click(function(){
            maFonction();
            var firstClass = $(this).attr('class').split(' ')[0];
            $('.' + firstClass).removeClass('btn-danger')
            $(this).addClass('btn-danger');
        });
    });
    </script>

  
</head>
<body class="container">
    <h1 class="text-center">Common Vulnerability Scoring System Version 3.1 Calculator</h1>
    @livewire('calculate')

    <div class="p-4"></div>

    @livewire('calculate-temporal')
    

    <div class="p-4"></div>

    <div class="card mx-4" style="max-width: 100%;">
        <div class="card-header text-white bg-secondary">Environmental Score</div>
        <div class="card-body">
            <div class="row d-flex mt-8px">
                @foreach($environmental as $cle => $valeur)
                    <div class="col-md-6 ms-auto">
                        <h4 mt-2>{{ $cle }}</h4>
                        @foreach($valeur as $key => $val)
                            @if ($key != "id")
                            <button 
                            type="button" 
                            name="{{ $key }}" 
                            class="{{$environmental[$cle]['id']}} btn btn-secondary mt-1" 
                            value="{{ $val }}">{{ $key }}</button>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
    @livewireScripts
</body>
</html>