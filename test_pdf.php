<?php

require 'vendor/autoload.php';

// Test 1: Check if Pdf class exists
echo "Test 1: Checking Pdf facade...\n";
if (class_exists('Barryvdh\DomPDF\Facade\Pdf')) {
    echo "✓ Pdf class found\n";
} else {
    echo "✗ Pdf class NOT found\n";
    exit(1);
}

// Test 2: Try to load HTML and generate PDF
echo "\nTest 2: Generating PDF...\n";
try {
    $html = '<h1>Test PDF</h1><p>This is a test PDF.</p>';
    
    // Use the actual DomPDF class
    $dompdf = new \Barryvdh\DomPDF\PDF();
    $dompdf->loadHTML($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    file_put_contents('test_output.pdf', $dompdf->output());
    echo "✓ PDF generated: test_output.pdf\n";
    echo "File size: " . filesize('test_output.pdf') . " bytes\n";
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n✓ All tests passed!\n";
