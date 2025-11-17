// Modern Star Rating System
class StarRating {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.stars = [];
        this.currentRating = 4;
        this.init();
    }
    
    init() {
        this.createStars();
        this.bindEvents();
        this.updateDisplay();
    }
    
    createStars() {
        const starsContainer = this.container.querySelector('.stars-container');
        
        for (let i = 1; i <= 5; i++) {
            const star = document.createElement('div');
            star.className = 'star';
            star.dataset.rating = i;
            
            if (i <= this.currentRating) {
                star.classList.add('active', 'selected');
            }
            
            starsContainer.appendChild(star);
            this.stars.push(star);
        }
    }
    
    bindEvents() {
        this.stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                this.setRating(index + 1);
            });
            
            star.addEventListener('mouseenter', () => {
                this.highlightStars(index + 1);
            });
        });
        
        this.container.addEventListener('mouseleave', () => {
            this.highlightStars(this.currentRating);
        });
    }
    
    setRating(rating) {
        this.currentRating = rating;
        this.updateStars();
        this.updateDisplay();
        this.triggerChangeEvent();
    }
    
    highlightStars(rating) {
        this.stars.forEach((star, index) => {
            star.classList.remove('active', 'selected');
            if (index < rating) {
                star.classList.add('active');
            }
        });
    }
    
    updateStars() {
        this.stars.forEach((star, index) => {
            star.classList.remove('active', 'selected');
            if (index < this.currentRating) {
                star.classList.add('active', 'selected');
            }
        });
    }
    
    updateDisplay() {
        const display = this.container.querySelector('.star-rating-display');
        display.textContent = `${this.currentRating} Estrelas`;
        
        // Add animation
        display.style.transform = 'scale(1.2)';
        setTimeout(() => {
            display.style.transform = 'scale(1)';
        }, 200);
    }
    
    triggerChangeEvent() {
        const event = new CustomEvent('ratingChanged', {
            detail: { rating: this.currentRating }
        });
        this.container.dispatchEvent(event);
    }
}

// Platform Management System
class PlatformManager {
    constructor() {
        this.platforms = [
            {
                id: 'tripadvisor',
                name: 'Tripadvisor',
                category: ['popular', 'hospitality'],
                logo: '/assets/images/platforms/tripadvisor.png',
                color: '#00AA6C'
            },
            {
                id: 'google',
                name: 'Google',
                category: ['popular'],
                logo: '/assets/images/platforms/google.png',
                color: '#4285F4'
            },
            {
                id: 'facebook',
                name: 'Facebook',
                category: ['popular'],
                logo: '/assets/images/platforms/facebook.png',
                color: '#1877F2'
            },
            {
                id: 'yelp',
                name: 'Yelp',
                category: ['popular', 'hospitality'],
                logo: '/assets/images/platforms/yelp.png',
                color: '#FF1A1A'
            },
            {
                id: 'trustpilot',
                name: 'Trustpilot',
                category: ['popular', 'technology'],
                logo: '/assets/images/platforms/trustpilot.png',
                color: '#00B67A'
            },
            {
                id: 'bbb',
                name: 'BBB',
                category: ['popular'],
                logo: '/assets/images/platforms/bbb.png',
                color: '#1E3A8A'
            },
            {
                id: 'autotrader',
                name: 'AutoTrader',
                category: ['automotive'],
                logo: '/assets/images/platforms/autotrader.png',
                color: '#FF6B35'
            },
            {
                id: 'yell',
                name: 'Yell',
                category: ['popular'],
                logo: '/assets/images/platforms/yell.png',
                color: '#FFD700'
            }
        ];
        
        this.selectedPlatforms = [];
        this.currentFilter = 'popular';
        this.init();
    }
    
    init() {
        this.createPlatformCards();
        this.bindEvents();
        this.loadImages();
    }
    
    createPlatformCards() {
        const grid = document.getElementById('platformsGrid');
        grid.innerHTML = '';
        
        this.platforms.forEach(platform => {
            const card = this.createPlatformCard(platform);
            grid.appendChild(card);
        });
    }
    
    createPlatformCard(platform) {
        const card = document.createElement('div');
        card.className = 'platform-card';
        card.dataset.category = platform.category.join(' ');
        card.dataset.platformId = platform.id;
        
        card.innerHTML = `
            <div class="platform-logo loading">
                <img src="${platform.logo}" alt="${platform.name}" onerror="this.style.display='none'; this.parentElement.innerHTML='<i class=\\"fas fa-star text-2xl\\" style=\\"color: ${platform.color}\\"></i>'">
            </div>
            <h3 class="platform-name">${platform.name}</h3>
            <p class="platform-subtitle">Escolher?</p>
            <input type="checkbox" class="platform-checkbox" name="platforms[]" value="${platform.id}">
        `;
        
        return card;
    }
    
    bindEvents() {
        // Category filters
        document.querySelectorAll('.category-filter').forEach(button => {
            button.addEventListener('click', (e) => {
                this.setFilter(e.target.dataset.category);
            });
        });
        
        // Search functionality
        document.getElementById('platformSearch').addEventListener('input', (e) => {
            this.searchPlatforms(e.target.value);
        });
        
        // Platform selection
        document.addEventListener('change', (e) => {
            if (e.target.classList.contains('platform-checkbox')) {
                this.handlePlatformSelection(e.target);
            }
        });
        
        // Card click to select
        document.addEventListener('click', (e) => {
            const card = e.target.closest('.platform-card');
            if (card) {
                const checkbox = card.querySelector('.platform-checkbox');
                checkbox.checked = !checkbox.checked;
                this.handlePlatformSelection(checkbox);
            }
        });
    }
    
    setFilter(category) {
        // Update active filter button
        document.querySelectorAll('.category-filter').forEach(btn => {
            btn.classList.remove('active');
        });
        document.querySelector(`[data-category="${category}"]`).classList.add('active');
        
        this.currentFilter = category;
        this.filterPlatforms();
    }
    
    filterPlatforms() {
        const cards = document.querySelectorAll('.platform-card');
        
        cards.forEach(card => {
            const categories = card.dataset.category.split(' ');
            const shouldShow = this.currentFilter === 'all' || categories.includes(this.currentFilter);
            
            if (shouldShow) {
                card.style.display = 'block';
                card.style.animation = 'fadeIn 0.3s ease';
            } else {
                card.style.display = 'none';
            }
        });
    }
    
    searchPlatforms(searchTerm) {
        const cards = document.querySelectorAll('.platform-card');
        const term = searchTerm.toLowerCase();
        
        cards.forEach(card => {
            const platformName = card.querySelector('.platform-name').textContent.toLowerCase();
            const categories = card.dataset.category.split(' ');
            const shouldShow = platformName.includes(term) && 
                             (this.currentFilter === 'all' || categories.includes(this.currentFilter));
            
            if (shouldShow) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
    
    handlePlatformSelection(checkbox) {
        const card = checkbox.closest('.platform-card');
        const platformId = checkbox.value;
        
        if (checkbox.checked) {
            if (this.selectedPlatforms.length >= 5) {
                checkbox.checked = false;
                this.showNotification('Você pode selecionar no máximo 5 plataformas.', 'warning');
                return;
            }
            
            this.selectedPlatforms.push(platformId);
            card.classList.add('selected');
        } else {
            this.selectedPlatforms = this.selectedPlatforms.filter(id => id !== platformId);
            card.classList.remove('selected');
        }
        
        this.updateSelectionCount();
    }
    
    updateSelectionCount() {
        const count = this.selectedPlatforms.length;
        const maxCount = 5;
        
        // Update UI to show selection count
        const selectionInfo = document.querySelector('.selection-info');
        if (selectionInfo) {
            selectionInfo.textContent = `${count}/${maxCount} plataformas selecionadas`;
        }
    }
    
    loadImages() {
        // Add fade-in animation when images load
        document.querySelectorAll('.platform-logo img').forEach(img => {
            img.addEventListener('load', () => {
                img.parentElement.classList.remove('loading');
                img.style.animation = 'fadeIn 0.5s ease';
            });
        });
    }
    
    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        
        // Style the notification
        Object.assign(notification.style, {
            position: 'fixed',
            top: '20px',
            right: '20px',
            padding: '1rem 1.5rem',
            borderRadius: '12px',
            color: 'white',
            fontWeight: '500',
            zIndex: '1000',
            transform: 'translateX(100%)',
            transition: 'transform 0.3s ease',
            background: type === 'warning' ? '#f59e0b' : '#8b5cf6'
        });
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Initialize star rating
    const starRating = new StarRating('starRatingContainer');
    
    // Initialize platform manager
    const platformManager = new PlatformManager();
    
    // Listen for rating changes
    document.getElementById('starRatingContainer').addEventListener('ratingChanged', (e) => {
        document.getElementById('positiveScore').value = e.detail.rating;
        updateProgress();
    });
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .notification {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
`;
document.head.appendChild(style);

