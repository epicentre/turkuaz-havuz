<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PoolRecordResource;
use App\PoolRecord;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PoolRecordController extends Controller
{
    public function index()
    {
        $pool_records = PoolRecord::paginate(20);

        return PoolRecordResource::collection($pool_records);
    }

    public function store(Request $request)
    {
        $rules = [
            'records' => 'required|array|min:1',
        ];
        $this->validate($request, $rules);

        $records = $request->records;
        $voucher_no = date('d-m-y-') . rand(10000, 99999);

        $pool_record = [
            'voucher_no' => $voucher_no,
            'customer_count' => 0,
            'total_price' => 0,
            'status' => 0,
            'day' => now()
        ];
        $pool_record_detail = [];
        foreach ($records as $record) {
            if (!isset($record['quantity']) || $record['quantity'] < 1) {
                continue;
            }

            $pool_record['customer_count'] += 1;
            $pool_record['total_price'] += $record['price'];

            $pool_record_detail[] = [
                'customer_type_id' => $record['customer_type_id'],
                'quantity' => $record['quantity'],
                'price' => $record['price'],
                'entry_date' => now()
            ];
        }

        $pool_record = PoolRecord::create($pool_record);
        $pool_record->detail()->createMany($pool_record_detail);

        // $pool_record->load('detail');

        return (new PoolRecordResource($pool_record))->response()->setStatusCode(201);
    }

    public function show($id)
    {
        $pool_record = PoolRecord::findOrFail($id);
        $pool_record->load('detail.customerType');

        return new PoolRecordResource($pool_record);
    }

    public function update(Request $request, $id)
    {
        $pool_record = PoolRecord::findOrFail($id);

        if ($pool_record->exit_date === null) {
            $pool_record->status = 1;
            $pool_record->save();

            $pool_record->detail()->update(['exit_date' => now()]);
        }

        return new PoolRecordResource($pool_record);
    }

    public function destroy($id)
    {
        $pool_record = PoolRecord::findOrFail($id);

        $pool_record->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

}
