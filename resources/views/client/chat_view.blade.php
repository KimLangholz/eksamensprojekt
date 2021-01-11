@extends('layouts.app')

@section('content')
        <x-client-sidebar-menu activePage="Chat">
        </x-client-sidebar-menu>
        <div class="flex flex-col justify-center h-full py-6 bg-white w-full sm:px-6 lg:px-8">
            <div class="flex flex-col h-auto mb-4 p-4">
                <h2 class="flex text-2xl font-semibold mb-6">Modtagne RFQ'er</h2>
                <div class="flex">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Virksomhed</th>
                                <th class="px-4 py-2">Leveringstype</th>
                                <th class="px-4 py-2">Stk tal</th>
                                <th class="px-4 py-2">Leveringsdato</th>
                                <th class="px-4 py-2">Materiale</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border px-4 py-2">
                                    PowerDrive ApS
                                    <p class="text-sm">Nordhavn 23, 6000 Kolding</p>
                                </td>
                                <td class="border px-4 py-2 text-center">Samlet</td>
                                <td class="border px-4 py-2 text-center">12</td>
                                <td class="border px-4 py-2 text-center">8/10/2020</td>
                                <td class="border px-4 py-2 text-center">Aluminium EN AW-6060 T6</td>
                                <td class="border px-4 py-2 items-center"><button @click="showOfferModal = true"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                                        SE RFQ
                                    </button></td>
                            </tr>
                            <tr class="bg-gray-100">
                                <td class="border px-4 py-2">
                                    DanDynamics A/S
                                    <p class="text-sm">Rømøvej 142, 6780 Skærbæk</p>
                                </td>
                                <td class="border px-4 py-2 text-center">Løbende</td>
                                <td class="border px-4 py-2 text-center">42</td>
                                <td class="border px-4 py-2 text-center">1/11/2020</td>
                                <td class="border px-4 py-2 text-center">Aluminium AW-7075</td>
                                <td class="border px-4 py-2 items-center"><button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                                        SE RFQ
                                    </button></td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">Strincon A/S<p class="text-sm">Skjernå 37, 6900 Skjern</p>
                                </td>
                                <td class="border px-4 py-2 text-center">Løbende</td>
                                <td class="border px-4 py-2 text-center">6</td>
                                <td class="border px-4 py-2 text-center">1/10/2020</td>
                                <td class="border px-4 py-2 text-center">Stål S235JR</td>
                                <td class="border px-4 py-2 items-center"><button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                                        SE RFQ
                                    </button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="flex flex-col h-full mt-4 p-4">
                <h2 class="flex text-2xl font-semibold mb-6 ">Aktive ordre</h2>
                <div class="flex">
                    <table class=" table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Virksomhed</th>
                                <th class="px-4 py-2">Leveringstype</th>
                                <th class="px-4 py-2">Stk tal</th>
                                <th class="px-4 py-2">Leveringsdato</th>
                                <th class="px-4 py-2">Materiale</th>
                                <th class="px-4 py-2">Pris</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border px-4 py-2">Strincon A/S<p class="text-sm">Skjernå 37, 6900 Skjern</p>
                                </td>
                                <td class="border px-4 py-2 text-center">Samlet</td>
                                <td class="border px-4 py-2 text-center">14</td>
                                <td class="border px-4 py-2 text-center">19/10/2020</td>
                                <td class="border px-4 py-2 text-center">Aluminium AW-7075</td>
                                <td class="border px-4 py-2 text-center">5.950 kr.</td>
                                <td class="border px-4 py-2 items-center"><button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                                        MERE INFO
                                    </button></td>
                            </tr>
                            <tr class="bg-gray-100">
                                <td class="border px-4 py-2">Translean A/S<p class="text-sm">Industrivej 129, 7400
                                        Herning</p>
                                </td>
                                <td class="border px-4 py-2 text-center">Løbende</td>
                                <td class="border px-4 py-2 text-center">50</td>
                                <td class="border px-4 py-2 text-center">10/11/2020</td>
                                <td class="border px-4 py-2 text-center">Rustfrit stål EN 4301/4307 H9</td>
                                <td class="border px-4 py-2 text-center">13.750 kr.</td>
                                <td class="border px-4 py-2 items-center"><button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                                        MERE INFO
                                    </button></td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">Micronics ApS<p class="text-sm">Møllevej 12, 5610 Assens
                                    </p>
                                </td>
                                <td class="border px-4 py-2 text-center">Samlet</td>
                                <td class="border px-4 py-2 text-center">220</td>
                                <td class="border px-4 py-2 text-center">15/11/2020</td>
                                <td class="border px-4 py-2 text-center">Aluminium EN AW-6060 T6</td>
                                <td class="border px-4 py-2 text-center">17.380 kr.</td>
                                <td class="border px-4 py-2 items-center"><button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                                        MERE INFO
                                    </button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>


            </div>

    @endsection
