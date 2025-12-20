

document.addEventListener("DOMContentLoaded", () => {
  const track = document.querySelector('.diaporama-track');
  const slides = document.querySelectorAll('.diaporama-slide');
 
  let index = 0;
  const total = slides.length;

  function showSlide(i) {
    track.style.transform = `translateX(-${i * 100}%)`;
  }

  setInterval(() => {
    index = (index + 1) % total;
    showSlide(index);
  }, 3000);
});



class PublicationsFilter {
    constructor(sectionId) {
        this.sectionId = sectionId;
        this.container = document.getElementById(sectionId);
        if (!this.container) return;
        
        this.initializeElements();
        this.initializeData();
        this.bindEvents();
    }
    
    initializeElements() {
        this.elements = {
            titleFilter: document.getElementById(`filter-title-${this.sectionId}`),
            domainFilter: document.getElementById(`filter-domain-${this.sectionId}`),
            authorsFilter: document.getElementById(`filter-authors-${this.sectionId}`),
            tableContainer: document.getElementById(`publications-table-${this.sectionId}`),
            noResultsMessage: document.getElementById(`no-results-${this.sectionId}`),
            resultsCount: document.getElementById(`filter-results-${this.sectionId}`),
            resetButtons: document.querySelectorAll(`[data-section="${this.sectionId}"].filter-reset-btn, [data-section="${this.sectionId}"].no-results-reset-btn`)
        };
    }
    
    initializeData() {
        // Extract data from the current table
        this.originalData = this.extractTableData();
        this.filteredData = [...this.originalData];
    }
    
    extractTableData() {
        const data = [];
        const table = this.elements.tableContainer.querySelector('table');
        
        if (!table) return [];
        
        const rows = table.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length >= 7) {
                data.push({
                    title: cells[0].textContent.toLowerCase(),
                    domain: cells[1].textContent.toLowerCase(),
                    authors: '', // Authors data would need to be added to your table
                    html: row.outerHTML
                });
            }
        });
        
        return data;
    }
    
    bindEvents() {
        // Filter inputs
        [this.elements.titleFilter, this.elements.domainFilter, this.elements.authorsFilter].forEach(input => {
            if (input) {
                input.addEventListener('input', () => this.debouncedFilter());
            }
        });
        
        // Reset buttons
        this.elements.resetButtons.forEach(button => {
            if (button) {
                button.addEventListener('click', () => this.resetFilters());
            }
        });
    }
    
    debouncedFilter() {
        clearTimeout(this.filterTimeout);
        this.filterTimeout = setTimeout(() => this.applyFilters(), 300);
    }
    
    applyFilters() {
        const titleValue = this.elements.titleFilter?.value.toLowerCase() || '';
        const domainValue = this.elements.domainFilter?.value.toLowerCase() || '';
        const authorsValue = this.elements.authorsFilter?.value.toLowerCase() || '';
        
        this.filteredData = this.originalData.filter(item => {
            const matchesTitle = !titleValue || item.title.includes(titleValue);
            const matchesDomain = !domainValue || item.domain === domainValue;
            const matchesAuthors = !authorsValue || item.authors.includes(authorsValue);
            
            return matchesTitle && matchesDomain && matchesAuthors;
        });
        
        this.updateDisplay();
    }
    
    updateDisplay() {
        const table = this.elements.tableContainer.querySelector('table tbody');
        const hasResults = this.filteredData.length > 0;
        
        // Update table
        if (table && hasResults) {
            table.innerHTML = this.filteredData.map(item => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(item.html, 'text/html');
                const row = doc.body.firstChild;
                return row.outerHTML;
            }).join('');
        }
        
        // Show/hide elements
        this.elements.tableContainer.style.display = hasResults ? 'block' : 'none';
        this.elements.noResultsMessage.style.display = hasResults ? 'none' : 'block';
        
        // Update results count
        if (this.elements.resultsCount) {
            this.elements.resultsCount.textContent = `${this.filteredData.length} publication(s)`;
            this.elements.resultsCount.style.color = hasResults ? '#667eea' : '#e53e3e';
        }
    }
    
    resetFilters() {
        if (this.elements.titleFilter) this.elements.titleFilter.value = '';
        if (this.elements.domainFilter) this.elements.domainFilter.value = '';
        if (this.elements.authorsFilter) this.elements.authorsFilter.value = '';
        this.applyFilters();
    }
}

// Auto-initialize all publication sections
document.addEventListener('DOMContentLoaded', () => {
    const publicationSections = document.querySelectorAll('.publications-section[data-section-id]');
    
    publicationSections.forEach(section => {
        const sectionId = section.getAttribute('data-section-id');
        if (sectionId) {
            new PublicationsFilter(sectionId);
        }
    });
});

// Export for manual initialization
window.PublicationsFilter = PublicationsFilter;