<?php

namespace App\Http\Controllers;

use File;
use Response;
use Spatie\DbDumper\Databases\MySql;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SqlDumpController extends Controller
{
    public function __invoke(): BinaryFileResponse
    {
        $filename = 'dump_' . date('Y_m_d_s') . '.sql';

        MySql::create()
            ->setHost(env('DB_HOST'))
            ->setPort(env('DB_PORT'))
            ->setDbName(env('DB_DATABASE'))
            ->setUserName(env('DB_USERNAME'))
            ->setPassword(env('DB_PASSWORD'))
            ->dumpToFile($filename);

        return response()->download(public_path(), $filename, ['Content-Type' => 'text/csv'], 'inline');
    }
}
