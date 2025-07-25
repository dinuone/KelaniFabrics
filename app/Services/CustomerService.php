<?php

namespace App\Services;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;

class CustomerService
{

    public function getAll($search = null)
    {
        $query = Customer::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('cust_fname', 'LIKE', "%{$search}%")
                  ->orWhere('cust_lname', 'LIKE', "%{$search}%")
                  ->orWhere('address', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('gender', 'LIKE', "%{$search}%");
            });
        }
        return $query->paginate(10);
        //return Customer::paginate(10);
    }


    public function storeCustomer(
        string $custFName,
        string $custLName,
        string $address,
        string $email,
        string $gender,
        string $contactNumber
    ): array {
        try {
            // Check if a customer with this contact exists (including soft deleted)
            $existingCustomer = Customer::withTrashed()
                ->where('contact_number', $contactNumber)
                ->first();

            if ($existingCustomer) {
                return ['error', 'Contact number already used by an existing or deleted customer'];
            }

            Customer::create([
                'cust_fname' => $custFName,
                'cust_lname' => $custLName,
                'address' => $address,
                'email' => $email,
                'gender' => $gender,
                'contact_number' => $contactNumber,
            ]);

            return ['success', 'Customer created successfully'];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ['error', 'Something went wrong'];
        }
    }


    public function updateCustomer(
        object $customer,
        string $custFName,
        string $custLName,
        string $address,
        string $email,
        string $gender,
        string $contactNumber
    ): array {
        try {
       
            $customer->update([
                'cust_fname' => $custFName,
                'cust_lname' => $custLName,
                'address' => $address,
                'email' => $email,
                'gender' => $gender,
                'contact_number' => $contactNumber,
            ]);

            return ['success', 'Customer updated successfully'];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ['error', 'Something went wrong'];
        }
    }


    public function deleteCustomer(object $customer): array
    {
        try {

            $customer->delete();
            return ['success', 'Customer deleted successfully'];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ['error', 'Something went wrong'];
        }
    }
}
