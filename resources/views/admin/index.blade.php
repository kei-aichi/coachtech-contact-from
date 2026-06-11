@extends('layouts.app')

@section('header-button')
    <form action="/logout" method="POST">
        @csrf
        <button type="submit" class="border border-[#D9C6B5] bg-[#F6F1EC] px-6 py-1 text-[#D9C6B5] text-lg">
            logout
        </button>
    </form>
@endsection

@section('content')
    <div class="w-[1400px] mx-auto pt-8 pb-10 px-6">

        <h2 class="text-center text-[40px] font-serif mb-8">
            Admin
        </h2>

        <form action="/admin" method="GET">
            <div class="w-full mb-8">
                <div class="flex items-center gap-7">

                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="名前やメールアドレスを入力してください"
                        class="w-[420px] h-14 border border-[#E0DFDE] bg-[#F7F7F7] px-4 text-lg outline-none">

                    <select name="gender"
                        class="w-[120px] h-14 border border-[#E0DFDE] bg-[#F7F7F7] px-4 text-lg outline-none text-[#8B7969]">

                        <option value="">性別</option>
                        <option value="all" {{ request('gender') === 'all' ? 'selected' : '' }}>全て</option>
                        <option value="1" {{ request('gender') === '1' ? 'selected' : '' }}>男性</option>
                        <option value="2" {{ request('gender') === '2' ? 'selected' : '' }}>女性</option>
                        <option value="3" {{ request('gender') === '3' ? 'selected' : '' }}>その他</option>

                    </select>

                    <select name="category_id"
                        class="w-[260px] h-14 border border-[#E0DFDE] bg-[#F7F7F7] px-4 text-lg outline-none text-[#8B7969]">

                        <option value="">お問い合わせの種類</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->content }}
                            </option>
                        @endforeach

                    </select>

                    <input type="date" name="date" value="{{ request('date') }}"
                        class="w-[180px] h-14 border border-[#E0DFDE] bg-[#F7F7F7] px-4 text-lg outline-none text-[#8B7969]">

                    <button type="submit" class="w-[110px] h-14 bg-[#82756A] text-white text-lg">
                        検索
                    </button>

                    <a href="/admin"
                        class="w-[120px] h-14 bg-[#D9C6B5] text-white text-lg flex items-center justify-center">
                        リセット
                    </a>

                </div>
            </div>
        </form>

        <div class="flex justify-between items-center mb-5">
            <button class="bg-[#F4F0ED] px-6 py-2">
                エクスポート
            </button>

            <div class="flex justify-end mb-2 mt-3">
                <div class="flex border border-[#E0DFDE] text-[#8B7969]">

                    {{-- 前へ --}}
                    @if ($contacts->onFirstPage())
                        <span class="px-3 py-1 border-r border-[#E0DFDE] text-[#D9C6B5]">&lt;</span>
                    @else
                        <a href="{{ $contacts->previousPageUrl() }}" class="px-3 py-1 border-r border-[#E0DFDE]">
                            &lt;
                        </a>
                    @endif

                    {{-- ページ番号 --}}
                    @for ($i = 1; $i <= $contacts->lastPage(); $i++)
                        @if ($i == $contacts->currentPage())
                            <span class="px-3 py-1 bg-[#82756A] text-white border-r border-[#E0DFDE]">
                                {{ $i }}
                            </span>
                        @else
                            <a href="{{ $contacts->url($i) }}" class="px-3 py-1 border-r border-[#E0DFDE]">
                                {{ $i }}
                            </a>
                        @endif
                    @endfor

                    {{-- 次へ --}}
                    @if ($contacts->hasMorePages())
                        <a href="{{ $contacts->nextPageUrl() }}" class="px-3 py-1">
                            &gt;
                        </a>
                    @else
                        <span class="px-3 py-1 text-[#D9C6B5]">&gt;</span>
                    @endif

                </div>
            </div>
        </div>

        <table class="w-full border-collapse text-[#8B7969]">
            <thead>
                <tr class="bg-[#8B7969] text-white h-16">
                    <th class="w-[280px] text-left pl-14 text-xl font-bold">お名前</th>
                    <th class="w-[120px] text-left text-xl font-bold">性別</th>
                    <th class="w-[360px] text-left text-xl font-bold">メールアドレス</th>
                    <th class="w-[320px] text-left text-xl font-bold">お問い合わせの種類</th>
                    <th class="w-[120px]"></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($contacts as $contact)
                    <tr class="h-20 border border-[#E0DFDE] hover:bg-[#EFE8E1]">

                        <td class="pl-14 text-lg font-medium">
                            {{ $contact->last_name }} {{ $contact->first_name }}
                        </td>

                        <td class="text-lg">
                            @if ($contact->gender == 1)
                                男性
                            @elseif ($contact->gender == 2)
                                女性
                            @else
                                その他
                            @endif
                        </td>

                        <td class="text-lg">
                            {{ $contact->email }}
                        </td>

                        <td class="text-lg">
                            {{ $contact->category->content }}
                        </td>

                        <td class="text-center">
                            <a href="{{ route('admin', ['contact_id' => $contact->id]) }}"
                                class="border border-[#D9C6B5] px-5 py-1 text-[#D9C6B5] text-lg">
                                詳細
                            </a>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($selectedContact)
            <div class="fixed inset-0 flex items-center justify-center bg-black/5">

                <div class="relative w-[850px] min-h-[760px] bg-white px-32 py-32 shadow-[4px_4px_6px_rgba(0,0,0,0.25)]">
                    <a href="/admin"
                        class="absolute top-8 right-8 w-10 h-10 border border-[#8B7969] rounded-full flex items-center justify-center text-2xl">
                        ×
                    </a>

                    <div class="space-y-7 text-[#8B7969] text-lg">
                        <div class="grid grid-cols-[220px_1fr]">
                            <p class="font-bold">お名前</p>
                            <p>{{ $selectedContact->last_name }}　{{ $selectedContact->first_name }}</p>
                        </div>

                        <div class="grid grid-cols-[220px_1fr]">
                            <p class="font-bold">性別</p>
                            <p>
                                @if ($selectedContact->gender == 1)
                                    男性
                                @elseif ($selectedContact->gender == 2)
                                    女性
                                @else
                                    その他
                                @endif
                            </p>
                        </div>

                        <div class="grid grid-cols-[220px_1fr]">
                            <p class="font-bold">メールアドレス</p>
                            <p>{{ $selectedContact->email }}</p>
                        </div>

                        <div class="grid grid-cols-[220px_1fr]">
                            <p class="font-bold">電話番号</p>
                            <p>{{ $selectedContact->tel }}</p>
                        </div>

                        <div class="grid grid-cols-[220px_1fr]">
                            <p class="font-bold">住所</p>
                            <p>{{ $selectedContact->address }}</p>
                        </div>

                        <div class="grid grid-cols-[220px_1fr]">
                            <p class="font-bold">建物名</p>
                            <p>{{ $selectedContact->building }}</p>
                        </div>

                        <div class="grid grid-cols-[220px_1fr]">
                            <p class="font-bold">お問い合わせの種類</p>
                            <p>{{ $selectedContact->category->content }}</p>
                        </div>

                        <div class="grid grid-cols-[220px_1fr]">
                            <p class="font-bold">お問い合わせ内容</p>
                            <p>{{ $selectedContact->detail }}</p>
                        </div>
                    </div>

                    <div class="mt-32 flex justify-center">
                        <form action="{{ route('contacts.destroy', $selectedContact) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="bg-[#BA370D] px-10 py-3 text-white">
                                削除
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        @endif

    </div>
@endsection