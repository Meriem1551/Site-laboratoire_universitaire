
    document.addEventListener("DOMContentLoaded", function() {
        const itemsPerPage = 6;
        let currentPage = 1;
        let allItems = document.querySelectorAll(".pagination-item");
        let totalItems = allItems.length;
        let totalPages = Math.ceil(totalItems / itemsPerPage);
        
        function updatePaginationInfo() {
            document.getElementById("currentPage").textContent = currentPage;
            document.getElementById("totalPages").textContent = totalPages;
            
            const startItem = (currentPage - 1) * itemsPerPage + 1;
            const endItem = Math.min(currentPage * itemsPerPage, totalItems);
            document.getElementById("visibleItems").textContent = endItem - startItem + 1;
            document.getElementById("totalItems").textContent = totalItems;
            
            document.getElementById("prevPage").disabled = currentPage === 1;
            document.getElementById("nextPage").disabled = currentPage === totalPages;
            
            document.querySelectorAll(".page-btn").forEach(btn => {
                const pageNum = parseInt(btn.getAttribute("data-page"));
                if (pageNum === currentPage) {
                    btn.classList.add("bg-blue-600", "text-white");
                    btn.classList.remove("bg-white", "border", "text-gray-700");
                } else {
                    btn.classList.remove("bg-blue-600", "text-white");
                    btn.classList.add("bg-white", "border", "border-gray-300", "text-gray-700");
                }
            });
        }
        
        function showCurrentPage() {
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            
            allItems.forEach((item, index) => {
                if (index >= startIndex && index < endIndex) {
                    item.style.display = "block";
                    item.style.opacity = "1";
                } else {
                    item.style.display = "none";
                    item.style.opacity = "0";
                }
            });
            
            updatePaginationInfo();
        }
        
        function goToPage(page) {
            currentPage = page;
            showCurrentPage();
        }
        
        document.getElementById("prevPage").addEventListener("click", function() {
            if (currentPage > 1) {
                goToPage(currentPage - 1);
            }
        });
        
        document.getElementById("nextPage").addEventListener("click", function() {
            if (currentPage < totalPages) {
                goToPage(currentPage + 1);
            }
        });
        
        document.querySelectorAll(".page-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                const page = parseInt(this.getAttribute("data-page"));
                goToPage(page);
            });
        });
        
        if (window.filterSystem) {
            const originalApplyFilters = window.filterSystem.applyFilters;
            window.filterSystem.applyFilters = function() {
                const visibleCount = originalApplyFilters.call(this);
                
                // Mettre à jour les éléments paginés
                allItems = document.querySelectorAll(".pagination-item");
                totalItems = allItems.length;
                totalPages = Math.ceil(totalItems / itemsPerPage);
                
                // Réinitialiser à la page 1
                currentPage = 1;
                showCurrentPage();
                
                return visibleCount;
            };
        }
        
        showCurrentPage();
    });