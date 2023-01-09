<?php

namespace App\Http\Controllers;

use Spatie\DbDumper\Databases\MySql;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SqlDumpController extends Controller
{
    public function __invoke(): BinaryFileResponse
    {
        $filename = 'dump_' . date('Y_m_d_s') . '.sql';

        MySql::create()
            ->setDbName('laravel')
            ->setUserName('root')
            ->setPassword('')
            ->dumpToFile($filename);

        return response()->download(public_path(), $filename, [], 'inline');
    }
}
