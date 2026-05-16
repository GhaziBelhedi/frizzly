<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $orders = [
            ['customer_name'=>'Rym Chaabane',    'customer_email'=>'rym@gmail.com',      'customer_phone'=>'+216 55 123 456','qty'=>2,'status'=>'pending',  'payment'=>'pending',  'days'=>1],
            ['customer_name'=>'Mohamed Ferjani', 'customer_email'=>'m.ferjani@edu.tn',   'customer_phone'=>'+216 71 234 567','qty'=>1,'status'=>'confirmed','payment'=>'paid',     'days'=>2],
            ['customer_name'=>'Hana Drissi',     'customer_email'=>'hana@gmail.com',     'customer_phone'=>'+216 22 345 678','qty'=>3,'status'=>'shipped',  'payment'=>'paid',     'days'=>3],
            ['customer_name'=>'Youssef Mrad',    'customer_email'=>'y.mrad@moe.tn',      'customer_phone'=>'+216 20 456 789','qty'=>1,'status'=>'delivered','payment'=>'paid',     'days'=>5],
            ['customer_name'=>'Sonia Khelil',    'customer_email'=>'sonia@gmail.com',    'customer_phone'=>'+216 55 567 890','qty'=>2,'status'=>'delivered','payment'=>'paid',     'days'=>7],
            ['customer_name'=>'Sami Gharbi',     'customer_email'=>'sami@gmail.com',     'customer_phone'=>'+216 55 456 789','qty'=>1,'status'=>'pending',  'payment'=>'pending',  'days'=>8],
            ['customer_name'=>'Ines Ben Salah',  'customer_email'=>'ines@edu.tn',        'customer_phone'=>'+216 71 678 901','qty'=>4,'status'=>'shipped',  'payment'=>'paid',     'days'=>9],
            ['customer_name'=>'Tarek Haddad',    'customer_email'=>'tarek@gmail.com',    'customer_phone'=>'+216 22 789 012','qty'=>1,'status'=>'delivered','payment'=>'paid',     'days'=>12],
            ['customer_name'=>'Mariem Zouari',   'customer_email'=>'mariem@edu.tn',      'customer_phone'=>'+216 71 890 123','qty'=>2,'status'=>'confirmed','payment'=>'paid',     'days'=>14],
            ['customer_name'=>'Khaled Mansouri', 'customer_email'=>'k.mansouri@gmail.com','customer_phone'=>'+216 55 901 234','qty'=>1,'status'=>'pending', 'payment'=>'pending',  'days'=>15],
            ['customer_name'=>'Amira Bensalem',  'customer_email'=>'amira@ecole.tn',     'customer_phone'=>'+216 71 234 567','qty'=>1,'status'=>'delivered','payment'=>'paid',     'days'=>18],
            ['customer_name'=>'Nadia Sfar',      'customer_email'=>'nsfar@moe.tn',       'customer_phone'=>'+216 71 890 123','qty'=>2,'status'=>'cancelled','payment'=>'refunded', 'days'=>20],
            ['customer_name'=>'Hassan Boubaker', 'customer_email'=>'h.boubaker@edu.tn',  'customer_phone'=>'+216 71 678 901','qty'=>1,'status'=>'delivered','payment'=>'paid',     'days'=>22],
            ['customer_name'=>'Leila Jouini',    'customer_email'=>'leila@gmail.com',    'customer_phone'=>'+216 22 567 890','qty'=>3,'status'=>'delivered','payment'=>'paid',     'days'=>25],
            ['customer_name'=>'Karim Trabelsi',  'customer_email'=>'karim@gmail.com',    'customer_phone'=>'+216 20 345 678','qty'=>1,'status'=>'delivered','payment'=>'paid',     'days'=>28],
        ];

        $product = Product::where('active', true)->first();
        if (!$product) return;

        foreach ($orders as $o) {
            Order::create([
                'customer_name'   => $o['customer_name'],
                'customer_email'  => $o['customer_email'],
                'customer_phone'  => $o['customer_phone'],
                'product_id'      => $product->id,
                'quantity'        => $o['qty'],
                'total'           => round($product->price * $o['qty'], 2),
                'status'          => $o['status'],
                'payment_status'  => $o['payment'],
                'created_at'      => now()->subDays($o['days']),
                'updated_at'      => now()->subDays($o['days']),
            ]);
        }
    }
}
