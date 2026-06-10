@extends('layouts.app')

@section('header-button')
    <a href="/register" class="border border-[#D9C6B5] bg-[#F6F1EC] px-6 py-2 text-[#D9C6B5] text-lg">
        register
    </a>
@endsection

@section('content')
    <div class="bg-[#F1ECE7] min-h-[calc(100vh-112px)] pt-12 pb-8 px-6">

        <h2 class="text-center text-[40px] font-serif mb-12">
            Login
        </h2>

        <div class="w-[820px] mx-auto bg-white border border-[#D9C6B5] rounded-md px-40 py-28">
            <form action="/login" method="POST" novalidate>
                @csrf

                <div class="mb-14">
                    <label class="block text-2xl font-bold mb-4">
                        メールアドレス
                    </label>

                    <div>
                        <input type="text" name="email" value="{{ old('email') }}" placeholder="例: test@example.com"
                            class="w-full bg-[#F4F4F4] h-16 px-6 outline-none">

                        @error('email')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-20">
                    <label class="block text-2xl font-bold mb-4">
                        パスワード
                    </label>

                    <div>
                        <input type="password" name="password" placeholder="例: coachtech1106"
                            class="w-full bg-[#F4F4F4] h-16 px-6 outline-none">

                        @error('password')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-[#82756A] text-white px-10 py-2 text-lg">
                        ログイン
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection