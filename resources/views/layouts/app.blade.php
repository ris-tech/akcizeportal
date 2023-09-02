<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>


    <link href="{{asset('assets/css/paper.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" integrity="sha512-uKQ39gEGiyUJl4AI6L+ekBdGKpGw4xJ55+xyJG7YFlJokPNYegn9KwQ3P8A7aFQAUtUsAQHep+d/lrGqrbPIDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>



    <style>
        .navbar > .container-fluid {
            display:unset !important;
        }
		.overlay-loader {
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			position: fixed;
			background: rgba(0,0,0,0.7);
			z-index:5000;
			display:none;
		}

		.overlay__inner {
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			position: absolute;
		}

		.overlay__content {
			left: 50%;
			position: absolute;
			top: 50%;
			transform: translate(-50%, -50%);
		}

		.spinner {
			width: 75px;
			height: 75px;
			display: inline-block;
			border-width: 2px;
			border-color: rgba(255, 255, 255, 0.05);
			border-top-color: #fff;
			animation: spin 1s infinite linear;
			border-radius: 100%;
			border-style: solid;
		}

		@keyframes spin {
		  100% {
			transform: rotate(360deg);
		  }
		}
        iframe {
            min-height: 700px !important;
        }
    </style>
    @yield('pagestyle')
</head>
<body class="">
<div class="overlay-loader">
    <div class="overlay__inner">
        <div class="overlay__content"><span class="spinner"></span><br>
			<span class="fs-3 text-light">Učitavanje...</span><br>
			<span class="text-light">Molim te sačekaj</span>
		</div>
	</div>
</div>
    <div id="app">
        @include('layouts.nav')


        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>

    </div>
    <script src=" https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js "></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))





        $('.show-alert-delete-box').click(function(event){
            var form =  $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                title: "Siguran?",
                text: "Jel si siguran da hoćes da izbrišes podatak?",
                icon: "warning",
                type: "warning",
                buttons: ["Odustani","Da!"],
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Da, izbriši!'
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        });

        $('.finish-scan').click(function(event){
            var form =  $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                title: "Siguran?",
                text: "Jel si siguran da si završio skeniranje?",
                icon: "warning",
                type: "warning",
                buttons: ["Odustani","Da!"],
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Da, završi!'
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        });

        $('.finish-unos').click(function(event){
            var form =  $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                title: "Siguran?",
                text: "Jel si siguran da si završio unos?",
                icon: "warning",
                type: "warning",
                buttons: ["Odustani","Da!"],
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Da, završi!'
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        });
        
        $('.show-mail-box').click(function(event){
            var docType = $(this).attr("docType");
            event.preventDefault();
            $('.modalDocType').val(docType);
            $('#mail-modal').modal('show');

        });

        $('.send-mail').click(function(event){

            event.preventDefault();
            var email = $('.email').val();
            var docType = $('.modalDocType').val();
            $('.'+docType+'-form').find('.emailVal').val(email);
            swal({
                title: "Siguran?",
                text: "Jel si siguran da hoćes da posaljes mail?",
                icon: "warning",
                type: "warning",
                buttons: ["Odustani","Da!"],
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Da, pošalji!'
            }).then((send) => {
                if (send) {
                    $('.overlay-loader').fadeIn();
                    $('.'+docType+'-form').submit();
                }
            });

        });

        $('.ask-send').click(function(event){

            event.preventDefault();
            var form =  $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                title: "Siguran?",
                text: "Jel si siguran da hoćes da posaljes mail?",
                icon: "warning",
                type: "warning",
                buttons: ["Odustani","Da!"],
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Da, pošalji!'
            }).then((send) => {
                if (send) {
                    $('.overlay-loader').fadeIn();
                    form.submit();
                }
            });
        });


        $('.delete-user-message').click(function(event){
            var form =  $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                title: "Siguran?",
                text: "Jel si siguran da hoćes da izbrišes nalog?",
                icon: "warning",
                type: "warning",
                buttons: ["Odustani","Da!"],
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Da, izbriši!'
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        });
    </script>
    @yield('pagescript')
</body>
</html>
