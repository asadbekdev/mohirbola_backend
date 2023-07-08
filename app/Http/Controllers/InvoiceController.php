<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Exception;
use Illuminate\Http\Request;

class InvoiceController
{
    public function sendInvoice(Request $request)
    {
        $body = $request->json()->all();
        $user = $request->user();
        try {
            Invoice::query()->create([
                'parent_id' => $user->parent->id,
                'children_id' => $user->id,
                'course_id' => $body['course_id'],
                'bought' => false
            ]);
            return response()->json(['status' => 200, 'message' => 'Success'])->setStatusCode(200);
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Error creating invoice'])->setStatusCode(500);
        }
    }

    public function getInvoices(Request $request)
    {
        $user = $request->user();
        $invoices = Invoice::query()
            ->select(['invoices.children_id', 'invoices.course_id', 'childrens.name as children_name', 'childrens.image as image', 'invoices.created_at'])
            ->leftJoin('childrens', 'invoices.children_id', '=', 'childrens.id')
            ->where('invoices.parent_id', '=', $user->id)
            ->get();

        return response()->json(['invoices' => $invoices])->setStatusCode(200);
    }
}
