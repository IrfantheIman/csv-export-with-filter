<?php

namespace App\Http\Controllers;

use App\Jobs\ExportCustomerJob;
use App\Models\Customer;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use League\Csv\Writer;

class CustomerExportController extends Controller
{
    public function export(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'fields' => 'required|array',
            'filter_value' => 'nullable|string|max:255',
        ]);

        // Get the selected filter fields and filter value
        $fields = $validated['fields'];
        $filterValue = $validated['filter_value'] ?? '';

        // File name for the generated CSV
        $fileName = 'customers.csv';

        // Dispatch the ExportCustomerJob with the selected fields and filter value
        ExportCustomerJob::dispatch($fields, $filterValue, $fileName);

        // Instead of showing a link, directly return the response to download the CSV
        return $this->downloadExportedFile($fields, $filterValue);
    }

    public function downloadExportedFile($fields, $filterValue)
    {
        // Create an in-memory file using php://temp stream
        $csv = Writer::createFromStream(fopen('php://temp', 'r+'));

        // Insert headers based on selected fields
        $csv->insertOne($fields);

        // Query customers with the specified filters and fields
        $query = Customer::query();

        if ($filterValue) {
            foreach ($fields as $field) {
                $query->orWhere($field, 'like', '%' . $filterValue . '%');
            }
        }

        // Export in chunks
        $query->chunk(100, function ($customers) use ($csv, $fields) {
            foreach ($customers as $customer) {
                $csv->insertOne($customer->only($fields));
            }
        });

        // Stream the file content directly to the browser
        $response = new StreamedResponse(function () use ($csv) {
            $csv->output(); // This will stream the CSV data to the browser for download
        });

        // Set headers to force the browser to download the file
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="customers.csv"');

        return $response;
    }
}
