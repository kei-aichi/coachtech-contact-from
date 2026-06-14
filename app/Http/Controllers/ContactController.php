<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Category;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('contact.index', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->validated();

        $category = Category::find($contact['category_id']);

        return view('contact.confirm', compact('contact', 'category'));
    }

    public function back(Request $request)
    {
        return redirect('/')->withInput($request->all());
    }

    public function store(ContactRequest $request)
    {
        $contact = $request->validated();

        Contact::create([
            'category_id' => $contact['category_id'],
            'first_name' => $contact['first_name'],
            'last_name' => $contact['last_name'],
            'gender' => $contact['gender'],
            'email' => $contact['email'],
            'tel' => $contact['tel1'] . $contact['tel2'] . $contact['tel3'],
            'address' => $contact['address'],
            'building' => $contact['building'] ?? null,
            'detail' => $contact['detail'],
        ]);

        return redirect('/thanks');
    }

    public function thanks()
    {
        return view('contact.thanks');
    }

    public function admin(Request $request)
    {
        $categories = Category::all();

        $query = Contact::with('category');

        $query = $this->applySearchConditions($query, $request);

        $contacts = $query->paginate(7)->appends($request->query());

        $selectedContact = null;

        if ($request->contact_id) {
            $selectedContact = Contact::with('category')->find($request->contact_id);
        }

        return view('admin.index', compact('contacts', 'categories', 'selectedContact'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect('/admin');
    }

    public function export(Request $request)
    {
        $query = Contact::with('category');

        $query = $this->applySearchConditions($query, $request);

        $contacts = $query->get();

        $csvHeader = [
            'お名前',
            '性別',
            'メールアドレス',
            '電話番号',
            '住所',
            '建物名',
            'お問い合わせの種類',
            'お問い合わせ内容',
        ];

        $csvData = [];
        $csvData[] = $csvHeader;

        foreach ($contacts as $contact) {
            $csvData[] = [
                $contact->last_name . ' ' . $contact->first_name,
                $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他'),
                $contact->email,
                $contact->tel,
                $contact->address,
                $contact->building,
                $contact->category->content,
                $contact->detail,
            ];
        }

        $callback = function () use ($csvData) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, 'contacts.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    private function applySearchConditions($query, Request $request)
    {
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('last_name', 'like', '%' . $request->keyword . '%')
                    ->orWhereRaw(
                        "CONCAT(last_name, first_name) LIKE ?",
                        ['%' . str_replace(' ', '', $request->keyword) . '%']
                    )
                    ->orWhere('email', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('gender') && $request->gender !== 'all') {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        return $query;
    }
}
