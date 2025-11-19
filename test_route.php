<?php

require 'vendor/autoload.php';

// Simulate PDF export like the route would do
use Dompdf\Dompdf;

echo "Testing PDF generation like route...\n";

try {
    $html = '<h1>Test PDF</h1><p>This is a test PDF generated using DomPDF.</p>';
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    file_put_contents('route_test.pdf', $dompdf->output());
    
    echo "✓ PDF generated successfully\n";
    echo "File size: " . filesize('route_test.pdf') . " bytes\n";
    
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
