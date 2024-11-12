<?php

// app/Jobs/ExportCustomerChunk.php
//namespace App\Jobs;

//use App\Models\Customer;
//use League\Csv\Writer;
//use Illuminate\Support\Facades\Storage;

//class ExportCustomerJob extends Job
{
  //  protected $fields;
   // protected $filterValue;

    //public function __construct($fields, $filterValue)
    {
     //   $this->fields = $fields;
      //  $this->filterValue = $filterValue;
    }

    //public function handle()
    {
        // Set the CSV file path
       // $filePath = storage_path('app/exports/customers.csv');

        // Create a new CSV writer
       // $csv = Writer::createFromPath($filePath, 'w+');

        // Add headers to CSV file
      //  $csv->insertOne(['ID', 'Name', 'Email', 'Phone', 'Address']);

        // Build the query based on selected fields and filter value
      //  $query = Customer::query();

       // foreach ($this->fields as $field) {
          //  if ($this->filterValue) {
             //   $query->where($field, 'like', '%' . $this->filterValue . '%');
            }
        }

        // Process the query in chunks to avoid memory overload
        //$query->chunk(100, function ($customers) use ($csv) {
          //  foreach ($customers as $customer) {
             //   $csv->insertOne([
                //  $customer->id,
                //    $customer->name,
                //  $customer->email,
                //  $customer->phone,
                //  $customer->address,
                ]);
            }
        });

        // Optionally, store the file or send a notification
      //  \Log::info("Export completed. File stored at: " . $filePath);
    }
}
