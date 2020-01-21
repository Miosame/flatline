@extends('layouts.main')

@section('content')
    <div class='container md:w-5/6 px-5 sm:mx-auto mb-10 text-center'>
        <div class='flex scss--background-header p-5 rounded-t-lg scss--border scss--border-bottom-0 font-bold'>
            <div class="w-full hidden lg:block">Status</div>
            <div class="w-full px-2">Name</div>
            <div class="w-full">IPv4</div>
            <div class="w-full hidden md:block">MAC</div>
            <div class="w-full hidden lg:block">Offline Counter</div>
            <div class="w-1/2 md:w-full">Save</div>
        </div>
        <form method='POST' action='/nodes/{{ $node->{"id"} }}' class='node-item flex p-5 bg-white scss--border'>
            @method('PATCH')
            @csrf
            <div class="w-full hidden lg:block"><div class='{{ $node->{'online'} ? "online" : "offline" }} rounded-full p-1 px-3 inline-block text-white font-bold'>{{ $node->{'online'} ? "on" : "off" }}</div></div>
            <div class="w-full px-2"><input class='text-center w-full border border-gray-400 border-solid' name='hostname' type='text' value='{{ ucwords($node->{'comment'}) ?? (ucwords($node->{'hostname'}) ?? '-') }}'/></div>
            <div class="w-full">{{ $node->{'ipaddr4'} }}</div>
            <div class="w-full hidden md:block">{{ $node->{'macaddr'} }}</div>
            <div class="w-full hidden lg:block">{{ $node->{'offline-count'} }}</div>
            <div class="w-1/2 md:w-full"><button><i class="fas fa-save text-gray-500"></i></button></div>
        </form>
    </div>
@endsection