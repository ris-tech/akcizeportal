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
    <style>
        input::placeholder {
            opacity: 0.2 !important;
        }
        .full-height {
            height:calc(100vh - 50px);
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
			width:600px;			
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
    </style>
    @yield('pagestyle')
</head>
<body class="bg-dark">
    <div class="overlay-loader">
        <div class="overlay__inner">
            <div class="overlay__content"><div class="text-center"><span class="spinner"></span><br>
                <span class="fs-3 text-light">Učitavanje...</span><br>
                <span class="text-light">Molim te sačekaj</span></div><br>
                <span class="process-details-global text-light">...</span>
                <div class="progress">
                    <div class="progress-bar progress-upload progress-bar-primary" role="progressbar" data-dz-uploadprogress>
                        <span class="progress-text"></span>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <div id="app">
        <main class="py-4 full-height">
            <div class="container-fluid full-height">
                @yield('content')
            </div>
        </main>

    </div>
    <script src=" https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js "></script>
    
    @yield('pagescript')
</body>
</html>
