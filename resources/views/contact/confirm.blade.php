@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto pt-12 pb-8 px-6">

        <h2 class="text-center text-[40px] font-serif mb-12">
            Confirm
        </h2>

        <div class="border border-[#E0DFDE]">
            <div class="grid grid-cols-[260px_1fr] border-b border-[#E0DFDE]">
                <div class="bg-[#BAA899] text-white px-14 py-6">お名前</div>
                <div class="px-12 py-6">
                    {{ $contact['last_name'] }} {{ $contact['first_name'] }}
                </div>
            </div>

            <div class="grid grid-cols-[260px_1fr] border-b border-[#E0DFDE]">
                <div class="bg-[#BAA899] text-white px-14 py-6">性別</div>
                <div class="px-12 py-6">
                    {{ ['1' => '男性', '2' => '女性', '3' => 'その他'][$contact['gender']] }}
                </div>
            </div>

            <div class="grid grid-cols-[260px_1fr] border-b border-[#E0DFDE]">
                <div class="bg-[#BAA899] text-white px-14 py-6">メールアドレス</div>
                <div class="px-12 py-6">{{ $contact['email'] }}</div>
            </div>

            <div class="grid grid-cols-[260px_1fr] border-b border-[#E0DFDE]">
                <div class="bg-[#BAA899] text-white px-14 py-6">電話番号</div>
                <div class="px-12 py-6">
                    {{ $contact['tel1'] }}{{ $contact['tel2'] }}{{ $contact['tel3'] }}
                </div>
            </div>

            <div class="grid grid-cols-[260px_1fr] border-b border-[#E0DFDE]">
                <div class="bg-[#BAA899] text-white px-14 py-6">住所</div>
                <div class="px-12 py-6">{{ $contact['address'] }}</div>
            </div>

            <div class="grid grid-cols-[260px_1fr] border-b border-[#E0DFDE]">
                <div class="bg-[#BAA899] text-white px-14 py-6">建物名</div>
                <div class="px-12 py-6">{{ $contact['building'] ?? '' }}</div>
            </div>

            <div class="grid grid-cols-[260px_1fr] border-b border-[#E0DFDE]">
                <div class="bg-[#BAA899] text-white px-14 py-6">お問い合わせの種類</div>
                <div class="px-12 py-6">{{ $category->content }}</div>
            </div>

            <div class="grid grid-cols-[260px_1fr]">
                <div class="bg-[#BAA899] text-white px-14 py-6 flex items-center">お問い合わせ内容</div>
                <div class="px-12 py-6">{{ $contact['detail'] }}</div>
            </div>
        </div>

    </div>
    <form action="/contacts" method="POST">
        @csrf

        <input type="hidden" name="last_name" value="{{ $contact['last_name'] }}">
        <input type="hidden" name="first_name" value="{{ $contact['first_name'] }}">
        <input type="hidden" name="gender" value="{{ $contact['gender'] }}">
        <input type="hidden" name="email" value="{{ $contact['email'] }}">
        <input type="hidden" name="tel1" value="{{ $contact['tel1'] }}">
        <input type="hidden" name="tel2" value="{{ $contact['tel2'] }}">
        <input type="hidden" name="tel3" value="{{ $contact['tel3'] }}">
        <input type="hidden" name="address" value="{{ $contact['address'] }}">
        <input type="hidden" name="building" value="{{ $contact['building'] ?? '' }}">
        <input type="hidden" name="category_id" value="{{ $contact['category_id'] }}">
        <input type="hidden" name="detail" value="{{ $contact['detail'] }}">

        <div class="flex justify-center items-center gap-10 mt-10">
            <button type="submit" class="bg-[#82756A] text-white px-12 py-2">
                送信
            </button>

            <button type="submit" formaction="/back" formmethod="POST" class="underline text-[#8B7969]">
                修正
            </button>
        </div>
    </form>
@endsection