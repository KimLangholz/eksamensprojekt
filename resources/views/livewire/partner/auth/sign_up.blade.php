@section('title', 'Create a new account')

<div>
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <a href="{{ route('home') }}">
            <x-logo class="w-auto h-16 mx-auto text-indigo-600" />
        </a>

        <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900 leading-9">
            Create a new account
        </h2>

        <p class="mt-2 text-sm text-center text-gray-600 leading-5 max-w">
            Or
            <a href="{{ route('login') }}"
                class="font-medium link">
                sign in to your account
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <form wire:submit.prevent="registerPartnerAndUser">
                <h2 class="my-2 pb-2 border-b-2">Bruger informationer:</h2>
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 leading-5">
                        Dit navn
                    </label>

                    <div class="mt-1 rounded-md shadow-sm">
                        <input wire:model.lazy="name" id="name" type="text" required autofocus
                            class="block w-full input-field @error('name') error @enderror" />
                    </div>

                    @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 leading-5">
                        Din email adresse
                    </label>

                    <div class="mt-1 rounded-md shadow-sm">
                        <input wire:model.lazy="email" id="email" type="email" required
                            class="block w-full input-field @error('email') error @enderror" />
                    </div>

                    @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="phone" class="block text-sm font-medium text-gray-700 leading-5">
                        Dit telefon nummer
                    </label>

                    <div class="mt-1 rounded-md shadow-sm">
                        <input wire:model.lazy="phone" id="phone" type="tel" required class="block w-full input-field @error('email') error @enderror "/>
                    </div>

                    @error('phone')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 leading-5">
                        Dit ønskede kodeord
                    </label>

                    <div class="mt-1 rounded-md shadow-sm">
                        <input wire:model.lazy="password" id="password" type="password" required
                            class="block w-full input-field @error('password') error @enderror" />
                    </div>

                    @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 leading-5">
                        Bekræft kodeordet
                    </label>

                    <div class="mt-1 rounded-md shadow-sm">
                        <input wire:model.lazy="passwordConfirmation" id="password_confirmation" type="password"
                            required
                            class="block w-full input-field" />
                    </div>
                </div>

                <h2 class="mb-2 mt-8 pb-2 border-b-2">Virksomheds informationer:</h2>

                <div class="mt-6">
                    <label for="cvr" class="block text-sm font-medium text-gray-700 leading-5">
                        CVR nummer
                    </label>

                    <div class="mt-1 rounded-md shadow-sm">
                        <input wire:model="cvr" id="cvr" type="number" required
                            class="block w-full input-field @error('email') error @enderror" />
                    </div>

                    @error('cvr')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                @if(strlen($cvr) === 8)
                <span class="block w-full rounded-md shadow-sm mt-2">
                    <button type="button" wire:click="fetchDataFromCVR"
                        class="btn btn-gray flex justify-center w-full">
                        Hent info fra CVR.DK
                    </button>
                </span>
                @endif

                <div class="mt-6">
                    <label for="company_name" class="block text-sm font-medium text-gray-700 leading-5">
                        Navn
                    </label>

                    <div class="mt-1 rounded-md shadow-sm">
                        <input wire:model.lazy="company_name" id="company_name" type="text" required
                            class="block w-full input-field @error('email') error @enderror" />
                    </div>

                    @error('company_name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="company_address" class="block text-sm font-medium text-gray-700 leading-5">
                        Adresse
                    </label>

                    <div class="mt-1 rounded-md shadow-sm">
                        <input wire:model.lazy="company_address" id="company_address" type="text" required
                            class="block w-full input-field @error('email') error @enderror" />
                    </div>

                    @error('company_address')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="zipcode" class="block text-sm font-medium text-gray-700 leading-5">
                        Postnummer
                    </label>

                    <div class="mt-1 rounded-md shadow-sm">
                        <input wire:model.lazy="zipcode" id="zipcode" type="number" required
                            class="block w-full input-field @error('email') error @enderror" />
                    </div>

                    @error('zipcode')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="city" class="block text-sm font-medium text-gray-700 leading-5">
                        By
                    </label>

                    <div class="mt-1 rounded-md shadow-sm">
                        <input wire:model.lazy="city" id="city" type="text" required
                            class="block w-full input-field @error('email') error @enderror" />
                    </div>

                    @error('city')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="country" class="block text-sm font-medium text-gray-700 leading-5">
                        Land
                    </label>

                    <div class="mt-1 rounded-md shadow-sm">
                        <input wire:model.lazy="country" id="country" type="text" required
                            class="block w-full input-field @error('email') error @enderror" />
                    </div>

                    @error('country')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <span class="block w-full rounded-md shadow-sm">
                        <button type="submit"
                            class="btn btn-blue flex justify-center w-full">
                            Register
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
