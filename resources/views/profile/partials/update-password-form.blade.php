<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Promeni lozinku') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Izaberi jaku lozinku. Min. 8 karaktera, 1. veliko slovo, 1. veliko slovo, 1. broj i 1. specijalni karakter.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')
        <input type="hidden" name="_method" value="PUT">
        <div class="row mb-2">
            <label for="current_password" class="col-sm-2 col-form-label">{{ __('Trenutna lozinka') }}</label>
            <div class="col-sm-6">
                <input type="text" name="current_password" id="current_password" class="form-control" required autocomplete="current-password">
            </div>
            
        </div>

        <div class="row mb-2">
            <label for="password" class="col-sm-2 col-form-label">{{ __('Nova lozinka') }}</label>
            <div class="col-sm-6">
                <input type="text" name="password" id="password" class="form-control" required autocomplete="new-password">
            </div>
        </div>
        <div class="row mb-2">
            <label for="password_confirmation" class="col-sm-2 col-form-label">{{ __('Potvrdi lozinku') }}</label>
            <div class="col-sm-6">
                <input type="text" name="password_confirmation" id="password_confirmation" class="form-control" required autocomplete="new-password">
            </div>
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
        </div>
    </form>
</section>
