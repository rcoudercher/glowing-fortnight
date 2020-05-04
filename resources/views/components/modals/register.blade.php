<div id="registerModal" class="modal">
  <div class="modal-content">
    <div class="bg-white h-full flex" style="font-family: 'Roboto', sans-serif;">
      <div class="bg-blueprint-grid w-1/12 sm:w-1/6"></div>
      <div class="relative p-6 sm:p-8 md:p-10 flex-grow flex items-center">
        <div id="closeRegister" class="absolute top-0 right-0 px-4 py-2 bg-gray-300 hover:bg-gray-200 focus:bg-gray-200 rounded cursor-pointer m-6"><span class="text-sm font-extrabold">X</span></div>
        <div class="max-w-xs">
          <div class="mb-6">
            <h2 class="title h3">Inscription</h2>
          </div>
          <div class="mb-6">
            <form method="POST" action="{{ route('login') }}">
              @csrf
              <div class="flex flex-wrap mb-6">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input id="name" type="text" class="form-input w-full @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" required autocomplete="off">
                @error('email')
                  <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
                @enderror
              </div>
              <div class="flex flex-wrap mb-6">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Nom d'utilisateur</label>
                <input id="email" type="email" class="form-input w-full @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="off">
                @error('email')
                  <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
                @enderror
              </div>
              <div class="flex flex-wrap mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mot de passe</label>
                <input id="password" type="password" class="form-input w-full @error('password') border-red-500 @enderror" name="password" required autocomplete="off">
                @error('password')
                  <p class="text-red-500 text-xs italic mt-4">{{ $message }}</p>
                @enderror
              </div>
              <div class="flex flex-wrap items-center">
                <button type="submit" class="btn btn-blue">Connexion</button>
              </div>
            </form>
          </div>
          
          <div class="mb-6">
            <p class="text-sm">Déjà membre ? <a class="text-blue-600 hover:underline font-bold" href="{{ route('login') }}">CONNEXION</a></p>
          </div>
          <div>
            <p class="text-sm">Acceptez nos <a class="text-sm text-blue-600 hover:underline" href="#">conditions générales</a>.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
