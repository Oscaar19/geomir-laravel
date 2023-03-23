@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
     integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
     crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
     integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
     crossorigin=""></script>

<style>
    ::-webkit-scrollbar {
        display: none;
    
    }
   
</style>
<script src="https://cdn.jsdelivr.net/npm/ol@v7.2.2/dist/ol.js"></script>
<div class="contacto-flex">
    <div id="speech-div">
        <i id="micro" class="bi bi-mic"></i>
    </div>
    <div class="contenedor-fondo">
        <video src="./audio/video-fondo.mp4" class="video" autoplay="true" muted="true" loop="true"></video>
        <div class="texto-arriba">Contacta amb nosaltres</div>
        <div class="texto-arriba2">Envia el teu missatge</div>
        <button class="boton-contacto">Formulari de contacte</button>
    </div>

        <div id="map">
            <script>
                
                //creacion mapa
                var map = L.map('map').setView([41.2310177, 1.7279358], 17);
                    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);
                //creacion circulo rojo mapa
                var circle = L.circle([41.2310177, 1.7285358], {
                    color: 'red',
                    fillColor: '#f03',
                    fillOpacity: 0.5,
                    radius: 100
                }).addTo(map);
                // ATAJOS de ctrl + alt + g y ctrl +alt + c
                document.onkeyup = function(e) {
                //esto muestra mi latitud y longitud
                if (e.ctrlKey && e.altKey && e.which == 71) {
                    navigator.geolocation.getCurrentPosition(success);
                    function success(position) {
                    var coordenadas = position.coords;
                    alert("Tu posición ahora mismo es:"+
                    "\n- Tu Latitud : " + coordenadas.latitude+
                    "\n- Tu Longitud: " + coordenadas.longitude);
                    };
                } 
                //esto centra el mapa en el mir
                else if (e.ctrlKey && e.altKey && e.which == 67) {
                    alert("Acepta para centrar el mapa");
                    map.remove();
                    map = L.map('map').setView([41.2310177, 1.7279358], 17);
                    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);
                circle = L.circle([41.2310177, 1.7285358], {
                    color: 'red',
                    fillColor: '#f03',
                    fillOpacity: 0.5,
                    radius: 100
                }).addTo(map);
                navigator.geolocation.getCurrentPosition(showPosition);
                function showPosition(position) {
                    marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
                    marker.bindPopup("Ústed esta aquí").openPopup();
                }
                }
                };
                
            </script>
        </div>

    <footer class="pie-de-pagina">
        <div class="grupo-3">
            <div class="box">
                <div class="contenedor-logo">
                    <img src="../imatges/logo.PNG" alt="Logo de Geomir">
                </div>
            </div>
            <div class="caja">
                <h2>Informació corporativa</h2>
                <p>Geolocalitza els teus amics, i llocs d'interès gràcies a les publicacions de la gent del teu volant.</p>
                <p><i class="bi bi-geo-alt"></i> Av. de Vilafranca del Penedès, 08800 Vilanova i la Geltrú, Barcelona</p>
            </div>
            <div class="caja">
                <h2>Xarxes Socials</h2>
                <div class="red-social">
                    <a href="https://es-la.facebook.com"><i class="bi bi-facebook"></i></a>
                    <a href="https://www.instagram.com" ><i class="bi bi-instagram"></i></a>
                    <a href="https://twitter.com"><i class="bi bi-twitter"></i></a>
                    <a href="https://www.witch.com"><i class="bi bi-twitch"></i></a>
                </div>
            </div>
            <!-- Icono de accesibilidad -->
            <a href="https://www.w3.org/WAI/WCAG2A-Conformance"
            title="Explanation of WCAG 2 Level A Conformance">
                <img height="32" width="88"
                    src="https://www.w3.org/WAI/WCAG21/wcag2.1A-v"
                    alt="Level A conformance,
                            W3C WAI Web Content Accessibility Guidelines 2.1">
            </a>
        </div>
    </footer>
</div>
<script>
    //marcador puntero mapa
    navigator.geolocation.getCurrentPosition(showPosition);
    function showPosition(position) {
        var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
        marker.bindPopup("Usted esta aquí").openPopup();
    }

    //A partir de aqui se desarrolla el speechRecognition
    var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition
    var SpeechGrammarList = SpeechGrammarList || window.webkitSpeechGrammarList
    var SpeechRecognitionEvent = SpeechRecognitionEvent || webkitSpeechRecognitionEvent

    //Aqui se recogen la lista de valores para que se reconozcan por voz despues.
    var options = [ 'sube' , 'baja' , 'aumenta zoom', 'disminuye zoom'];

    var recognition = new SpeechRecognition();
    if (SpeechGrammarList) {
        // Aqui se genera la lista que el speech ha de reconocer uno de los valores.
        var speechRecognitionList = new SpeechGrammarList();
        var grammar = '#JSGF V1.0; grammar options; public <option> = ' + options.join(' | ') + ' ;'
        speechRecognitionList.addFromString(grammar, 1);
        recognition.grammars = speechRecognitionList;
    }

    //Le doy ajustes al objeto como idioma, resultados y alternativas esperadas.
    recognition.continuous = false;
    recognition.lang = 'es-ES';
    recognition.interimResults = false;
    recognition.maxAlternatives = 1;

    //Aqui recojo el div que he creado.
    const micro = document.getElementById("speech-div")

    //Aqui le digo que cuando se haga click en el micro, habilite la herramienta del micro en el ordenador
    micro.addEventListener("click", function(){
        recognition.start();
        console.log('Ready to receive a command.');
    })

    //Aqui analizo ya los resultados que me trae el reconocimiento.
    recognition.onresult = function(event) {
        var opcionRecibida = event.results[0][0].transcript;
        console.log(opcionRecibida);
        //Si la palabra es "sube", hago scroll hacia arriba
        if (opcionRecibida == "sube"){
            window.scrollBy(0,-40)
        }
        //Si la palabra es "baja", hago scroll hacia abajo
        else if(opcionRecibida == "baja"){
            window.scrollBy(0,40)
        }
        //Si la palabra es "aumenta zoom", aumento zoom
        else if(opcionRecibida == "aumenta zoom"){
            var match = document.body.style.transform.match(/scale\((.*?)\)/);
            var zoom = match ? parseFloat(match[1]) : 1;
            document.body.style.transform = `scale(${zoom + 0.1})`;
        }
        //Si la palabra es "disminuye zoom", disminuyo zoom
        else if(opcionRecibida == "disminuye zoom"){
            var match = document.body.style.transform.match(/scale\((.*?)\)/);
            var zoom = match ? parseFloat(match[1]) : 1;
            document.body.style.transform = `scale(${zoom - 0.1})`;
        }
    }

    document.onkeyup = function(e) {

        //si hago ctrl alt r, subo arriba de la pagina y zoom al 100%
        if (e.ctrlKey && e.altKey && e.which == 82) {

            window.scrollTo(0,0)
            document.body.style.transform = 'scale(1)';

        }
    }
    //Esta funcion detecta que cuando no hay sonido, para de escuchar con el micro
    recognition.onspeechend = function() {
        recognition.stop();
    }
    //Si la palabra no coincide con ninguna de las esperadas, avisa que no coincide
    recognition.onnomatch = function(event) {
        console.log("I didn't recognise that color.")
    }
    //Si hay algun error, salta que ha ocurrido un error con la descripcion
    recognition.onerror = function(event) {
        console.log('Error occurred in recognition: ' + event.error);
    }
</script>
@endsection