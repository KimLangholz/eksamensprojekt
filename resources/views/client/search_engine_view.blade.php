@extends('layouts.app')

@section('content')
<x-client-sidebar-menu activePage="SearchEngine">
</x-client-sidebar-menu>
<div class="flex flex-col justify-top h-full bg-white px-2 w-full">
    <div class="flex flex-col">
        <!-- Top bar start -->
        <div class="flex w-full h-auto py-2 border-b">

            <div class="flex flex-row w-full items-center justify-between">

                <div class="flex w-auto pl-7">
                    <h1 class="text-lg lg:text-2xl font-semibold text-left">
                        Producent Database
                    </h1>
                </div>

                <div id="searchBox" class="flex-auto px-6 lg:px-20 xl:px-32 relative text-gray-600">
                    <input
                        class="border-2 border-gray-300 h-10 px-5 pr-10 w-full rounded-md text-sm focus:outline-none shadow-md"
                        type="search" name="search" placeholder="Søg...">
                    <button type="submit" class="absolute right-0 top-0 mt-3 mr-10 lg:mr-24 xl:mr-36">
                        <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                            viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;"
                            xml:space="preserve" width="64px" height="64px">
                            <path
                                d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                        </svg>
                    </button>
                </div>

                <div id="CTA" class="w-44 flex flex-row pr-6">
                    <button class="btn btn-blue w-full font-bold py-2 px-4 rounded">
                        Opret RFQ
                    </button>
                </div>

            </div>

        </div>
        <!-- Top bar end -->

        <div class="flex flex-row overflow-hidden flex-1">
            <form action="{{route('client.search_engine/filter')}}" method="GET"
                class="flex-col hidden lg:w-1/4 md:block xl:w-1/5 xl:block py-6 shadow z-0">
                <!-- Filter section start -->
                <div id="Filters" class="flex flex-col w-full px-1" x-data="{'showLocation': false,
                                 'showCapital': false,
                                 'showRevenue': false,
                                 'showCertifications': false,
                                 'showEmployees': false,
                                 'showTechnology': false
                                }">
                    <div class="flex flex-row px-6 pb-4">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                            </path>
                        </svg>
                        <h2 class="text-xl font-semibold leading-tight">Filter</h2>
                        <div class="flex-grow"></div>
                        <a href="#" class="text-sm text-gray-600 hover:text-blue-400 underline pt-1">Ryd
                            alle</a>
                    </div>
                    <!--div id="location" class="flex flex-col border-t border-solid border-gray-200 px-6 pt-4 mb-4">
                            <div class="flex flex-row w-full justify-between">
                                <h2 class="mb-2 font-semibold">Afstand</h2>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" x-on:click="showLocation = !showLocation">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"
                                        x-show="!showLocation"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"
                                        x-show="showLocation"></path>
                                </svg>

                            </div>

                            <div class="flex flex-row" x-show="showLocation">
                                <label class="block mr-4 w-32">
                                    <span class="text-gray-700">Postnummer:</span>
                                    <input type="number" class="form-input mt-1 block" placeholder="" min="0" max="9999">
                                </label>
                                <label class="block w-full">
                                    <span class="text-gray-700">Indenfor radius:</span>
                                    <select class="form-select block w-full mt-1">
                                        <option>Ubegrænset</option>
                                        <option>25 km</option>
                                        <option>50 km</option>
                                        <option>75 km</option>
                                        <option>100 km</option>
                                        <option>150 km</option>
                                        <option>200 km</option>
                                        <option>250 km</option>
                                        <option>300 km</option>
                                    </select>
                                </label>
                            </div>
                        </div-->
                    <div id="capital" class="flex flex-col border-t border-solid border-gray-200 px-6 pt-4 mb-4">
                        <div class="flex flex-row w-full justify-between">
                            <h2 class="mb-2 font-semibold">Egenkapital</h2>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" x-on:click="showCapital = !showCapital">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"
                                    x-show="!showCapital"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"
                                    x-show="showCapital"></path>
                            </svg>
                        </div>
                        <label class="block" x-show="showCapital">
                            <span class="text-gray-700">Minimum egenkapital i kroner:</span>
                            <input type="number" class="form-input mt-1 block w-full text-right" placeholder="0"
                                name="capital">
                        </label>
                    </div>
                    <div id="revenue" class="flex flex-col border-t border-solid border-gray-200 px-6 pt-4 mb-4">
                        <div class="flex flex-row w-full justify-between">
                            <h2 class="mb-2 font-semibold">Omsætning i kroner</h2>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" x-on:click="showRevenue = !showRevenue">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"
                                    x-show="!showRevenue"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"
                                    x-show="showRevenue"></path>
                            </svg>
                        </div>
                        <div class="flex flex-row" x-show="showRevenue">
                            <label class="block">
                                <select class="form-select block w-24 mt-1 mr-2">
                                    <option>Min</option>
                                    <option>Max</option>
                                </select>
                            </label>
                            <label class="block">
                                <input type="number" class="form-input mt-1 block w-full text-right" placeholder="0">
                            </label>

                        </div>
                    </div>
                    <div id="certifications" class="flex flex-col border-t border-solid border-gray-200 px-6 pt-4 mb-4">
                        <div class="flex flex-row w-full justify-between">
                            <h2 class="mb-2 font-semibold">Certifikationer</h2>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                                x-on:click="showCertifications = !showCertifications">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"
                                    x-show="!showCertifications"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"
                                    x-show="showCertifications"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col" x-show="showCertifications">
                            @foreach($certificates as $certificate)

                            <label class="flex items-center pt-1">
                                <input type="checkbox" class="form-checkbox"
                                    value="{{$certificate->certification_name}}"
                                    name="filter[{{$certificate->certification_name}}]">
                                <span class="ml-2">{{$certificate->certification_name}}</span>
                            </label>

                            @endforeach

                        </div>

                    </div>
                    <div id="Employees" class="flex flex-col border-t border-solid border-gray-200 px-6 pt-4 mb-4">
                        <div class="flex flex-row w-full justify-between">
                            <h2 class="mb-2 font-semibold">Antal ansatte</h2>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" x-on:click="showEmployees = !showEmployees">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"
                                    x-show="!showEmployees"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"
                                    x-show="showEmployees"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col" x-show="showEmployees">
                            <label class="flex items-center pt-1">
                                <input type="checkbox" class="form-checkbox">
                                <span class="ml-2">1-3</span>
                            </label>
                            <label class="flex items-center pt-1">
                                <input type="checkbox" class="form-checkbox">
                                <span class="ml-2">4-7</span>
                            </label>
                            <label class="flex items-center pt-1">
                                <input type="checkbox" class="form-checkbox">
                                <span class="ml-2">8-11</span>
                            </label>
                            <label class="flex items-center pt-1">
                                <input type="checkbox" class="form-checkbox">
                                <span class="ml-2">+12</span>
                            </label>
                        </div>
                    </div>
                    <div id="Technology" class="flex flex-col border-t border-solid border-gray-200 px-6 pt-4 mb-4">
                        <div class="flex flex-row w-full justify-between">
                            <h2 class="mb-2 font-semibold">Produktionsteknologi</h2>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" x-on:click="showTechnology = !showTechnology">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"
                                    x-show="!showTechnology"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"
                                    x-show="showTechnology"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col overflow-y-auto h-24" x-show="showTechnology">
                            <label class="flex items-center pt-1">
                                <input type="checkbox" class="form-checkbox">
                                <span class="ml-2">Pladebearbejdning</span>
                            </label>
                            <label class="flex items-center pt-1">
                                <input type="checkbox" class="form-checkbox">
                                <span class="ml-2">CNC Fræsning/Drejning</span>
                            </label>
                            <label class="flex items-center pt-1">
                                <input type="checkbox" class="form-checkbox">
                                <span class="ml-2">3D printning</span>
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-blue w-44">
                        Filtrer
                    </button>
                </div>
            </form>
            <!-- Filter section end -->
            <div class="px-6 py-4 flex-1">
                <li>
                    @foreach($partners as $partner)
                    <ol>{{$partner['company_name']}}</ol>
                    @endforeach
                </li>
            </div>
        </div>
    </div>

</div>
@endsection
