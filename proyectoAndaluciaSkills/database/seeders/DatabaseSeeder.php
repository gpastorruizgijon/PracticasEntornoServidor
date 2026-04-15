<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
//     public function run(): void
//     {
//         // 1. Crear Conductores
//         $c1 = User::create([
//             'name' => 'Juan Pérez',
//             'email' => 'juan@logistica.com',
//             'password' => Hash::make('password'),
//             'address' => 'Calle Falsa 123',
//             'phone' => '600111222',
//             'license_type' => 'C'
//         ]);

//         $c2 = User::create([
//             'name' => 'María García',
//             'email' => 'maria@logistica.com',
//             'password' => Hash::make('password'),
//             'address' => 'Avenida Principal 45',
//             'phone' => '600333444',
//             'license_type' => 'C+E'
//         ]);

//         // 2. Crear Plantas de Reciclaje
//         $p1 = RecyclingPlant::create([
//             'name' => 'EcoPlanta Sevilla',
//             'address' => 'Polígono Industrial Torneo',
//             'city' => 'Sevilla',
//             'max_capacity_kg' => 50000.00
//         ]);

//         $p2 = RecyclingPlant::create([
//             'name' => 'Recicla Málaga',
//             'address' => 'Calle del Reciclaje 8',
//             'city' => 'Málaga',
//             'max_capacity_kg' => 35000.00
//         ]);

//         // 3. Crear Camiones y asignar conductores
//         $t1 = Truck::create([
//             'plate' => '1234-ABC',
//             'model' => 'Volvo FE Electric',
//             'max_load_kg' => 12000,
//             'user_id' => $c1->id
//         ]);

//         $t2 = Truck::create([
//             'plate' => '5678-XYZ',
//             'model' => 'Mercedes Econic',
//             'max_load_kg' => 15000,
//             'user_id' => $c2->id
//         ]);

//         // 4. Crear registros de Basura
//         $b1 = Waste::create([
//             'type' => 'Plástico',
//             'kilos' => 1250.5,
//             'origin_address' => 'Supermercado Central, Sevilla',
//             'is_hazardous' => false
//         ]);

//         $b2 = Waste::create([
//             'type' => 'Vidrio',
//             'kilos' => 800.0,
//             'origin_address' => 'Zona de Restauración, Puerto Banús',
//             'is_hazardous' => false
//         ]);

//         // 5. Crear Envíos (Historial)
//         Shipment::create([
//             'waste_id' => $b1->id,
//             'truck_id' => $t1->id,
//             'recycling_plant_id' => $p1->id,
//             'kilos_transported' => 1250.5,
//             'pickup_date' => now()->subHours(5),
//             'delivery_date' => now()->subHours(1),
//             'status' => 'delivered'
//         ]);

//         Shipment::create([
//             'waste_id' => $b2->id,
//             'truck_id' => $t2->id,
//             'recycling_plant_id' => $p2->id,
//             'kilos_transported' => 800.0,
//             'pickup_date' => now(),
//             'delivery_date' => now()->addHours(3),
//             'status' => 'in_transit'
//         ]);
//     }
// }


public function run(): void
{
    // 1. Admin
    \App\Models\User::factory()->create([
        'name' => 'Gines Jefe',
        'email' => 'admin@admin.com',
        'password' => bcrypt('123456'),
        'role' => 'admin',
    ]);

    \App\Models\User::factory()->create([
        'name' => 'Gines Conductor',
        'email' => 'conductor@conductor.com',
        'password' => bcrypt('123456'),
        'role' => 'conductor',
    ]);

    \App\Models\User::factory()->create([
        'name' => 'Gines Usuario',
        'email' => 'usuario@usuario.com',
        'password' => bcrypt('123456'),
        'role' => 'user',
    ]);

    // 2. Conductores (10)
    \App\Models\User::factory(10)->create(['role' => 'conductor']);

    // 3. Plantas (5)
    \App\Models\RecyclingPlant::factory(5)->create();

    // 4. Camiones (Asignar uno a cada conductor o crear 8 aleatorios)
    \App\Models\Truck::factory(8)->create();

    // 5. Residuos (30)
    \App\Models\Waste::factory(30)->create();

    // 6. Envíos (Historial de logística)
    \App\Models\Shipment::factory(20)->create();

    // 7. Residuos sin asignar (disponibles en dashboard)
    \App\Models\Waste::factory(15)->create(['shipment_id' => null]);
}

// CONTRASEÑA PARA CONDUCTORES --> conductor2024
}