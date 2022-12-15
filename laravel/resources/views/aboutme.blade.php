@extends('layouts.app')
@section('content')
<style>
    .divAbout{
        height: 35vw;
        width: 50vw;
    }

    .divCard{
        width: 35%;
        height: 80%;
        border: solid black;
        background-color: #D9D9D9;
        flex-direction: column;
        overflow: hidden;
        transition: all 400ms ease;
    }

    .divImagenes{
        height: 100%;
        width: 100%;
        position: relative;
    }

    .divImagenes div{
        height: 100% !important;
        width: 100% !important;
        position: absolute;
    }

    .divContenido{
        margin-top: 7%;
        height: 43%;
        width: 100%;
        display: flex;
        align-items: center;
        flex-direction: column;
    }

    .foto1{
        background: url(../imatges/foto_antigua.JPG);
        background-size: 100% 100%;
        filter: contrast();
    }


    .foto2{
        background: url(../imatges/FOTO_ACTUAL.jpg);
        background-size: 100% 100%;
        transition: 0.6s;
        clip-path: polygon(0 0,50% 0,50% 100%,0 100%);
        -webkit-filter: grayscale(100%);
        filter: grayscale(100%);
    }

    .foto2:hover{
        clip-path: polygon(0 0,100% 0,100% 100%,0 100%);
    }


    .foto1:hover ~ .foto2{
        clip-path: polygon(0 0,0 0,0 100%,0 100%);
    }

    h3{
        font-family: helvetica;
    }

    .cargoEmpresa{
        padding: 1.5rem 5rem;
        cursor: default;
        position: relative;
        overflow: hidden;
    }

    .cargoEmpresa::before{
        content: 'CEO/Fundador';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        transition: .2s ease;
    }

    .cargoEmpresa::after{
        content: 'Amant dels eSports';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%) scale(0);
        transition: .2s ease;
        opacity: 0;
    }

    .cargoEmpresa:hover::before{
        transform: translate(-50%, -50%) scale(3);
        opacity: 0;
    }

    .cargoEmpresa:hover::after{
        transform: translate(-50%, -50%) scale(1);
        opacity: 1;
    }
</style>
<div class="divAbout centrar">
    <div class="divCard centrar">
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Video presentació</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"  aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <video width="500" height="300"  controls muted>
                                    <source src="../audio/video1.mp4" type="video/mp4">

                                    Your browser does not support the video tag.
                                </video>
                            </div>
                            <div class="carousel-item">
                                <video width="500" height="300"  controls>
                                    <source src="../audio/video2.mp4" type="video/mp4"> 
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
                </div>
            </div>
        </div>
        
        <div class="divImagenes">
            <a type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                <div class="foto1">
                    <audio id="mySoundClip">
                        <source src="../audio/audioAboutUs.mp3" type="audio/mp3">
                    </audio>
                </div>
                <div class="foto2">
                    <audio id="mySoundClip">
                        <source src="../audio/audioAboutUs.mp3" type="audio/mp3">
                    </audio>
                </div>
            </a>
        </div>
        <div class="divContenido">
            <h3>OSCAR BUITRAGO</h3>
            <button class="cargoEmpresa"></button>
            
        </div>
    </div>
</div>
<script>
    var pistaAudio = document.querySelector('.divImagenes');
    var audio = document.getElementById('mySoundClip');

    pistaAudio.addEventListener('mouseover',function(){
        audio.play();
    });

    pistaAudio.addEventListener('mouseout',function(){
        audio.pause();
    });

    const videos = document.getElementsByTagName("video");
    const prevBtn = document.getElementsByClassName("carousel-control-prev")[0]
    const nextBtn = document.getElementsByClassName("carousel-control-next")[0]
    
    var cur = 0
    const max = videos.length
    console.log("🎬 Total videos: " + max)
    
    const playVideos = function(){
    // Pause all videos
    for (v=0; v<max; v++) {
        videos[v].pause();
    }
    // Play current video
    console.log("🎬 PLAY VIDEO " + cur)
    videos[cur].play()
    }
    
    prevBtn.addEventListener("click", function(){
    cur = (cur-1 >= 0) ? cur-1 : max
    playVideos()
    })
    
    nextBtn.addEventListener("click", function(){
    cur = (cur+1 < max) ? cur+1 : 0
    playVideos()
    })

</script>
@endsection    