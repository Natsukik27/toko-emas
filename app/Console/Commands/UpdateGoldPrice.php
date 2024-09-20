<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GoldPrice;
use Illuminate\Support\Facades\Http;

class UpdateGoldPrice extends Command
{
    protected $signature = 'goldprice:update';
    protected $description = 'Update the gold price from the market API';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
            // Replace with the actual API endpoint
            $response = Http::get('https://api.metalpriceapi.com/v1/latest?api_key=2c26b5953e7b95e13496bc96edefb01a&base=USD&currencies=EUR,XAU,XAG');
            $rates = $response->json('rates');

            // Get the price in USD per ounce
            $pricePerOunce = $rates['USDXAU'] ?? null;

            if ($pricePerOunce === null) {
                $this->error('Price data is missing from API response.');
                return;
            }

            // Convert price per ounce to price per gram
            // 1 ounce = 31.1035 grams
            $pricePerGram = $pricePerOunce / 31.1035;

            GoldPrice::updateOrCreate(
                ['id' => 1],
                ['price' => $pricePerGram]
            );

            $this->info('Gold price updated successfully.');
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
        }
    }
}