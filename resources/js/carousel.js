import "keen-slider/keen-slider.min.css";
import KeenSlider from "keen-slider";

document.addEventListener("DOMContentLoaded", function () {
    const slider = new KeenSlider("#keen_slider", {
        loop: true,
        slidesPerView: 1,
    });

    setInterval(() => {
        slider.next();
    }, 4000);

});
