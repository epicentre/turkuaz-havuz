<?php

namespace App\Http\Controllers\API;

use App\CustomerType;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerTypeResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerTypeController extends Controller
{
    public function index()
    {
        $customer_types = CustomerType::all();

        return CustomerTypeResource::collection($customer_types);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'price' => 'required'
        ];
        $this->validate($request, $rules);

        $customer_type = CustomerType::create($request->all());

        return (new CustomerTypeResource($customer_type))->response()->setStatusCode(201);
    }

    public function show($id)
    {
        $customer_type = CustomerType::findOrFail($id);

        return new CustomerTypeResource($customer_type);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'price' => 'required'
        ];
        $this->validate($request, $rules);

        $customer_type = CustomerType::findOrFail($id);

        $customer_type->update($request->all());

        return new CustomerTypeResource($customer_type);
    }

    public function destroy($id)
    {
        $customer_type = CustomerType::findOrFail($id);

        $customer_type->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
