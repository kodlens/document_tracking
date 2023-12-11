<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DocumentTrackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            [
                'document_id' => 1,
                'route_id' => 1,
                'route_detail_id' => 1,
                'office_id' => 1,
                'order_no' => 1,
                'is_origin' => 1,
                'is_last' => 0,
                'is_forward_from' => 0,
                'is_received' => 0,
                'datetime_received' => null,
                'receive_remarks' => null,
                'is_process' => 0,
                'datetime_process' => null,
                'process_remarks' => null,
                'is_done' => 0,
                'datetime_done' => null,
                'done_remarks' => null,
                'is_forwarded' => 0,
                'datetime_forwarded' => null,
                'forward_remarks' => null,
                'back_remarks' => null,
                'back_datetime' => null,
            ],
            [
                'document_id' => 1,
                'route_id' => 1,
                'route_detail_id' => 2,
                'office_id' => 2,
                'order_no' => 2,
                'is_origin' => 0,
                'is_last' => 0,
                'is_forward_from' => 0,
                'is_received' => 0,
                'datetime_received' => null,
                'receive_remarks' => null,
                'is_process' => 0,
                'datetime_process' => null,
                'process_remarks' => null,
                'is_done' => 0,
                'datetime_done' => null,
                'done_remarks' => null,
                'is_forwarded' => 0,
                'datetime_forwarded' => null,
                'forward_remarks' => null,
                'back_remarks' => null,
                'back_datetime' => null,
            ],
            [
                'document_id' => 1,
                'route_id' => 1,
                'route_detail_id' => 3,
                'office_id' => 3,
                'order_no' => 3,
                'is_origin' => 0,
                'is_last' => 0,
                'is_forward_from' => 0,
                'is_received' => 0,
                'datetime_received' => null,
                'receive_remarks' => null,
                'is_process' => 0,
                'datetime_process' => null,
                'process_remarks' => null,
                'is_done' => 0,
                'datetime_done' => null,
                'done_remarks' => null,
                'is_forwarded' => 0,
                'datetime_forwarded' => null,
                'forward_remarks' => null,
                'back_remarks' => null,
                'back_datetime' => null,
            ],
            [
                'document_id' => 1,
                'route_id' => 1,
                'route_detail_id' => 4,
                'office_id' => 4,
                'order_no' => 4,
                'is_origin' => 0,
                'is_last' => 1,
                'is_forward_from' => 0,
                'is_received' => 0,
                'datetime_received' => null,
                'receive_remarks' => null,
                'is_process' => 0,
                'datetime_process' => null,
                'process_remarks' => null,
                'is_done' => 0,
                'datetime_done' => null,
                'done_remarks' => null,
                'is_forwarded' => 0,
                'datetime_forwarded' => null,
                'forward_remarks' => null,
                'back_remarks' => null,
                'back_datetime' => null,
            ]

        ];

        \App\Models\DocumentTrack::insertOrIgnore($data);


    }
}
