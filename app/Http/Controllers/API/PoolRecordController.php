<?php

namespace App\Http\Controllers\API;

use App\CustomerType;
use App\Http\Controllers\Controller;
use App\Http\Resources\PoolRecordResource;
use App\PoolRecord;
use App\PoolRecordDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class PoolRecordController extends Controller
{
    public function index()
    {
        $pool_records = PoolRecord::orderBy('id', 'desc')->paginate(20);

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

    public function getStatistics(Request $request)
    {
        $customer_types = CustomerType::all();
        $select_raw_string = 'DATE(entry_date) AS day';
        foreach ($customer_types as $customer_type) {
            $select_raw_string .= ',SUM(CASE WHEN (customer_type_id = ' . $customer_type->id . ' AND exit_date IS NULL) then quantity else 0 end) as type_' . $customer_type->id . '_active_total';
            $select_raw_string .= ',SUM(CASE WHEN (customer_type_id = ' . $customer_type->id . ') then quantity else 0 end) as type_' . $customer_type->id . '_total';
        }
        $select_raw_string .= ',SUM(quantity) AS total';

        $statistics = PoolRecordDetail::selectRaw($select_raw_string)->when($request->day, function ($query) use ($request) {
            $query->whereDate('entry_date', $request->day);
        })->groupBy('day')->orderBy('day', 'desc')->paginate(20);

        $data = [
            'customer_types' => $customer_types,
            'statistics' => $statistics
        ];

        return response()->json($data);
    }
}
