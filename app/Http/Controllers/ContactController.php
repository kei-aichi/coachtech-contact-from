<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Category;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('contact.index', compact('categories'));
    }
    public function confirm(ContactRequest $request)
    {
        return view('contact.confirm', [
            'contact' => $request->validated(),
        ]);
    }
}
