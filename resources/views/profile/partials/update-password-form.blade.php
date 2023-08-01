<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')
        <input type="hidden" name="_method" value="PUT">
        <div class="row mb-2">
            <label for="current_password" class="col-sm-2 col-form-label">{{ __('Current Password') }}</label>
            <div class="col-sm-6">
                <input type="text" name="current_password" id="current_password" class="form-control" required autocomplete="current-password">
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="row mb-2">
            <label for="password" class="col-sm-2 col-form-label">{{ __('New Password') }}</label>
            <div class="col-sm-6">
                <input type="text" name="password" id="password" class="form-control" required autocomplete="new-password">
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>
        <div class="row mb-2">
            <label for="password_confirmation" class="col-sm-2 col-form-label">{{ __('Confirm Password') }}</label>
            <div class="col-sm-6">
                <input type="text" name="password_confirmation" id="password_confirmation" class="form-control" required autocomplete="new-password">
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn btn-outline-secondary">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
