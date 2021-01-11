@extends('layouts.app')

@section('content')

<x-partner-sidebar-menu activePage="Settings">
</x-partner-sidebar-menu>
<div class="flex flex-col justify-top h-full bg-white py-6 w-full sm:px-6 lg:px-8">
    @livewire('partner.partner-settings-form')
</div>
@endsection
