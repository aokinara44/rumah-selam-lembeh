<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact; // 1. Import Model
use App\Http\Requests\ContactRequest; // 2. Import Request Validasi
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache; // <-- 1. DITAMBAHKAN

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::latest()->paginate(10);
        // Nanti kita akan buat view di: 'admin.contacts.index'
        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Nanti kita akan buat view di: 'admin.contacts.create'
        return view('admin.contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactRequest $request) // 3. Gunakan ContactRequest
    {
        Contact::create($request->validated());

        Cache::forget('site_contacts'); // <-- 2. DITAMBAHKAN (Hapus Cache)

        return redirect()->route('admin.contacts.index')
                         ->with('success', 'Contact created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        // Kita tidak pakai 'show' (halaman detail), jadi redirect saja ke 'edit'
        return redirect()->route('admin.contacts.edit', $contact);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        // Nanti kita akan buat view di: 'admin.contacts.edit'
        return view('admin.contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactRequest $request, Contact $contact) // 4. Gunakan ContactRequest
    {
        $contact->update($request->validated());

        Cache::forget('site_contacts'); // <-- 3. DITAMBAHKAN (Hapus Cache)

        return redirect()->route('admin.contacts.index')
                         ->with('success', 'Contact updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        Cache::forget('site_contacts'); // <-- 4. DITAMBAHKAN (Hapus Cache)

        return redirect()->route('admin.contacts.index')
                         ->with('success', 'Contact deleted successfully.');
    }
}