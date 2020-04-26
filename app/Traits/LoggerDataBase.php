<?php

namespace App\Traits;

use App\Logs;
use Illuminate\Support\Facades\Auth;

trait LoggerDataBase
{
    public static function insert($table,$type,$description){
        try {
            $log = [
                'user' => Auth::user()['email'],
                'source' => $table,
                'type' => $type,
                'ipAddress' =>  $_SERVER['HTTP_CLIENT_IP'] ?? '1270.0.1',
                'userAgent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
                'description' => $description,
            ];
            Logs::create($log);
        } catch (Exception $ex) {
        }
    }
}