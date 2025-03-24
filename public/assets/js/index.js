document.addEventListener('DOMContentLoaded', () => {
    const sliderItems = document.querySelectorAll('.hero-right .image form');
    let currentIndex = 0;

    function changeSlide() {
        // Remove the active class from all slides
        sliderItems.forEach((item) => item.classList.remove('active'));

        // Add the active class to the current slide
        sliderItems[currentIndex].classList.add('active');

        // Update the index for the next slide
        currentIndex = (currentIndex + 1) % sliderItems.length;
    }

    // Start the slider
    setInterval(changeSlide, 3000); // Change slides every 4 seconds
    changeSlide(); // Initialize the first slide




    const dropdownLinks = document.querySelectorAll(".dropdown-link");

    dropdownLinks.forEach((link) => {
        link.addEventListener("click", (e) => {
            e.preventDefault(); // Prevent default link behavior
            const menu = link.nextElementSibling;
            if (menu) {
                menu.classList.toggle("show");
            }
        });
    });
    
});

