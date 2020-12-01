
// Fonction appelée lors du click du bouton
function start(city) {
  // Création de l'objet apiWeather
  const apiWeather = new API_WEATHER(city);
  // Appel de la fonction fetchTodayForecast

  apiWeather
    .fetchTodayForecast()
    .then(function(response) {
      // Récupère la donnée d'une API
      const data = response.data;

      // On récupère l'information principal
      const main = data.weather[0].main;
      const description = data.weather[0].description;
      const temp = data.main.temp;
      const city= data.name;
      const icon = apiWeather.getHTMLElementFromIcon(data.weather[0].icon);

      // Modifier le DOM
      document.getElementById('today-forecast-main').innerHTML = main;
      document.getElementById('today-forecast-more-info').innerHTML = description;
      document.getElementById('icon-weather-container').innerHTML = icon;
      document.getElementById('today-forecast-temp').innerHTML = `${temp}°C`;
      
    })
    .catch(function(error) {
      // Affiche une erreur
      console.error(error);
    });

  apiWeather
    .getThreeDayForecast()
    .then(function(response) {
      // Récupère la donnée d'une API
      const data = response.data;
      for(let pas = 1; pas < 4; pas++){
        // On récupère l'information principal
        const main = data.list[pas].weather[0].main;
        const description = data.list[pas].weather[0].description;
        const temp = data.list[pas].temp.day;
        const icon = apiWeather.getHTMLElementFromIcon(data.list[pas].weather[0].icon);

        // Modifier le DOM
        document.getElementById('today-forecast-main-d'+pas).innerHTML = main;
        document.getElementById('today-forecast-more-info-d'+pas).innerHTML = description;
        document.getElementById('icon-weather-container-d'+pas).innerHTML = icon;
        document.getElementById('today-forecast-temp-d'+pas).innerHTML = `${temp}°C`;
        console.log(data);
      }
    })
    .catch(function(error) {
      // Affiche une erreur
      console.error(error);
    });
}
function recup(){
        var city = document.getElementById("city-input").value;
        start(city);
      }


