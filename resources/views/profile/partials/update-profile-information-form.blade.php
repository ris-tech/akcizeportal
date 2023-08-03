<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Nalog') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Promeni podatke naloga.") }}
        </p>
    </header>



    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div class="row mb-2">
                <label for="name" class="col-sm-2 col-form-label">{{ __('Ime') }}</label>
                <div class="col-sm-6">
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                    
                </div>
        </div>
        <div class="row mb-2">
            <label for="email" class="col-sm-2 col-form-label">{{ __('E-Mail') }}</label>
            <div class="col-sm-6">
                <input type="text" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
            </div>
            
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn btn-outline-secondary">{{ __('Sačuvaj') }}</button>
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif
            @if ($message = Session::get('status'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
        </div>
    </form>
</section>
