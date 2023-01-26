$(document).scroll(() => {
    // Vanilla: window.scrollY
    let isScrolled = $(document).scrollTop() > $(".topBar").height()
    $(".topBar").toggleClass("scrolled", isScrolled)
})


function volumeToggle(button) {
    // Return true if muted
    var muted = $(".previewVideo").prop("muted");
    $(".previewVideo").prop("muted", !muted);

    $(button).find("i").toggleClass("fa-volume-xmark");
    $(button).find("i").toggleClass("fa-volume-up");
}

function previewEnded() {
    // .toggle adds/removes the "hidden" property
    $(".previewVideo").toggle();
    $(".previewImage").toggle();
}

function goBack() {
    window.history.back();
}

function startHideTimer() {
    var timeout = null;

    $(document).on("mousemove", () => {
        // If mouse move, clear previous timeout from executing
        clearTimeout(timeout);
        $(".watchNav").fadeIn();

        // Create timeout and hide banner after 2 seconds
        timeout = setTimeout(() => {
            $(".watchNav").fadeOut();
        }, 2000);
    });
}

function initVideo(videoId, username) {
    startHideTimer();
    setStartTime(videoId, username);
    updateProgressTimer(videoId, username);
}

function updateProgressTimer(videoId, username) {
    addDuration(videoId, username);

    var timer;
    //Execute when video plays/resumes
    $("video")
        .on("playing", (event) => {
            window.clearInterval(timer);
            timer = window.setInterval(() => {
                updateProgress(videoId, username, event.target.currentTime);
            }, 3000);
        })
        //When video ends, clear interval timer
        .on("ended", () => {
            setFinished(videoId, username);
            window.clearInterval(timer);
        });
}

function addDuration(videoId, username) {
    // Send a ajax post request
    $.post(
        "ajax/addDuration.php",
        { videoId: videoId, username: username },
        (data) => {
            if (data !== null && data !== "") {
                alert(data);
            }
        }
    );
}

function updateProgress(videoId, username, progress) {
    $.post(
        "ajax/updateDuration.php",
        { videoId: videoId, username: username, progress: progress },
        (data) => {
            if (data !== null && data !== "") {
                alert(data);
            }
        }
    );
}

function setFinished(videoId, username) {
    $.post(
        "ajax/setFinished.php",
        { videoId: videoId, username: username },
        (data) => {
            if (data !== null && data !== "") {
                alert(data);
            }
        }
    );
}

function setStartTime(videoId, username) {
    $.post(
        "ajax/getProgress.php",
        { videoId: videoId, username: username },
        (data) => {
            if (isNaN(data)) {
                alert(data);
                return;
            }
            // When video is ready to start
            $("video").on("canplay", (event) => {
                // Set video progress to where user last left
                event.target.currentTime = data;
                $("video").off("canplay"); // Remove event listener
            });
        }
    );
}

function restartVideo() {
    $("video")[0].currentTime = 0;
    $("video")[0].play();
    $(".upNext").fadeOut();
}

function watchVideo(videoId) {
    window.location.href = "watch.php?id=" + videoId;
}

function showUpNext() {
    $(".upNext").fadeIn();
}
