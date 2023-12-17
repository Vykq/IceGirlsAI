function setVideoObserver() {

    const videoObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                const video = entry.target;
                if (video.currentTime === 0) {
                    return
                };
                if (!entry.isIntersecting || entry.intersectionRatio <= 0.2) {
                    video.pause();
                } else  {
                    video.play();
                }
            })
        },
        {
            threshold: [0, 0.8]
        }
    );

    document.querySelectorAll('video')
        .forEach(video => videoObserver.observe(video))

}

export default setVideoObserver;
