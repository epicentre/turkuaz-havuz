<?php

namespace App\Http\Controllers\API;

use App\CustomerType;
use App\Http\Controllers\Controller;
use App\Http\Resources\PoolRecordResource;
use App\PoolRecord;
use App\PoolRecordDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class PoolRecordController extends Controller
{
    public function index(Request $request)
    {
        $pool_records = PoolRecord::when(($request->searchText && trim($request->searchText) !== ''), function($query) use ($request) {
            $query->where('voucher_no', 'like', '%' . $request->searchText .'%');
        })->orderBy('id', 'desc')->paginate(10);

        return PoolRecordResource::collection($pool_records);
    }

    public function store(Request $request)
    {
        $rules = [
            'records' => 'required|array|min:1',
        ];
        $this->validate($request, $rules);

        $records = $request->records;
		$last_voucher_no = PoolRecord::latest()->pluck('voucher_no')->first() ?? 1;
        $voucher_no = ((int)$last_voucher_no) + 1;

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

            $pool_record['customer_count'] += $record['quantity'];
            $pool_record['total_price'] += $record['price'];

            $pool_record_detail[] = [
                'customer_type_id' => $record['customer_type_id'],
                'quantity' => $record['quantity'],
                'price' => $record['price'],
                'entry_date' => now()
            ];
        }

        if (count($pool_record_detail) < 1) {
            throw ValidationException::withMessages(['customer_type' => 'En az 1 müşteri olmalıdır.']);
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
        $is_today = $request->today === 'true';
        $customer_types = CustomerType::all();
        $select_raw_string = 'DATE(entry_date) AS day';
        foreach ($customer_types as $customer_type) {
            // Eğer bugünün verisi alınacaksa aktif kişi sayısı alınıyor.
            if ($is_today) {
                $select_raw_string .= ',SUM(CASE WHEN (customer_type_id = ' . $customer_type->id . ' AND exit_date IS NULL) then quantity else 0 end) as type_' . $customer_type->id . '_active_total';
            }

            $select_raw_string .= ',SUM(CASE WHEN (customer_type_id = ' . $customer_type->id . ') then quantity else 0 end) as type_' . $customer_type->id . '_total';
        }
        if ($is_today) {
            $select_raw_string .= ',SUM(CASE WHEN (exit_date IS NULL) then quantity else 0 end) as active_total';
        }
        $select_raw_string .= ',SUM(quantity) AS total';

        $statistics_query = PoolRecordDetail::query();
        $statistics_query->selectRaw($select_raw_string);
        // Eğer bugün için veri isteniyorsa tek veri hepsi ise paginate edilmiş şekilde gönderiliyor.
        if ($is_today) {
            $statistics = $statistics_query->whereDate('entry_date', now()->format('Y-m-d'))->groupBy('day')->first();
        } else {
            $statistics = $statistics_query->groupBy('day')->orderBy('day', 'desc')->paginate(20);
        }

        $data = [
            'customer_types' => $customer_types,
            'statistics' => $statistics
        ];

        return response()->json($data);
    }
}
