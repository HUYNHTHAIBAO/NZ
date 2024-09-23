<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomMeet extends Model
{
    //

    protected $table = 'lck_room_meating';
    protected $fillable = [
        'user_id',
        'expert_id',
        'time_start',
        'date',
        'status',
        'order_id',
        'duration',
        'rom_code',
        'hex_id',
        'token_api',
        'alias',
    ];
    public static function createRoom($params)
    {
        // Create a new RoomMeet instance and fill it with $params
        $room = new self();
        $room->user_id = $params['user_id'];
        $room->expert_id = $params['expert_id'];
        $room->time_start = $params['time_start'];
        $room->date = $params['date'];
        $room->status = $params['status'];
        $room->order_id = $params['order_id'];
        $room->duration = $params['duration'];
        $room->alias = $params['alias'];
        $room->hex_id = $params['hex_id'];
        $room->rom_code = self::GenareteRomCode(); // Ensure this function generates a room code

        $room->save();
        return $room;
    }

//    public static function CreateRoom($params = [])
//    {
//        $params = array_merge(array(
//            'user_id'       => null,
//            'expert_id'     => null,
//            'time_start'    => null,
//            'date'          => null,
//            'status'        => null,
//            'order_id'      => null,
//            'duration'      => null,
//            'rom_code'      => self::GenareteRomCode(),
//        ), $params);
//        $data = self::create($params); // ->save()
//
//
//
//
//        return $data;
//    }

    public static function CheckRoomCode($code)
    {
        $data = self::where('rom_code', $code)->first();
        $resulft = [
            'status' => true,
            'message' => '',
            'alias' => $data->alias,
        ];
        if (empty($data)) {
            $resulft = [
                'status' => false,
                'message' => 'Mã phòng không tồn tại.'
            ];
        }



        return $resulft;
    }


    public static function GenareteRomCode()
    {
        $current_time = time();
        $input_string = $current_time . uniqid();
        $hash = sha1($input_string);
        $rom_code = substr($hash, 0, 3) . '-' . substr($hash, 3, 3) . '-' . substr($hash, 6, 3); // Tạo rom_code 3 ký tự với dấu -

        return $rom_code;
    }
}
