<?php

require 'vendor/autoload.php';

echo "Test 1: Autoload check...\n";

try {
    $pdf = new \Dompdf\Dompdf();
    $pdf->loadHtml('<h1>Test PDF</h1><p>This is test.</p>');
    $pdf->render();
    
    file_put_contents('test_direct.pdf', $pdf->output());
    echo "✓ PDF generated successfully with Dompdf\Dompdf\n";
    echo "File size: " . filesize('test_direct.pdf') . " bytes\n";
    
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
