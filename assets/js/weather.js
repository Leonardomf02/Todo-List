async function getWeather(cityId) {
    const OPENWEATHERMAP_API_KEY = 'ffb0c993713c4e7d0537b1fd9665becd';
    const GEO_API_USERNAME = 'cristovao07';
    const GEO_API_URL = `http://api.geonames.org/getJSON?geonameId=${cityId}&username=${GEO_API_USERNAME}`;

    const cityDataResponse = await fetch(GEO_API_URL);
    const cityData = await cityDataResponse.json();

    const lat = cityData.lat;
    const lng = cityData.lng;

    const WEATHER_API_URL = `http://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lng}&appid=${OPENWEATHERMAP_API_KEY}&units=metric`;
    const weatherResponse = await fetch(WEATHER_API_URL);
    const weatherData = await weatherResponse.json();

    const temperature = weatherData.main.temp;
    const weatherInfo = `The temperature for today is ${temperature}°C.`;

    document.getElementById('weather-info').textContent = weatherInfo;
}
document.addEventListener('DOMContentLoaded', () => {
    getWeather(userCityId);
});
