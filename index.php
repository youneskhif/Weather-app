<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather in Morocco</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>🌤️ Weather in Morocco by Nomads Hues 🌍</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="city">Choose a city:</label>
                <select name="city" id="city">
                    <option disabled selected>Select a city</option>
                    <?php
                        $cities = [
                            "Casablanca", "Rabat", "Marrakesh", "Tangier", "Agadir", "Fez", "Tetouan",
                            "Oujda", "El Jadida", "Safi", "Kenitra", "Nador", "Beni Mellal", "Ifrane",
                            "Essaouira", "Asilah", "Larache", "Chefchaouen", "Ouarzazate", "Dakhla",
                            "Laayoune", "Errachidia", "Al Hoceima", "Taza", "Guelmim", "Khouribga",
                            "Mohammedia", "Khenifra", "Tiznit", "Settat"
                        ];
                        foreach ($cities as $city) {
                            $selected = isset($_POST['city']) && $_POST['city'] == $city ? 'selected' : '';
                            echo "<option value='$city' $selected>$city</option>";
                        }
                    ?>
                </select>
            </div>
            <button type="submit" name="getWeather">Get Temperature</button>
        </form>
        <div id="result">
            <?php
                if (isset($_POST['getWeather'])) {
                    $city = $_POST['city'];
                    $apiKey = 'YOUR_API_KEY';
                    $url = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric";

                    $request = curl_init();
                    curl_setopt($request, CURLOPT_URL, $url);
                    curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($request);
                    curl_close($request);

                    if ($response) {
                        $data = json_decode($response, false);

                        if (isset($data->main->temp)) {
                            $temp = $data->main->temp;
                            $description = $data->weather[0]->description;
                            $feels_like = $data->main->feels_like;

                            echo "<p>The temperature in <strong>$city</strong> is <strong>{$temp}°C</strong> with <em>{$description}</em> and feels like <strong>{$feels_like}°C</strong>.</p>";
                            if ($temp > 20) {
                                echo "<div class='sun-icon'><i class='fas fa-sun'></i></div>";
                            } else {
                                echo "<div class='cloud-icon'><i class='fas fa-cloud'></i></div>";
                            }
                        } else {
                            echo "<p>Could not retrieve weather data. Please try again later.</p>";
                        }
                    } else {
                        echo "<p>Failed to connect to the API.</p>";
                    }
                }
            ?>
        </div>
    </div>
</body>

</html>
