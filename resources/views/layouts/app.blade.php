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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.min.css" rel="stylesheet">
    <link href="{{asset('assets/css/paper.css')}}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" integrity="sha512-uKQ39gEGiyUJl4AI6L+ekBdGKpGw4xJ55+xyJG7YFlJokPNYegn9KwQ3P8A7aFQAUtUsAQHep+d/lrGqrbPIDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <style>
        .navbar > .container-fluid {
            display:unset !important;
        }
    </style>
</head>
<body class="">
    <div id="app">
        <nav class="navbar navbar-dark bg-dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button> 
              <a class="navbar-brand mr-auto" href="#"><img src="{{ asset('assets/img/akcize_logo.png') }}" height="60px;"> Akcize Portal</a>
              
              <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                  <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Akcize Portal</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                  <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
  
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            
                            <li><a class="nav-link" href="{{ route('klijenti.index') }}"><i class="fas fa-user-tie me-2"></i> Klijenti</a></li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-tools me-2"></i> Podešavanja
                                </a>
                                <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('knjigovodja.index') }}">Knjigovodja</a>
                                    <a class="dropdown-item" href="{{ route('banke.index') }}">Banke</a>
                                    <a class="dropdown-item" href="{{ route('poreskafilijala.index') }}">Poreske Filijale</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-user-cog me-2"></i> Administracija
                                </a>
                                <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('users.index') }}">Korisnici</a>
                                    <a class="dropdown-item" href="{{ route('roles.index') }}">Dozvole</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-user me-2"></i> {{ Auth::user()->name }}
                                </a>
  
                                <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
  
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                  </ul>
                  <form class="d-flex mt-3" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-success" type="submit">Search</button>
                  </form>
                </div>
              </div>
            </div>
        </nav>
        
  
        <main class="py-4">
            <div class="container">
                @yield('content')       
            </div>
        </main>
          
    </div>
    <script src=" https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js "></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        const canvas = document.querySelector("canvas");
        const signaturePad = new SignaturePad(canvas, {
            minWidth: 2,
            maxWidth: 5,
            penColor: "rgb(68, 45, 199)"
        });

        $('.save-signature').click(function(event) {
    
            var data = signaturePad.toDataURL();
            signaturePad.clear();
            $('.signature-container').html('<img class="open-signiture-pad" style="width:100%;" src="' + data + '">');
            $('.open-signiture-pad').html('Ponovi');
            $('.signature-modal').modal('hide');
        });

        $('.reset-pad').click(function(event) {
    
            signaturePad.clear();
        });

        $('body').on('click', '.open-signiture-pad', function(event){
            $('.signature-modal').modal('show');
        });

        $('#ugovor-form').submit(function(event) {
            event.preventDefault();
            var url = $(this).attr("action");
            var formData = $('body').find('.open-signiture-pad').attr('src');
            //console.log(url);
            //console.log(formData);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="csrf-token"]').val()
                }
            });
            var request = $.ajax({
                url: url,
                method: 'POST',
                data: {clientsig: formData},
                dataType: 'json',
                success: function(result){
                    alert(result.success);
                }
            });
            /*$.ajax({

                type:'POST',
                url: url,
                data: {pages: "formData"},
                dataType: 'html',
                processData: false,
                success: (response) => {
                    alert('Form submitted successfully');
                },
                error: function(response){
                    $('#ajax-form').find(".print-error-msg").find("ul").html('');
                    $('#ajax-form').find(".print-error-msg").css('display','block');
                    $.each( response.responseJSON.errors, function( key, value ) {
                        $('#ajax-form').find(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                    });

                }

            });*/

            
            //form.submit();
        });

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
    
</body>
</html>