
        document.addEventListener("DOMContentLoaded", function() {
            const carousel = document.getElementById("teamsCarousel");
            const container = document.getElementById("teamsContainer");
            const prevBtn = document.getElementById("prevTeam");
            const nextBtn = document.getElementById("nextTeam");
            let scrollPosition = 0;
            
            function updateCarouselButtons() {
                prevBtn.disabled = scrollPosition <= 0;
                nextBtn.disabled = scrollPosition >= container.scrollWidth - carousel.clientWidth;
                
                if (container.scrollWidth <= carousel.clientWidth) {
                    prevBtn.classList.add("hidden");
                    nextBtn.classList.add("hidden");
                } else {
                    prevBtn.classList.remove("hidden");
                    nextBtn.classList.remove("hidden");
                }
            }
            
            function scrollCarousel(direction) {
                const scrollAmount = carousel.clientWidth;
                scrollPosition += direction * scrollAmount;
                scrollPosition = Math.max(0, Math.min(scrollPosition, container.scrollWidth - carousel.clientWidth));
                carousel.scrollTo({ left: scrollPosition, behavior: "smooth" });
                updateCarouselButtons();
            }
            
            prevBtn.addEventListener("click", () => scrollCarousel(-1));
            nextBtn.addEventListener("click", () => scrollCarousel(1));
            
            carousel.addEventListener("scroll", () => {
                scrollPosition = carousel.scrollLeft;
                updateCarouselButtons();
            });
            
            window.addEventListener("resize", updateCarouselButtons);
            
            updateCarouselButtons();
            
            if (window.filterSystem) {
                const originalApplyFilters = window.filterSystem.applyFilters;
                window.filterSystem.applyFilters = function() {
                    const visibleCount = originalApplyFilters.call(this);
                    
                    if (visibleCount === 0) {
                        prevBtn.classList.add("hidden");
                        nextBtn.classList.add("hidden");
                    } else {
                        updateCarouselButtons();
                    }
                    
                    scrollPosition = 0;
                    carousel.scrollTo({ left: 0, behavior: "instant" });
                    
                    return visibleCount;
                };
            }
        });