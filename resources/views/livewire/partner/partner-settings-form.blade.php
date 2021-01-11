<div>
    <div id="userInfo" class="mb-4 pb-4 border-b-2">
        <form wire:submit.prevent="updateUserInfo">
            <div class="flex flex-row justify-start mx-6">
                <h2 class="mb-2 text-xl font-semibold">Bruger informationer:</h2>
            </div>
            @if(isset($userInfoSuccessMessage))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mx-6"
                role="alert">
                <span class="block sm:inline">{{ $userInfoSuccessMessage }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 green-red-500" role="button"
                        wire:click="$set('userInfoSuccessMessage', null)" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <title>Close</title>
                        <path
                            d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                    </svg>
                </span>
            </div>
            @endif
            <div class="flex flex-wrap mx-4">
                <div class="w-full sm:w-1/2 lg:w-1/3 my-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 leading-5 mx-2">
                        Dit navn
                    </label>

                    <div class="mt-1 rounded-md shadow-sm mx-2">
                        <input wire:model.defer="name" id="name" type="text" autofocus
                            class="block w-full input-field" />
                    </div>

                    @error('name')
                    <p class="ml-2 mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full sm:w-1/2 lg:w-1/3 my-2">
                    <label for="email" class="block text-sm font-medium text-gray-700 leading-5 mx-2">
                        Din email adresse
                    </label>

                    <div class="mt-1 rounded-md shadow-sm mx-2">
                        <input wire:model.defer="email" id="email" type="text" class="block w-full input-field" />
                    </div>

                    @error('email')
                    <p class="ml-2 mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full sm:w-1/2 lg:w-1/3 my-2">
                    <label for="phone" class="block text-sm font-medium text-gray-700 leading-5 mx-2">
                        Dit telefon nummer
                    </label>

                    <div class="mt-1 rounded-md shadow-sm mx-2">
                        <input wire:model.defer="phone" id="phone" type="tel" class="block w-full input-field" />
                    </div>

                    @error('phone')
                    <p class="ml-2 mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full sm:w-1/2 lg:w-1/3 my-2" x-show="displayPassword">
                    <label for="password" class="block text-sm font-medium text-gray-700 leading-5 mx-2">
                        Nyt kodeord
                    </label>

                    <div class="mt-1 rounded-md shadow-sm mx-2">
                        <input wire:model.debounce.200ms="password" id="password" type="password"
                            class="block w-full input-field" />
                    </div>

                    @error('password')
                    <p class="ml-2 mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full sm:w-1/2 lg:w-1/3 my-2" x-show="displayPassword">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 leading-5 mx-2">
                        Bekræft kodeordet
                    </label>

                    <div class="mt-1 rounded-md shadow-sm mx-2">
                        <input wire:model.debounce.300ms="password_confirmation" id="password_confirmation"
                            type="password" class="block w-full input-field" />
                    </div>
                </div>

                <div class="w-full sm:w-1/2 lg:w-1/3 my-2" x-show="displayPassword">
                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-gray text-center w-full mx-2 mt-5 cursor-pointer">
                            Opdater bruger info
                        </button>
                    </div>
                </div>
                <div class="text-xs ml-2" x-show="displayPassword">
                    <p class="font-semibold">Et nyt kodeord skal leve op til følgende regler:</p>
                    <ol>
                        @if(strlen($password) > 7 && strlen($password_confirmation) > 7)
                        <div class="flex flex-row">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 fill-current text-green-500"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <li class="text-green-500">Minimum 8 karakterer.</li>
                        </div>
                        @else
                        <li>Minimum 8 karakterer.</li>
                        @endif

                        @if(preg_match('/[A-Z]/', $password) && preg_match('/[A-Z]/', $password_confirmation))
                        <div class="flex flex-row">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 fill-current text-green-500"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <li class="text-green-500">Minimum ét stort bogstav.</li>
                        </div>
                        @else
                        <li>Minimum ét stort bogstav.</li>
                        @endif

                        @if(preg_match('/[a-z]/', $password) && preg_match('/[a-z]/', $password_confirmation))
                        <div class="flex flex-row">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 fill-current text-green-500"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <li class="text-green-500">Minimum ét lille bogstav.</li>
                        </div>
                        @else
                        <li>Minimum ét lille bogstav.</li>
                        @endif

                        @if(preg_match('/[0-9]/', $password) && preg_match('/[0-9]/', $password_confirmation))
                        <div class="flex flex-row">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 fill-current text-green-500"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <li class="text-green-500">Minimum ét tal.</li>
                        </div>
                        @else
                        <li>Minimum ét tal.</li>
                        @endif

                        @if(preg_match('/[!.,@#\$%\^&\*]/', $password) && preg_match('/[!.,@#\$%\^&\*]/',
                        $password_confirmation))
                        <div class="flex flex-row">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 fill-current text-green-500"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <li class="text-green-500">Minimum ét special tegn som eksempelvis: !#$</li>
                        </div>
                        @else
                        <li>Minimum ét special tegn som eksempelvis: !#$</li>
                        @endif

                        @if($password === $password_confirmation && strlen($password) > 0)
                        <div class="flex flex-row">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 fill-current text-green-500"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <li class="text-green-500">Kodeordet skal gentages.</li>
                        </div>
                        @else
                        <li>Kodeordet skal gentages.</li>
                        @endif


                    </ol>
                </div>
            </div>
        </form>
    </div>

    <div id="companyInfo" class="mb-4 border-b-2">
        <form wire:submit.prevent="updateCompanyInfo">
            <div class="flex flex-row justify-between mx-6">
                <h2 class="mb-2 text-xl font-semibold">Virksomheds informationer:</h2>
            </div>

            @if(isset($companySuccessMessage))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mx-6"
                role="alert">
                <span class="block sm:inline">{{ $companySuccessMessage }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 green-red-500" role="button"
                        wire:click="$set('companySuccessMessage', null)" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <title>
                            Close
                        </title>
                        <path
                            d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0
                            1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                    </svg>
                </span>
            </div>
            @endif

            <div class="flex flex-wrap mb-4 mx-4">
                <div class="w-full sm:w-1/2 lg:w-1/3 my-2">
                    <label for="cvr" class="block text-sm font-medium text-gray-700 leading-5 mx-2">
                        CVR nummer
                    </label>

                    <div class="mt-1 rounded-md shadow-sm mx-2">
                        <input wire:model.defer="cvr" id="cvr" type="text" class="block w-full input-field" />
                    </div>

                    @error('cvr')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full sm:w-1/2 lg:w-1/3 my-2">
                    <label for="company_name" class="block text-sm font-medium text-gray-700 leading-5 mx-2">
                        Navn
                    </label>

                    <div class="mt-1 rounded-md shadow-sm mx-2">
                        <input wire:model.defer="company_name" id="company_name" type="text"
                            class="block w-full input-field" />
                    </div>

                    @error('company_name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full sm:w-1/2 lg:w-1/3 my-2">
                    <label for="company_address" class="block text-sm font-medium text-gray-700 leading-5 mx-2">
                        Adresse
                    </label>

                    <div class="mt-1 rounded-md shadow-sm mx-2">
                        <input wire:model.defer="company_address" id="company_address" type="text"
                            class="block w-full input-field" />
                    </div>

                    @error('company_address')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full sm:w-1/2 lg:w-1/3 my-2">
                    <label for="zipcode" class="block text-sm font-medium text-gray-700 leading-5 mx-2">
                        Postnummer
                    </label>

                    <div class="mt-1 rounded-md shadow-sm mx-2">
                        <input wire:model.defer="zipcode" id="zipcode" type="text" class="block w-full input-field" />
                    </div>

                    @error('zipcode')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full sm:w-1/2 lg:w-1/3 my-2">
                    <label for="city" class="block text-sm font-medium text-gray-700 leading-5 mx-2">
                        By
                    </label>

                    <div class="mt-1 rounded-md shadow-sm mx-2">
                        <input wire:model.defer="city" id="city" type="text" class="block w-full input-field" />
                    </div>

                    @error('city')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full sm:w-1/2 lg:w-1/3 my-2">
                    <label for="country" class="block text-sm font-medium text-gray-700 leading-5 mx-2">
                        Land
                    </label>

                    <div class="mt-1 rounded-md shadow-sm mx-2">
                        <input wire:model.defer="country" id="country" type="text" class="block w-full input-field" />
                    </div>

                    @error('country')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full sm:w-1/2 lg:w-1/3 my-2">
                    <label for="company_phone" class="block text-sm font-medium text-gray-700 leading-5 mx-2">
                        Telefon nummer
                    </label>

                    <div class="mt-1 rounded-md shadow-sm mx-2">
                        <input wire:model.defer="company_phone" id="company_phone" type="text"
                            class="block w-full input-field" />
                    </div>

                    @error('company_phone')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full sm:w-1/2 lg:w-1/3 my-2">
                    <label for="company_start_date" class="block text-sm font-medium text-gray-700 leading-5 mx-2">
                        Stiftelses dato (Dag-Måned-År)
                    </label>

                    <div class="mt-1 rounded-md shadow-sm mx-2">
                        <input wire:model.defer="company_start_date" id="company_start_date" type="text"
                            class="block w-full input-field" />
                    </div>

                    @error('company_start_date')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full sm:w-1/2 lg:w-1/3 my-2">
                    <label for="company_capital" class="block text-sm font-medium text-gray-700 leading-5 mx-2">
                        Egenkapital i DKK:
                    </label>

                    <div class="mt-1 rounded-md shadow-sm mx-2">
                        <input wire:model.defer="company_capital" id="company_capital" type="text"
                            class="block w-full input-field" />
                    </div>

                    @error('company_capital')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full sm:w-1/2 lg:w-1/3 my-2 ">
                    <label for="company_number_of_employees"
                        class="block text-sm font-medium text-gray-700 leading-5 mx-2">
                        Antal ansatte:
                    </label>

                    <div class="mt-1 rounded-md shadow-sm mx-2">
                        <input wire:model.defer="company_number_of_employees" id="company_number_of_employees"
                            type="text" class="block w-full input-field" />
                    </div>

                    @error('company_number_of_employees')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-full sm:w-1/2 lg:w-1/3 my-2" x-show="displayPassword">
                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-gray text-center w-full mx-2 mt-5 cursor-pointer">
                            Opdater virksomheds info
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <form wire:submit.prevent="uploadCertificate({{ Str::random(44) }})">
        <h2 class="my-2 pb-2 mx-6 text-xl font-semibold">Certifikationer:</h2>
        <div class="flex flex-wrap mb-4 mx-4">
            <div class="flex flex-col xl:flex-row w-full justify-between">
                <div class="flex flex-col w-full py-4 lg:py-2">
                    <label for="certificate_name"
                        class="text-center text-sm font-medium text-gray-700 leading-5 mx-2 mb-4">
                        1) Indtast navnet på certifikatet
                    </label>
                    <div class="mx-4">
                        <input wire:model.defer="certificate_name" id="certificate_name" type="text"
                            placeholder="Eksempelvis: ISO 9001" class="block w-full input-field" />

                        @error('certificate_name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex flex-col w-full py-4 lg:py-2">
                    <label for="certificate_valid_until"
                        class="text-center text-sm font-medium text-gray-700 leading-5 mx-2 mb-4">
                        2) Gyldig til
                    </label>
                    <div class="mx-4">
                        <input wire:model.defer="certificate_valid_until" id="certificate_valid_until" type="Date"
                            class="block w-full input-field" />

                        @error('certificate_valid_until')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex flex-col justify-center w-full mx-auto py-4 lg:py-2">

                    <div class="flex flex-row justify-center">
                        <label for="certificate_file"
                            class="text-center text-sm font-medium text-gray-700 leading-5 mx-2 mb-4">
                            3) Upload bevis for certifikatet
                        </label>
                    </div>
                    <div class="flex flex-row justify-center">
                        <input id="certificate_file" type="file" wire:model.defer="certificate_file" class="mt-2">
                        <div wire:loading wire:target="certificate_file">Uploading...</div>
                        @error('certificate_file') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-row justify-center">
            @if(!isset($certificate_file))
            <button type="button" class="btn bg-blue-300 hover:bg-blue-300 text-center h-10 w-44 ml-4"
                disabled>Tilføj certifikat</button>
            @else
            <button type="submit" class="btn btn-blue text-center h-10 w-44 ml-4">Tilføj certifikat</button>
            @endif
        </div>
    </form>
    <div class="px-4 w-full">
        <table class="table-auto mt-4 mb-12 mx-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2">Certifikat</th>
                    <th class="px-4 py-2">Sidst ændret:</th>
                    <th class="px-4 py-2">Gyldig til</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($certification_list as $certificate)
                <tr>
                    <td class="border p-1 text-center md:px-4 md:py-2">{{$certificate['certification_name']}}</td>
                    <td class="border p-1 text-center md:px-4 md:py-2">
                        {{$certificate['certification_last_edited_date']}}</td>
                    <td class="border p-1 text-center md:px-4 md:py-2">{{$certificate['certification_valid_until']}}
                    </td>
                    @if($requestDelete === true && $requestDeleteCertificateName === $certificate['certification_name'])
                    <td class="border p-1 text-center md:px-4 md:py-2">
                        <button type="button" id="confirmDeleteButton"
                            wire:click="deleteCertificate('{{$certificate['certification_name']}}')"
                            class="btn btn-red w-44">
                            Sikker?
                        </button>
                    </td>
                    @else
                    <td class="border p-1 md:px-4 md:py-2">
                        <button type="button" id="deleteButton"
                            wire:click="confirmCertificateDeleteAction('{{$certificate['certification_name']}}')"
                            class="md:btn font-semibold py-1 px-2 border border-transparent rounded-md text-white btn-red w-auto">
                            Slet
                        </button>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
