document.addEventListener("DOMContentLoaded", function() {
    const sliders = document.querySelectorAll(".SliderInput");
    console.log("script working");

    sliders.forEach(slider => {
        const output = document.querySelector(`#SliderValueFont[data-for='${slider.id}']`);
        if (!output) return;

        // Update value live
        slider.addEventListener("input", function() {
            output.innerText = slider.value;
        });
    });
});
