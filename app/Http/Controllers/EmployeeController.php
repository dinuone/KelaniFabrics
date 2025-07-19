<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $employees = Employee::with('user')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'LIKE', "%$search%")
                      ->orWhere('last_name', 'LIKE', "%$search%")
                      ->orWhere('address', 'LIKE', "%$search%")
                      ->orWhere('contact_number', 'LIKE', "%$search%");
                });
            })
            ->paginate(10);

        return view('employee.index', compact('employees'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('employee.manage', compact('roles'));
    }

    public function edit(Employee $employee)
    {
        $roles = Role::all();
        $employee->load('user');
        return view('employee.manage', compact('employee', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users')->whereNull('deleted_at'),
            ],
            'password' => 'required|min:6',
            'roles' => 'required|array',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'address' => 'required|string',
            'dob' => 'required|date',
            'phoneNumber' => 'required|string',
            'joinDate' => 'required|date',
            'resignDate' => 'nullable|date|after_or_equal:joinDate',
        ]);

        DB::beginTransaction();
        try {
            // Create user
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'first_name' => $request->firstName,
                'last_name' => $request->lastName,
            ]);
            $user->assignRole($request->roles);

            // Create employee linked to user
            Employee::create([
                'first_name' => $request->firstName,
                'last_name' => $request->lastName,
                'address' => $request->address,
                'dob' => $request->dob,
                'contact_number' => $request->phoneNumber,
                'join_date' => $request->joinDate,
                'resign_date' => $request->resignDate,
                'user_id' => $user->id,
            ]);

            DB::commit();

            return redirect()->route('employee.index')->with('success', 'Employee created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to create employee.');
        }
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $employee->user_id,
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'address' => 'required|string',
            'dob' => 'required|date',
            'phoneNumber' => 'required|string',
            'joinDate' => 'required|date',
            'resignDate' => 'nullable|date|after_or_equal:joinDate',
        ]);

        DB::beginTransaction();
        try {
            // Update User
            $user = $employee->user;
            $user->update([
                'email' => $request->email,
            ]);
            $user->syncRoles($request->roles);

            // Update Employee
            $employee->update([
                'first_name' => $request->firstName,
                'last_name' => $request->lastName,
                'address' => $request->address,
                'dob' => $request->dob,
                'contact_number' => $request->phoneNumber,
                'join_date' => $request->joinDate,
                'resign_date' => $request->resignDate,
            ]);

            DB::commit();

            return redirect()->route('employee.index')->with('success', 'Employee updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to update employee.');
        }
    }

    public function destroy(Employee $employee)
    {
        DB::beginTransaction();
        try {
            // Delete user first
            if ($employee->user) {
                $employee->user->delete();
            }

            // Delete employee
            $employee->delete();

            DB::commit();

            return redirect()->route('employee.index')->with('success', 'Employee deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            return redirect()->route('employee.index')->with('error', 'Failed to delete employee.');
        }
    }
}
