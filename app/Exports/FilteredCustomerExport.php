<?php

namespace App\Exports;
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FilteredCustomerExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Customer::query();

        if ($this->request->filled('name')) {
            $query->where(function ($q) {
                $q->where('cust_fname', 'like', '%' . $this->request->name . '%')
                  ->orWhere('cust_lname', 'like', '%' . $this->request->name . '%');
            });
        }

        if ($this->request->filled('email')) {
            $query->where('email', 'like', '%' . $this->request->email . '%');
        }

        if ($this->request->filled('gender')) {
            $query->where('gender', $this->request->gender);
        }

        return $query->get([
            'cust_fname',
            'cust_lname',
            'address',
            'email',
            'contact_number',
            'gender'
        ]);
    }

    public function headings(): array
    {
        return ['First Name', 'Last Name', 'Address', 'Email', 'Contact', 'Gender'];
    }
}
