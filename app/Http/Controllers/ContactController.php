<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'prenom'  => 'required|string|max:255',
            'nom'     => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'sujet'   => 'nullable|string|max:255',
            'message' => 'required|string',
            'rgpd'    => 'accepted',
        ]);

        $fullName = trim($validated['prenom'] . ' ' . $validated['nom']);

        if ($validated['sujet'] === 'commande') {
            $product = Product::where('title', 'like', '%Kit%')->first();
            
            Order::create([
                'customer_name'  => $fullName,
                'customer_email' => $validated['email'],
                'product_id'     => $product ? $product->id : null,
                'quantity'       => 1,
                'total'          => $product ? $product->price : 0,
                'status'         => 'pending',
                'payment_status' => 'pending',
                'notes'          => $validated['message'],
            ]);

            return back()->with('success', 'Votre commande a bien été reçue. Nous vous contacterons très prochainement.');
        }

        Message::create([
            'sender_name' => $fullName,
            'email'       => $validated['email'],
            'subject'     => $validated['sujet'] ?: 'Contact',
            'message'     => $validated['message'],
            'status'      => 'unread',
        ]);

        return back()->with('success', 'Votre message a bien été envoyé. Nous vous répondrons sous 24h.');
    }
}
