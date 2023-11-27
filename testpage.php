<?php
$money = 1234; // Example money value, replace this with your actual value

// Given data points
$dataPoints = [
    130 => 0.641,
    160 => 0.63259,
    200 => 0.53852,
    300 => 0.4,
    400 => 0.3,
    500 => 0.15,
    600 => 0.1,
    700 => 0.05,
    800 => 0.025,
    900 => 0.01,
    1000 => 0.005,
    1100 => 0.0025,
    1200 => 0.001,
    1300 => 0.0005,
    1400 => 0.00025,
    1500 => 0.0001,
];

// Create an exponential decay function based on the provided data
function calculateExchangeRate($money, $dataPoints) {
    $keys = array_keys($dataPoints);
    sort($keys);

    $lastKey = null;
    $nextKey = null;

    // Find the closest data points for interpolation
    foreach ($keys as $key) {
        if ($money <= $key) {
            $nextKey = $key;
            break;
        }
        $lastKey = $key;
    }

    // If the exact key matches, return the value
    if ($money === $nextKey) {
        return $dataPoints[$nextKey];
    }

    // Interpolate between the closest data points
    if ($lastKey !== null && $nextKey !== null) {
        $lastRate = $dataPoints[$lastKey];
        $nextRate = $dataPoints[$nextKey];

        // Calculate the slope of the line in log-space
        $logLastRate = log($lastRate);
        $logNextRate = log($nextRate);
        $slope = ($logNextRate - $logLastRate) / ($nextKey - $lastKey);

        // Calculate the exchange rate based on interpolation
        $interpolatedRate = exp($logLastRate + $slope * ($money - $lastKey));
        return $interpolatedRate;
    }

    // Default return if no interpolation possible
    return null;
}

$currentRate = calculateExchangeRate($money, $dataPoints);

if ($currentRate !== null) {
    echo "Current exchange rate based on money = $money is: " . number_format($currentRate, 5);
} else {
    echo "Exchange rate for this value of money cannot be determined.";
}
?>