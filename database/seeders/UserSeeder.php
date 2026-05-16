<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // Admin
            ['name' => 'Maram Admin',      'email' => 'admin@frizzly.tn',          'role' => 'admin',   'status' => 'active'],

            // Enseignants actifs
            ['name' => 'Amira Bensalem',   'email' => 'amira.bensalem@ecole.tn',   'role' => 'enseignant', 'status' => 'active'],
            ['name' => 'Karim Trabelsi',   'email' => 'karim.trabelsi@gmail.com',  'role' => 'enseignant', 'status' => 'active'],
            ['name' => 'Nadia Sfar',       'email' => 'nadia.sfar@moe.tn',         'role' => 'enseignant', 'status' => 'active'],
            ['name' => 'Mohamed Ferjani',  'email' => 'm.ferjani@edu.tn',          'role' => 'enseignant', 'status' => 'active'],
            ['name' => 'Sonia Khelil',     'email' => 'sonia.khelil@gmail.com',    'role' => 'enseignant', 'status' => 'active'],
            ['name' => 'Hassan Boubaker',  'email' => 'h.boubaker@edu.tn',         'role' => 'enseignant', 'status' => 'active'],
            ['name' => 'Leila Jouini',     'email' => 'leila.jouini@gmail.com',    'role' => 'enseignant', 'status' => 'active'],
            ['name' => 'Tarek Haddad',     'email' => 'tarek.haddad@gmail.com',    'role' => 'enseignant', 'status' => 'active'],
            ['name' => 'Ines Ben Salah',   'email' => 'ines.bensalah@edu.tn',      'role' => 'enseignant', 'status' => 'active'],
            ['name' => 'Youssef Mrad',     'email' => 'y.mrad@moe.tn',             'role' => 'enseignant', 'status' => 'active'],

            // Utilisateurs inactifs
            ['name' => 'Rym Chaabane',     'email' => 'rym.chaabane@gmail.com',    'role' => 'user',       'status' => 'inactive'],
            ['name' => 'Sami Gharbi',      'email' => 'sami.gharbi@gmail.com',     'role' => 'user',       'status' => 'inactive'],

            // Utilisateurs actifs
            ['name' => 'Hana Drissi',      'email' => 'hana.drissi@gmail.com',     'role' => 'user',       'status' => 'active'],
            ['name' => 'Mariem Zouari',    'email' => 'mariem.zouari@edu.tn',      'role' => 'enseignant', 'status' => 'active'],
            ['name' => 'Khaled Mansouri',  'email' => 'k.mansouri@gmail.com',      'role' => 'enseignant', 'status' => 'active'],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                array_merge($data, ['password' => Hash::make('password123')])
            );
        }
    }
}
