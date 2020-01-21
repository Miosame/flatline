@extends('layouts.main')

@section('content')
    <div class='container md:w-5/6 px-5 sm:mx-auto mb-10 text-center'>
        <div class='flex scss--background-header p-5 rounded-t-lg scss--border scss--border-bottom-0 font-bold'>
            <div class="w-full">Status</div>
            <div class="w-full hidden lg:block">Name</div>
            <div class="w-full block lg:hidden">Name / IPv4</div>
            <div class="w-full hidden lg:block">IPv4</div>
            <div class="w-full hidden lg:block">MAC</div>
            <div class="w-full hidden lg:block">Offline Counter</div>
            <div class="w-full">Edit</div>
        </div>
        @forelse($nodes as $node)
            <div class='node-item flex p-5 bg-white scss--border'>
                <div class="w-full"><div class='{{ $node->{'online'} ? "online" : "offline" }} rounded-full p-1 px-3 inline-block text-white font-bold'>{{ $node->{'online'} ? "on" : "off" }}</div></div>
                <div class="w-full hidden lg:block">{{ ucwords($node->{'comment'} ?? $node->{'hostname'} ?? '-') }}</div>
                <div class="w-full block lg:hidden">{{ ucwords($node->{'comment'} ?? $node->{'hostname'} ?? $node->{'ipaddr4'} ??  '-') }}</div>
                <div class="w-full hidden lg:block">{{ $node->{'ipaddr4'} }}</div>
                <div class="w-full hidden lg:block">{{ $node->{'macaddr'} }}</div>
                <div class="w-full hidden lg:block">{{ $node->{'offline-count'} }}</div>
                <div class="w-full"><a href="/nodes/{{ $node->{'id'} }}/edit"><i class="fas fa-edit text-gray-500"></i></a></div>
            </div>
        @empty
            <div class='node-item flex p-5 scss--border font-bold bg-white'>
                <div class="w-full">No entries yet</div>
            </div>
        @endforelse
    </div>
@endsection