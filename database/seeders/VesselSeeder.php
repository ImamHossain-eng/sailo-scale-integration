<?php

namespace Database\Seeders;

use App\Models\Party;
use App\Models\Vehicle;
use App\Models\Vessel;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VesselSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create a Default Client/Party
        $party = Party::create([
            'name' => 'BASHUNDHARA GROUP',
            'address' => 'Plot-3, Block-G, Umme Kulsum Road, Bashundhara R/A, Dhaka',
            'contact_person' => 'Mr. Zaman Chowdhury',
            'contact_number' => '01711223344',
        ]);

        Party::create([
            'name' => 'MEGHNA GROUP OF INDUSTRIES',
            'address' => 'Fresh Villa, House-15, Road-34, Gulshan-1, Dhaka',
            'contact_person' => 'Mr. Rafiqul Islam',
            'contact_number' => '01899887766',
        ]);

        // 2. Create a Default Vehicle
        Vehicle::create([
            'vehicle_number' => 'DHAKA-METRO-TA-12-3456',
            'default_driver_name' => 'Abul Kashem',
            'default_driver_phone' => '01912345678',
            'default_transport_name' => 'fresh logistics',
            'default_wheels_count' => 6,
        ]);

        // 3. Create an Active Unloading Ship (Billed daily at BDT 1000 and cargo BDT 40/ton)
        Vessel::create([
            'name' => 'M.V. AKBAR',
            'party_id' => $party->id,
            'status' => 'active',
            'arrival_date' => Carbon::now()->subDays(3),
            'unload_start_datetime' => Carbon::now()->subDays(2)->subHours(4), // Stayed 2.16 days (bills as 3 full days)
            'daily_rent_rate' => 1000.00,
            'cargo_rate_per_ton' => 40.00,
        ]);

        // 4. Create a Pending Ship (Not unloading yet, stay rent is NOT billed)
        Vessel::create([
            'name' => 'M.V. SONAR TORI',
            'party_id' => $party->id,
            'status' => 'pending',
            'arrival_date' => Carbon::now()->subDays(1),
            'daily_rent_rate' => 1000.00,
            'cargo_rate_per_ton' => 40.00,
        ]);
    }
}
