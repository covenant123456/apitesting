<?php
// Function to get client IP address from the client request
function get_client_ip() {
    $ipaddress = '';

    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

// Get the visitor's name from the query string
$visitor_name = isset($_GET['visitor_name']) ? $_GET['visitor_name'] : 'Guest';

// Get client IP address
$client_ip = get_client_ip();

// Use GeoPlugin API to get location information based on IP address
$geoPluginUrl = "http://www.geoplugin.net/json.gp?ip={$client_ip}";
$locationData = json_decode(file_get_contents($geoPluginUrl), true);

$location = isset($locationData['geoplugin_city']) ? $locationData['geoplugin_city'] : 'Unknown Location';

// If the city is unknown, set a default location
if ($location === 'Unknown Location') {
    $location = 'New York'; // Default location
}

// Use OpenWeatherMap API to get current weather information for the location
$weatherApiKey = 'e9c7326922d0a6298549bb56ddb8e8ee';
$weatherUrl = "https://api.openweathermap.org/data/2.5/weather?q={$location}&appid={$weatherApiKey}&units=metric";
$weatherData = json_decode(file_get_contents($weatherUrl), true);

$temperature = isset($weatherData['main']['temp']) ? $weatherData['main']['temp'] : 'Unknown';

// Create the response array
$response = [
    'client_ip' => $client_ip,
    'location' => $location,
    'greeting' => "Hello, $visitor_name! The temperature is {$temperature} degrees Celsius in {$location}"
];

// Set the Content-Type to application/json
header('Content-Type: application/json');

// Print the JSON-encoded response
echo json_encode($response);
?>
