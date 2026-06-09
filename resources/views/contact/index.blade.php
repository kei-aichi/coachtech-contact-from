@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto pt-12 pb-8 px-6">

        <h2 class="text-center text-[40px] font-serif mb-12">
            Contact
        </h2>

        <form action="/confirm" method="POST">
            @csrf

            <div class="space-y-9">

                <div class="grid grid-cols-[240px_1fr] gap-20 items-center">
                    <label>
                        お名前 <span class="text-red-500">※</span>
                    </label>

                    <div class="grid grid-cols-2 gap-8">
                        <div>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="例: 山田"
                                class="bg-[#F4F4F4] h-12 px-4 outline-none w-full">

                            @error('last_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="例: 太郎"
                                class="bg-[#F4F4F4] h-12 px-4 outline-none w-full">

                            @error('first_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-[240px_1fr] gap-20 items-center">
                    <label>
                        性別 <span class="text-red-500">※</span>
                    </label>

                    <div>
                        <div class="flex gap-20">
                            <label>
                                <input type="radio" name="gender" value="1" {{ old('gender') == '1' ? 'checked' : '' }}>
                                男性
                            </label>
                            <label>
                                <input type="radio" name="gender" value="2" {{ old('gender') == '2' ? 'checked' : '' }}>
                                女性
                            </label>
                            <label>
                                <input type="radio" name="gender" value="3" {{ old('gender') == '3' ? 'checked' : '' }}>
                                その他
                            </label>
                        </div>

                        @error('gender')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-[240px_1fr] gap-20 items-center">
                    <label>
                        メールアドレス <span class="text-red-500">※</span>
                    </label>

                    <div>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="例: test@example.com"
                            class="bg-[#F4F4F4] h-12 px-4 outline-none w-full">

                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-[240px_1fr] gap-20 items-start">
                    <label class="pt-3">
                        電話番号 <span class="text-red-500">※</span>
                    </label>

                    <div class="grid grid-cols-[1fr_auto_1fr_auto_1fr] items-center gap-4">
                        <div>
                            <input type="text" name="tel1" value="{{ old('tel1') }}" placeholder="080"
                                class="bg-[#F4F4F4] h-12 text-center outline-none w-full">

                            @error('tel1')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <span>-</span>

                        <div>
                            <input type="text" name="tel2" value="{{ old('tel2') }}" placeholder="1234"
                                class="bg-[#F4F4F4] h-12 text-center outline-none w-full">

                            @error('tel2')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <span>-</span>

                        <div>
                            <input type="text" name="tel3" value="{{ old('tel3') }}" placeholder="5678"
                                class="bg-[#F4F4F4] h-12 text-center outline-none w-full">

                            @error('tel3')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-[240px_1fr] gap-20 items-center">
                    <label>
                        住所 <span class="text-red-500">※</span>
                    </label>

                    <div>
                        <input type="text" name="address" value="{{ old('address') }}" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3"
                            class="bg-[#F4F4F4] h-12 px-4 outline-none w-full">

                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-[240px_1fr] gap-20 items-center">
                    <label>
                        建物名
                    </label>

                    <div>
                        <input type="text" name="building" value="{{ old('building') }}" placeholder="例: 千駄ヶ谷マンション101"
                            class="bg-[#F4F4F4] h-12 px-4 outline-none w-full">
                    </div>
                </div>

                <div class="grid grid-cols-[240px_1fr] gap-20 items-start">
                    <label class="pt-3">
                        お問い合わせの種類
                        <span class="text-red-500">※</span>
                    </label>

                    <div>
                        <div class="relative w-72">
                            <select name="category_id"
                                class="appearance-none bg-[#F4F4F4] h-12 px-4 pr-10 w-full outline-none">

                                <option value="">
                                    選択してください
                                </option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->content }}
                                    </option>
                                @endforeach

                            </select>

                            <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2
                                        w-0 h-0
                                        border-l-[12px] border-r-[12px]
                                        border-t-[12px]
                                        border-l-transparent border-r-transparent border-t-[#8B7969]">
                            </span>
                        </div>

                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-[240px_1fr] gap-20 items-start">
                    <label class="pt-2">
                        お問い合わせ内容
                        <span class="text-red-500">※</span>
                    </label>

                    <div>
                        <textarea name="detail" rows="5" placeholder="お問い合わせ内容をご記載ください"
                            class="bg-[#F4F4F4] px-4 py-3 resize-none outline-none w-full">{{ old('detail') }}</textarea>

                        @error('detail')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-center mt-7">
                <button type="submit" class="bg-[#82756A] text-white px-10 py-2">
                    確認画面
                </button>
            </div>

        </form>

    </div>
@endsection