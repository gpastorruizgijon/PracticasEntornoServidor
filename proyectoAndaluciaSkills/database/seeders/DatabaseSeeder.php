<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\RecyclingPlant;
use App\Models\Truck;
use App\Models\Waste;
use App\Models\Shipment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─────────────────────────────────────────────
        // 1. USUARIOS
        // ─────────────────────────────────────────────

        $admin = User::create([
            'name'         => 'Ginés Pastor',
            'email'        => 'admin@admin.com',
            'password'     => Hash::make('123456'),
            'role'         => 'admin',
            'phone'        => '600000001',
            'address'      => 'Calle Administración 1, Sevilla',
            'license_type' => 'B',
        ]);

        $usuarioNormal = User::create([
            'name'         => 'Ana Martínez',
            'email'        => 'usuario@usuario.com',
            'password'     => Hash::make('123456'),
            'role'         => 'user',
            'phone'        => '600000002',
            'address'      => 'Avenida de la Constitución 10, Sevilla',
            'license_type' => 'B',
        ]);

        $c1 = User::create([
            'name'         => 'Carlos Ruiz',
            'email'        => 'conductor@conductor.com',
            'password'     => Hash::make('123456'),
            'role'         => 'conductor',
            'phone'        => '611111111',
            'address'      => 'Calle Huelva 3, Sevilla',
            'license_type' => 'C',
        ]);

        $c2 = User::create([
            'name'         => 'María López',
            'email'        => 'maria.lopez@logistica.com',
            'password'     => Hash::make('123456'),
            'role'         => 'conductor',
            'phone'        => '622222222',
            'address'      => 'Calle Granada 7, Málaga',
            'license_type' => 'C+E',
        ]);

        $c3 = User::create([
            'name'         => 'Pedro Sánchez',
            'email'        => 'pedro.sanchez@logistica.com',
            'password'     => Hash::make('123456'),
            'role'         => 'conductor',
            'phone'        => '633333333',
            'address'      => 'Avenida de Andalucía 22, Córdoba',
            'license_type' => 'C',
        ]);

        $c4 = User::create([
            'name'         => 'Laura Fernández',
            'email'        => 'laura.fernandez@logistica.com',
            'password'     => Hash::make('123456'),
            'role'         => 'conductor',
            'phone'        => '644444444',
            'address'      => 'Calle Real 5, Cádiz',
            'license_type' => 'C+E',
        ]);

        // ─────────────────────────────────────────────
        // 2. PLANTAS DE RECICLAJE
        // ─────────────────────────────────────────────

        $p1 = RecyclingPlant::create([
            'name'            => 'EcoPlanta Sevilla',
            'address'         => 'Polígono Industrial Torneo, Nave 12',
            'city'            => 'Sevilla',
            'max_capacity_kg' => 50000,
        ]);

        $p2 = RecyclingPlant::create([
            'name'            => 'Recicla Málaga',
            'address'         => 'Calle del Reciclaje 8, Polígono Sur',
            'city'            => 'Málaga',
            'max_capacity_kg' => 35000,
        ]);

        $p3 = RecyclingPlant::create([
            'name'            => 'GreenCenter Córdoba',
            'address'         => 'Avenida Medina Azahara 40',
            'city'            => 'Córdoba',
            'max_capacity_kg' => 40000,
        ]);

        $p4 = RecyclingPlant::create([
            'name'            => 'EcoGestión Cádiz',
            'address'         => 'Puerto Industrial, Sector 3',
            'city'            => 'Cádiz',
            'max_capacity_kg' => 25000,
        ]);

        // ─────────────────────────────────────────────
        // 3. CAMIONES
        // ─────────────────────────────────────────────

        $t1 = Truck::create([
            'plate'       => '1234-ABC',
            'model'       => 'Volvo FE Electric',
            'max_load_kg' => 12000,
            'user_id'     => $c1->id,
        ]);

        $t2 = Truck::create([
            'plate'       => '5678-XYZ',
            'model'       => 'Mercedes Econic',
            'max_load_kg' => 15000,
            'user_id'     => $c2->id,
        ]);

        $t3 = Truck::create([
            'plate'       => '9012-MNO',
            'model'       => 'Scania P 340',
            'max_load_kg' => 14000,
            'user_id'     => $c3->id,
        ]);

        $t4 = Truck::create([
            'plate'       => '3456-PQR',
            'model'       => 'DAF CF 440',
            'max_load_kg' => 16000,
            'user_id'     => $c4->id,
        ]);

        // Camión sin conductor asignado
        Truck::create([
            'plate'       => '7890-STU',
            'model'       => 'Renault T 480',
            'max_load_kg' => 13000,
            'user_id'     => null,
        ]);

        // ─────────────────────────────────────────────
        // 4. RESIDUOS DISPONIBLES (sin envío asignado)
        // ─────────────────────────────────────────────

        $w1 = Waste::create([
            'type'           => 'Plástico',
            'kilos'          => 800,
            'origin_address' => 'Supermercado Mercadona, Calle San Fernando 12, Sevilla',
            'is_hazardous'   => false,
            'shipment_id'    => null,
            'user_id'        => $usuarioNormal->id,
        ]);

        $w2 = Waste::create([
            'type'           => 'Vidrio',
            'kilos'          => 500,
            'origin_address' => 'Restaurante El Aljarafe, Avenida Principal 45, Sevilla',
            'is_hazardous'   => false,
            'shipment_id'    => null,
            'user_id'        => $usuarioNormal->id,
        ]);

        $w3 = Waste::create([
            'type'           => 'Papel y Cartón',
            'kilos'          => 1200,
            'origin_address' => 'Empresa Logística Sur, Polígono Calonge, Cádiz',
            'is_hazardous'   => false,
            'shipment_id'    => null,
            'user_id'        => $usuarioNormal->id,
        ]);

        $w4 = Waste::create([
            'type'           => 'Residuos Químicos',
            'kilos'          => 350,
            'origin_address' => 'Laboratorio Analítica Andaluza, Málaga',
            'is_hazardous'   => true,
            'shipment_id'    => null,
            'user_id'        => $usuarioNormal->id,
        ]);

        $w5 = Waste::create([
            'type'           => 'Metal',
            'kilos'          => 2000,
            'origin_address' => 'Taller Mecánico Hermanos Torres, Córdoba',
            'is_hazardous'   => false,
            'shipment_id'    => null,
            'user_id'        => $usuarioNormal->id,
        ]);

        // ─────────────────────────────────────────────
        // 5. RESIDUOS CON ENVÍO (para los envíos de abajo)
        // ─────────────────────────────────────────────

        $w6 = Waste::create([
            'type'           => 'Plástico',
            'kilos'          => 1250,
            'origin_address' => 'Fábrica Envases del Sur, Sevilla',
            'is_hazardous'   => false,
            'shipment_id'    => null,
            'user_id'        => $usuarioNormal->id,
        ]);

        $w7 = Waste::create([
            'type'           => 'Vidrio',
            'kilos'          => 900,
            'origin_address' => 'Distribuidora Bebidas Málaga S.L.',
            'is_hazardous'   => false,
            'shipment_id'    => null,
            'user_id'        => $usuarioNormal->id,
        ]);

        $w8 = Waste::create([
            'type'           => 'Residuos Químicos',
            'kilos'          => 400,
            'origin_address' => 'Industria Química Guadalquivir, Córdoba',
            'is_hazardous'   => true,
            'shipment_id'    => null,
            'user_id'        => $usuarioNormal->id,
        ]);

        $w9 = Waste::create([
            'type'           => 'Papel y Cartón',
            'kilos'          => 750,
            'origin_address' => 'Imprenta Central, Cádiz',
            'is_hazardous'   => false,
            'shipment_id'    => null,
            'user_id'        => $usuarioNormal->id,
        ]);

        // ─────────────────────────────────────────────
        // 6. ENVÍOS MANUALES
        // ─────────────────────────────────────────────

        // Entregado
        $s1 = Shipment::create([
            'type'               => 'Plástico',
            'truck_id'           => $t1->id,
            'recycling_plant_id' => $p1->id,
            'kilos_transported'  => 1250,
            'pickup_date'        => now()->subDays(3),
            'delivery_date'      => now()->subDays(2),
            'status'             => 'delivered',
        ]);
        $w6->update(['shipment_id' => $s1->id]);

        // En tránsito
        $s2 = Shipment::create([
            'type'               => 'Vidrio',
            'truck_id'           => $t2->id,
            'recycling_plant_id' => $p2->id,
            'kilos_transported'  => 900,
            'pickup_date'        => now()->subHours(4),
            'delivery_date'      => null,
            'status'             => 'in_transit',
        ]);
        $w7->update(['shipment_id' => $s2->id]);

        // Pendiente (residuos peligrosos — conductor con C+E)
        $s3 = Shipment::create([
            'type'               => 'Residuos Químicos',
            'truck_id'           => $t2->id,
            'recycling_plant_id' => $p3->id,
            'kilos_transported'  => 400,
            'pickup_date'        => now()->addDay(),
            'delivery_date'      => null,
            'status'             => 'pending',
        ]);
        $w8->update(['shipment_id' => $s3->id]);

        // Pendiente
        $s4 = Shipment::create([
            'type'               => 'Papel y Cartón',
            'truck_id'           => $t3->id,
            'recycling_plant_id' => $p4->id,
            'kilos_transported'  => 750,
            'pickup_date'        => now()->addDays(2),
            'delivery_date'      => null,
            'status'             => 'pending',
        ]);
        $w9->update(['shipment_id' => $s4->id]);

        // ═════════════════════════════════════════════
        // DATOS ALEATORIOS (factories)
        // ═════════════════════════════════════════════

        // 7. Conductores adicionales aleatorios
        $conductoresExtra = User::factory(6)->create(['role' => 'conductor']);

        // 8. Usuarios normales adicionales
        User::factory(4)->create(['role' => 'user']);

        // 9. Plantas adicionales
        RecyclingPlant::factory(3)->create();

        // 10. Camiones: uno por cada conductor extra (sin camión aún)
        foreach ($conductoresExtra as $conductor) {
            Truck::factory()->create(['user_id' => $conductor->id]);
        }

        // 11. Residuos disponibles aleatorios (sin envío asignado)
        //     user_id apunta a usuarios normales o conductores existentes
        $todosLosUsuarios = User::whereIn('role', ['user', 'conductor'])->pluck('id');
        Waste::factory(20)->create([
            'shipment_id' => null,
            'user_id'     => fn() => $todosLosUsuarios->random(),
        ]);

        // 12. Envíos aleatorios
        //     ShipmentFactory.afterCreating vincula residuos del mismo tipo
        //     y actualiza kilos_transported automáticamente
        Shipment::factory(15)->create();
    }
}

// CONTRASEÑA PARA CONDUCTORES --> conductor2024
