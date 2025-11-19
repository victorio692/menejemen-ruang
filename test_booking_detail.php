<?php
/**
 * Test Booking Detail Page
 * This script tests the booking detail page functionality
 */

// Setup Laravel bootstrap
define('LARAVEL_START', microtime(true));

require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Test 1: Check if bookings exist
echo "=== Test 1: Check Bookings ===\n";
$bookings = \App\Models\Booking::with(['user', 'room'])->get();
echo "Total bookings: " . count($bookings) . "\n";

if (count($bookings) > 0) {
    $booking = $bookings->first();
    echo "\nFirst Booking Details:\n";
    echo "- ID: " . $booking->id . "\n";
    echo "- User: " . $booking->user->name . "\n";
    echo "- Room: " . $booking->room->name . "\n";
    echo "- Status: " . $booking->status . "\n";
    echo "- Start: " . $booking->start_time . "\n";
    echo "- End: " . $booking->end_time . "\n";
    echo "- Purpose: " . $booking->purpose . "\n";
    echo "- Rejection Reason: " . ($booking->rejection_reason ?? 'None') . "\n";
    echo "- Approved By: " . ($booking->approved_by ?? 'None') . "\n";
    echo "- Approved At: " . ($booking->approved_at ?? 'None') . "\n";
}

// Test 2: Check if user exists
echo "\n=== Test 2: Check Users ===\n";
$users = \App\Models\User::all();
echo "Total users: " . count($users) . "\n";
if (count($users) > 0) {
    echo "First user: " . $users->first()->name . "\n";
}

// Test 3: Check if rooms exist
echo "\n=== Test 3: Check Rooms ===\n";
$rooms = \App\Models\Room::all();
echo "Total rooms: " . count($rooms) . "\n";
if (count($rooms) > 0) {
    echo "First room: " . $rooms->first()->name . "\n";
}

// Test 4: Check routes
echo "\n=== Test 4: Check Routes ===\n";
$routes = [
    'admin.bookings' => '/admin/bookings',
    'admin.bookings.show' => '/admin/bookings/1',
    'user.dashboard' => '/user/dashboard',
    'user.booking.show' => '/user/bookings/1',
];

foreach ($routes as $name => $path) {
    echo "- Route '$name': $path\n";
}

echo "\n=== All Tests Completed ===\n";
