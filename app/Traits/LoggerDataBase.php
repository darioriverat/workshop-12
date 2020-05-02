<?php

namespace App\Traits;

use App\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait LoggerDataBase
{
    /**
     * @param string $table
     * @param string $type
     * @param string $description
     * @param Model $model
     */
    public static function insert(string $table, string $type, string $description, Model $model)
    {
        $log = [
            'user' => Auth::user()['email'] ?? 'Admin',
            'source' => $table,
            'type' => $type,
            'ipAddress' => $_SERVER['HTTP_CLIENT_IP'] ?? '127.0.0.1',
            'userAgent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'description' => $description,
            'model' => $model,
        ];
        Log::create($log);
    }
}
