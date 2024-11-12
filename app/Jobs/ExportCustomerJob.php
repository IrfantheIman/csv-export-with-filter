<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Csv\Writer;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;

class ExportCustomerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fields;
    protected $filterValue;
    protected $fileName;

    public function __construct(array $fields, string $filterValue = null, string $fileName = 'customers.csv')
    {
        $this->fields = $fields;
        $this->filterValue = $filterValue;
        $this->fileName = $fileName;
    }

    public function handle()
    {
        // We use a php://temp stream to hold the CSV data in memory
        $csv = Writer::createFromStream(fopen('php://temp', 'r+'));

        // Insert headers
        $csv->insertOne($this->fields);

        // Query customers with the specified filters and fields
        $query = Customer::query();

        if ($this->filterValue) {
            foreach ($this->fields as $field) {
                $query->orWhere($field, 'like', '%' . $this->filterValue . '%');
            }
        }

        // Export in chunks to avoid memory issues
        $query->chunk(100, function ($customers) use ($csv) {
            foreach ($customers as $customer) {
                $csv->insertOne($customer->only($this->fields));
            }
        });

        // Log for confirmation
        Log::info("CSV export completed in memory.");
    }
}

