<?php

namespace Database\Seeders;

use App\Models\CompanySetting;
use Illuminate\Database\Seeder;

class CompanySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanySetting::create([
            'company_name' => 'SAILOGHAT DIGITAL SCALE',
            'company_address' => 'Sailoghat, Ghorashal, Narsingdi',
            'company_phone' => '+8801712345678',
            'company_email' => 'info@sailoscale.com',
            'receipt_footer_text' => 'Thank you for using Sailoghat Digital Scale. Have a safe journey!',
        ]);
    }
}
