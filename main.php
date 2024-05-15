<?php

$apiKey = "4dc96a8d825cf5107e873afdd499f9af";
$weatherApiUrl = "https://api.openweathermap.org/data/2.5/weather?lat={lat}&lon={lon}&appid={APIkey}";
$geoApiUrl = "http://api.openweathermap.org/geo/1.0/direct?q={city}&limit={limit}&appid={APIkey}";

echo "-----------------------------------\n\n";
echo "Welcome to weather app.\n\n";
echo "-----------------------------------\n";
$city = readline("Please enter your city: ");

$geoLocation = str_replace(["{city}", "{limit}", "{APIkey}"], [$city, 1, $apiKey], $geoApiUrl);
$geoApiResponse = file_get_contents($geoLocation);
$geoData = json_decode($geoApiResponse, true);

if (empty($geoData) == false) {
    $latitude = $geoData[0]['lat'];
    $longitude = $geoData[0]['lon'];

    $weather = str_replace(["{lat}", "{lon}", "{APIkey}"], [$latitude, $longitude, $apiKey], $weatherApiUrl);
    $weatherApiResponse = file_get_contents($weather);
    $weatherData = json_decode($weatherApiResponse, true);

    if (empty($weatherData) == false) {
        $currentWeather = $weatherData['weather'][0];
        $mainWeather = $weatherData['main'];
        $wind = $weatherData['wind'];
        echo "Current weather in {$weatherData['name']}:\n";
        echo "-----------------------------------\n";
        echo "Weather: {$currentWeather['main']} - {$currentWeather['description']}\n";
        echo "-----------------------------------\n";
        echo "Temperature: " . round($mainWeather['temp'] - 273.15, 2) . "°C\n";
        echo "-----------------------------------\n";
        echo "Feels like: " . round($mainWeather['feels_like'] - 273.15, 2) . "°C\n";
        echo "-----------------------------------\n";
        echo "Humidity: {$mainWeather['humidity']}%\n";
        echo "-----------------------------------\n";
        echo "Wind speed: {$wind['speed']} m/s\n";
        echo "-----------------------------------\n";
    } else {
        echo "Failed to fetch weather data.\n";
    }
} else {
    echo "City not found.\n";
}

