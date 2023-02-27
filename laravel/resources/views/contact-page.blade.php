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
    <div class="contenedor-fondo">
        <video src="./audio/video-fondo.mp4" class="video" autoplay="true" muted="true" loop="true"></video>
        <div class="texto-arriba">Contacta amb nosaltres</div>
        <div class="texto-arriba2">Envia el teu missatge</div>
        <button class="boton-contacto">Formulari de contacte</button>
    </div>

        <div id="map">
            <script>
                
                var map = L.map('map').setView([41.231391, 1.728118],17);
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);
                var marker = L.marker([41.231391, 1.728118]).addTo(map);
                
                var circle = L.circle([41.231391, 1.728118], {
                    color: 'red',
                    fillColor: '#f03',
                    fillOpacity: 0.5,
                    radius: 200
                }).addTo(map);
                
                marker.bindPopup("<b>Aquí es troba Geo-Mir</b>").openPopup();
                circle.bindPopup("Area propera a nosaltres");
                var popup = L.popup()
                    .setLatLng([41.231391, 1.728118])
                    .setContent("On som nosaltres")
                    .openOn(map);
                navigator.geolocation.getCurrentPosition(showPosition);
                function showPosition(position)
                {
                    var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
                    var popup = L.popup()
                    .setLatLng([position.coords.latitude, position.coords.longitude])
                    .setContent("Tu ets aquí!!")
                    .openOn(map);
                
                }
                
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
        </div>
    </footer>
</div>
@endsection