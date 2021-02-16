<video muted id="loading" src="/assets/loading.mp4"></video>
<div class="home">
    <video muted autoplay loop id="main_video" src="/assets/main.mov"></video>
    <div class="container">
    <h2 class="txt-center">
    GhostSMS<small>는 최고의</small> 익명성<small>과</small> 보안<small>을 중요시합니다</small>
    </h2>
    </div>
</div>

<script>
    $(function(){
        $('header').addClass("fixed");
        $('.app-footer').addClass("fixed");
    })
    var vid = document.getElementById("loading");
    if(GetCookie("loadingPlayed") != "false"){
        $("#loading").addClass("playing");
        vid.play();
    }else{
        $("#loading").remove();
    }
    vid.addEventListener('ended', function(e) {
        vid.pause()
        vid.currentTime = 0;
        vid.classList.remove('playing');
        setTimeout(function() {
            vid.parentNode.removeChild(vid);
            $('.app-footer').addClass("fixed");
            var expired = getDateByjQueryDateFormat('1d');
            SetCookie("loadingPlayed", false, null, null, expired)
        }, 2000);
    }, false);

</script>
<style>
    #loading.playing {
        opacity: 1;
        transition: opacity 3s ease;
    }

    #loading {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        margin: auto;
        height: 100%;
        z-index: 100;
        opacity: 0;
        transition: opacity 3s ease;
    }
</style>