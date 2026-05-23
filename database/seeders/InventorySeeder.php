<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inventory;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 3. Mock Stock Inventory Data Matrix
        $mockStocks = [
            ['item_code' => 'PN-1001', 'description' => 'Grade 8 Heavy Hex Structural Bolt M24', 'uom' => 'PCS', 'available_qty' => 1000.00, 'specification' => 'A325 Steel'],
            ['item_code' => 'PN-1002', 'description' => 'Seamless Carbon Steel Pipe 4 Inch', 'uom' => 'METERS', 'available_qty' => 45.00, 'specification' => 'API 5L Grade B'],
            ['item_code' => 'PN-1003', 'description' => 'High Temperature Silicone Flange Gasket', 'uom' => 'PCS', 'available_qty' => 0.00, 'specification' => 'Viton-75'],
            ['item_code' => 'PN-1004', 'description' => 'Stainless Steel Ball Valve 2 Inch', 'uom' => 'PCS', 'available_qty' => 12.00, 'specification' => 'SS316'],
            ['item_code' => 'PN-1006', 'description' => 'Structural I-Beam 200mm x 100mm', 'uom' => 'METERS', 'available_qty' => 150.00, 'specification' => 'S355JR Carbon Steel'],
        ];

        foreach ($mockStocks as $stock) {
            Inventory::create($stock);
        }
    }

    
}
