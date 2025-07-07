<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Customer::select('cust_fname', 'cust_lname', 'address', 'contact_number', 'email', 'gender')->get();
    }

    public function headings(): array
    {
        return [
            'First Name',
            'Last Name',
            'Address',
            'Contact Number',
            'Email',
            'Gender'
        ];
    }
}

