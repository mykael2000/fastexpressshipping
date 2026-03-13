<?php
namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'wallet_btc', 'label' => 'Bitcoin (BTC) Wallet Address', 'group' => 'crypto', 'value' => ''],
            ['key' => 'wallet_eth', 'label' => 'Ethereum (ETH) Wallet Address', 'group' => 'crypto', 'value' => ''],
            ['key' => 'wallet_usdt_trc20', 'label' => 'USDT (TRC20) Wallet Address', 'group' => 'crypto', 'value' => ''],
            ['key' => 'site_name', 'label' => 'Site Name', 'group' => 'general', 'value' => 'Fast Express Shipping'],
            ['key' => 'contact_email', 'label' => 'Contact Email', 'group' => 'general', 'value' => 'support@fastexpressshipping.com'],
            ['key' => 'contact_phone', 'label' => 'Contact Phone', 'group' => 'general', 'value' => '+1 (800) 555-0199'],
            ['key' => 'contact_address', 'label' => 'Office Address', 'group' => 'general', 'value' => '123 Logistics Way, Suite 400, Atlanta, GA 30301, USA'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::firstOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
