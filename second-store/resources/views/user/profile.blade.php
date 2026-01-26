{{-- resources/views/user/profile.blade.php --}}

@extends('home.app')

@section('content')
    {{-- FULL WIDTH WRAPPER --}}
    <div class="w-100" style="margin-left: calc(-50vw + 50%); margin-right: calc(-50vw + 50%); background:#f8f9fa;">
        <div class="d-flex gap-4 py-5" style="max-width: 1400px; margin: 0 auto; padding-left: 20px; padding-right: 20px;">

            {{-- SIDEBAR (kiri) --}}
            <div class="d-none d-lg-block" style="flex: 0 0 280px;">
                @include('user.profile-sidebar')
            </div>

            {{-- CONTENT + TABS (kanan) --}}
            <div class="flex-grow-1" style="min-width: 0;">
                @include('user.profile-tabs', [
                    'tab' => request('tab', 'biodata'),
                    'favorits' => $favorits ?? auth()->user()->favorits
                ])
            </div>
        </div>
        </div>
@endsection
