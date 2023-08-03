<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Izbriši nalog') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Svi podaci će biti izbrisani nakon brisanja.') }}
        </p>
    </header>
    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
        {{ __('Izbriši nalog') }}
      </button>

      
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('Brisanje naloga') }}</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                    @csrf
                    @method('delete')
        
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Jel si siguran da hoćeš da izbrišes nalog?') }}
                    </h2>
        
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Svi podaci će biti izbrisani. Potvrdi brisanje sa tvojom šifrom!') }}
                    </p>
                    <div class="row mb-2">
                        <label for="password" class="col-sm-2 col-form-label">{{ __('Password') }}</label>
                        <div class="col-sm-6">
                            <input type="password" name="password" id="password" class="form-control" required laceholder="{{ __('Password') }}">
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Abbrechen</button>
                        <button type="submit" class="btn btn-outline-danger delete-user-message">
                            {{ __('Izbriši nalog') }}
                        </button>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
</section>
