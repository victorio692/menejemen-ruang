<?php

require 'vendor/autoload.php';
require 'bootstrap/app.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle($request = \Illuminate\Http\Request::capture());

use Illuminate\Support\Facades\DB;

// Check jadwal reguler
$jadwals = DB::table('jadwal_regulers')
    ->select('room_id', 'class_id', 'hari', 'start_time', 'end_time')
    ->distinct()
    ->orderBy('room_id', 'hari', 'start_time')
    ->get();

echo "Jadwal Reguler Summary:\n";
echo str_repeat("=", 80) . "\n";

$currentRoom = null;
foreach ($jadwals as $j) {
    if ($j->room_id !== $currentRoom) {
        echo "\n--- Room ID: {$j->room_id} ---\n";
        $currentRoom = $j->room_id;
    }
    echo "  Class: {$j->class_id}, {$j->hari} {$j->start_time}-{$j->end_time}\n";
}

echo "\nTotal jadwal entries: " . count($jadwals) . "\n";
