#!/usr/bin/env php
<?php

/**
 * Quick Test Script to View All Gigs with Pricing Tiers
 * Run from project root: php test-tiers.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Gig;
use App\Models\GigTier;

echo "\n";
echo "═══════════════════════════════════════════════════════════════\n";
echo "  🎯 PRICING TIERS - Test Data Overview\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

// Get all gigs with tiers
$gigs = Gig::with('tiers')->get();

echo "📊 Total Gigs: " . $gigs->count() . "\n";
echo "💰 Total Tiers: " . GigTier::count() . "\n\n";

echo "─────────────────────────────────────────────────────────────────\n";
echo "GIG DETAILS WITH PRICING TIERS:\n";
echo "─────────────────────────────────────────────────────────────────\n\n";

foreach ($gigs as $index => $gig) {
    echo "#{" . ($index + 1) . "} " . strtoupper($gig->title) . "\n";
    echo "Type: {$gig->type} | Gig ID: {$gig->id_gig}\n";
    echo "Description: {$gig->description}\n";
    echo "\n   Pricing Tiers:\n";
    
    if ($gig->tiers->isEmpty()) {
        echo "   ❌ No tiers found\n";
    } else {
        foreach ($gig->tiers as $tier) {
            $tierSymbol = '';
            if ($tier->tier_name === 'BASIC') {
                $tierSymbol = '💎';
            } elseif ($tier->tier_name === 'MEDIUM') {
                $tierSymbol = '💎💎';
            } elseif ($tier->tier_name === 'PREMIUM') {
                $tierSymbol = '💎💎💎';
            }
            
            echo sprintf(
                "   %s %-10s | \$%-7.2f | %d day(s) | %s\n",
                $tierSymbol,
                $tier->tier_name,
                $tier->base_price,
                $tier->delivery_days,
                $tier->description
            );
        }
    }
    
    echo "\n";
}

echo "─────────────────────────────────────────────────────────────────\n";
echo "📈 PRICING STATISTICS:\n";
echo "─────────────────────────────────────────────────────────────────\n\n";

$tiers = GigTier::all();
$byTierName = $tiers->groupBy('tier_name');

foreach (['BASIC', 'MEDIUM', 'PREMIUM'] as $tierName) {
    $tierGroup = $byTierName->get($tierName, collect());
    if ($tierGroup->isNotEmpty()) {
        $count = $tierGroup->count();
        $avgPrice = $tierGroup->avg('base_price');
        $minPrice = $tierGroup->min('base_price');
        $maxPrice = $tierGroup->max('base_price');
        
        echo "$tierName Tiers:\n";
        echo "  • Count: $count\n";
        echo "  • Avg Price: \$" . number_format($avgPrice, 2) . "\n";
        echo "  • Min: \$" . number_format($minPrice, 2) . "\n";
        echo "  • Max: \$" . number_format($maxPrice, 2) . "\n\n";
    }
}

echo "─────────────────────────────────────────────────────────────────\n";
echo "🔥 TOP 5 MOST EXPENSIVE SERVICES:\n";
echo "─────────────────────────────────────────────────────────────────\n\n";

$topExpensive = GigTier::orderByDesc('base_price')
    ->with('gig')
    ->take(5)
    ->get();

foreach ($topExpensive as $index => $tier) {
    echo sprintf(
        "%d. %s (%s) - \$%.2f\n",
        $index + 1,
        $tier->gig->title,
        $tier->tier_name,
        $tier->base_price
    );
}

echo "\n";
echo "─────────────────────────────────────────────────────────────────\n";
echo "💎 TOP 5 CHEAPEST SERVICES:\n";
echo "─────────────────────────────────────────────────────────────────\n\n";

$topCheap = GigTier::orderBy('base_price')
    ->with('gig')
    ->take(5)
    ->get();

foreach ($topCheap as $index => $tier) {
    echo sprintf(
        "%d. %s (%s) - \$%.2f\n",
        $index + 1,
        $tier->gig->title,
        $tier->tier_name,
        $tier->base_price
    );
}

echo "\n";
echo "═══════════════════════════════════════════════════════════════\n";
echo "  ✅ Test Complete!\n";
echo "═══════════════════════════════════════════════════════════════\n\n";
