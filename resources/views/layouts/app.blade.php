@extends('layouts.base')

@section('body')
@include('includes.header')
<div class="flex flex-col flex-1">
    <div id="mainWindow" class="flex flex-row min-h-screen">
        @yield('content')

    </div>
</div>
@endsection
