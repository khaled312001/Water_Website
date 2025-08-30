<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;

// Product image mappings with different colors and text
$productImages = [
    'zamzam-water-500ml.jpg' => ['color' => '#0066cc', 'text' => 'زمزم 500مل'],
    'zamzam-water-1.5l.jpg' => ['color' => '#0066cc', 'text' => 'زمزم 1.5لتر'],
    'nova-water-600ml.jpg' => ['color' => '#00cc66', 'text' => 'نوفا 600مل'],
    'nova-distilled-500ml.jpg' => ['color' => '#00cc66', 'text' => 'نوفا مقطرة'],
    'alkaline-water-750ml.jpg' => ['color' => '#cc6600', 'text' => 'قلوية 750مل'],
    'alkaline-water-500ml.jpg' => ['color' => '#cc6600', 'text' => 'قلوية 500مل'],
    'atibiya-distilled-1l.jpg' => ['color' => '#6600cc', 'text' => 'عتيبية مقطرة'],
    'atibiya-mineral-600ml.jpg' => ['color' => '#6600cc', 'text' => 'عتيبية معدنية'],
    'mansour-premium-500ml.jpg' => ['color' => '#cc0066', 'text' => 'منصور فاخر'],
    'mansour-regular-500ml.jpg' => ['color' => '#cc0066', 'text' => 'منصور عادي'],
    'mansour-alkaline-750ml.jpg' => ['color' => '#cc0066', 'text' => 'منصور قلوي'],
    'alkaline-hospitality-330ml.jpg' => ['color' => '#cc6600', 'text' => 'ضيافة 330مل'],
    'atibiya-medical-500ml.jpg' => ['color' => '#6600cc', 'text' => 'طبي 500مل'],
    'nova-family-2l.jpg' => ['color' => '#00cc66', 'text' => 'عائلي 2لتر'],
    'zamzam-sports-1l.jpg' => ['color' => '#0066cc', 'text' => 'رياضي 1لتر'],
];

echo "Generating unique product images...\n";

foreach ($productImages as $filename => $config) {
    $imagePath = 'public/storage/products/' . $filename;
    
    // Create a 400x400 image
    $width = 400;
    $height = 400;
    
    // Create image
    $image = imagecreatetruecolor($width, $height);
    
    // Parse color
    $color = $config['color'];
    $r = hexdec(substr($color, 1, 2));
    $g = hexdec(substr($color, 3, 2));
    $b = hexdec(substr($color, 5, 2));
    
    // Allocate colors
    $bgColor = imagecolorallocate($image, $r, $g, $b);
    $textColor = imagecolorallocate($image, 255, 255, 255);
    $borderColor = imagecolorallocate($image, 255, 255, 255);
    
    // Fill background
    imagefill($image, 0, 0, $bgColor);
    
    // Add border
    imagerectangle($image, 0, 0, $width-1, $height-1, $borderColor);
    imagerectangle($image, 1, 1, $width-2, $height-2, $borderColor);
    
    // Add water bottle icon (simple rectangle)
    $bottleX = $width / 2 - 40;
    $bottleY = $height / 2 - 80;
    $bottleWidth = 80;
    $bottleHeight = 160;
    
    // Bottle body
    imagefilledrectangle($image, $bottleX, $bottleY, $bottleX + $bottleWidth, $bottleY + $bottleHeight, $textColor);
    
    // Bottle neck
    $neckX = $bottleX + 25;
    $neckY = $bottleY - 20;
    $neckWidth = 30;
    $neckHeight = 20;
    imagefilledrectangle($image, $neckX, $neckY, $neckX + $neckWidth, $neckY + $neckHeight, $textColor);
    
    // Bottle cap
    $capX = $neckX - 5;
    $capY = $neckY - 15;
    $capWidth = 40;
    $capHeight = 15;
    imagefilledrectangle($image, $capX, $capY, $capX + $capWidth, $capY + $capHeight, $bgColor);
    
    // Add text
    $text = $config['text'];
    $fontSize = 20;
    $fontFile = 'arial.ttf'; // Default font
    
    // Try to use a system font
    $systemFonts = [
        'C:/Windows/Fonts/arial.ttf',
        'C:/Windows/Fonts/tahoma.ttf',
        'C:/Windows/Fonts/calibri.ttf',
        '/System/Library/Fonts/Arial.ttf',
        '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
    ];
    
    $fontFile = null;
    foreach ($systemFonts as $font) {
        if (file_exists($font)) {
            $fontFile = $font;
            break;
        }
    }
    
    if ($fontFile) {
        // Get text dimensions
        $bbox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth = $bbox[2] - $bbox[0];
        $textHeight = $bbox[1] - $bbox[7];
        
        // Center text
        $textX = ($width - $textWidth) / 2;
        $textY = $bottleY + $bottleHeight + 40;
        
        // Add text with shadow
        imagettftext($image, $fontSize, 0, $textX + 2, $textY + 2, imagecolorallocate($image, 0, 0, 0), $fontFile, $text);
        imagettftext($image, $fontSize, 0, $textX, $textY, $textColor, $fontFile, $text);
    } else {
        // Fallback to basic text
        $textX = ($width - strlen($text) * 10) / 2;
        $textY = $bottleY + $bottleHeight + 40;
        imagestring($image, 5, $textX, $textY, $text, $textColor);
    }
    
    // Save image
    imagejpeg($image, $imagePath, 90);
    imagedestroy($image);
    
    echo "Generated: $filename\n";
}

echo "All product images generated successfully!\n"; 