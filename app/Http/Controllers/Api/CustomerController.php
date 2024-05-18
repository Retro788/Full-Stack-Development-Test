<?php

namespace App\Http\Controllers\Api;

use App\Enums\CustomerStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerListResource;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');

        $query = Customer::query()
            ->with('user')
            ->orderBy("customers.$sortField", $sortDirection);
        if ($search) {
            $query
                ->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$search}%")
                ->join('users', 'customers.user_id', '=', 'users.id')
                ->orWhere('users.email', 'like', "%{$search}%")
                ->orWhere('customers.phone', 'like', "%{$search}%");
        }

        $paginator = $query->paginate($perPage);

        return CustomerListResource::collection($paginator);
    }
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }
    public function update(CustomerRequest $request, Customer $customer)
    {
        $customerData = $request->validated();
        $customerData['updated_by'] = $request->user()->id;
        $customerData['status'] = $customerData['status'] ? CustomerStatus::Active->value : CustomerStatus::Disabled->value;
        

        DB::beginTransaction();
        

        DB::commit();

        return new CustomerResource($customer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->noContent();
    }

   
}