<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InventoryExport;
use App\Exports\SalesExport;

class ExportController extends Controller
{
    public function exportInventory()
    {
        return Excel::download(new InventoryExport, 'inventory.xlsx');
    }

    public function exportSales()
    {
        return Excel::download(new SalesExport, 'sales.xlsx');
    }
}
