class ExpoSlider {
    constructor(container) {
        this.container = container;
        this.sliderTrack = container.querySelector('.slider-track');
        this.slides = container.querySelectorAll('.slide');
        this.progressFill = container.querySelector('.progress-fill');
        
        // Check if required elements exist
        if (!this.sliderTrack || this.slides.length === 0) {
            return;
        }
        
        this.totalSlides = this.slides.length;
        this.currentSlide = 0;
        this.isAutoPlaying = true;
        this.autoPlayDelay = 5000;
        this.autoPlayInterval = null;
        
        this.touchStartX = 0;
        this.touchStartY = 0;
        this.touchEndX = 0;
        this.touchEndY = 0;
        
        this.init();
    }

    init() {
        if (this.totalSlides === 0) return;
        
        this.goToSlide(0);
        this.startAutoPlay();
        this.addEventListeners();
        this.addParticleEffects();
    }

    addEventListeners() {
        if (!this.container) return;
        
        // Store event handler references for proper cleanup
        this._keydownHandler = (e) => {
            switch(e.key) {
                case 'ArrowLeft':
                    e.preventDefault();
                    e.stopPropagation();
                    this.previousSlide();
                    break;
                case 'ArrowRight':
                    e.preventDefault();
                    e.stopPropagation();
                    this.nextSlide();
                    break;
                case ' ':
                    e.preventDefault();
                    e.stopPropagation();
                    this.toggleAutoPlay();
                    break;
            }
        };

        this._touchstartHandler = (e) => {
            this.touchStartX = e.touches[0].clientX;
            this.touchStartY = e.touches[0].clientY;
        };

        this._touchendHandler = (e) => {
            this.touchEndX = e.changedTouches[0].clientX;
            this.touchEndY = e.changedTouches[0].clientY;
            this.handleSwipe(this.touchStartX, this.touchStartY, this.touchEndX, this.touchEndY);
        };

        let isMouseDown = false;
        let mouseStartX = 0;
        let mouseStartY = 0;
        let mouseCurrentX = 0;
        let mouseCurrentY = 0;

        this._mousedownHandler = (e) => {
            isMouseDown = true;
            mouseStartX = e.clientX;
            mouseStartY = e.clientY;
            mouseCurrentX = e.clientX;
            mouseCurrentY = e.clientY;
            
            e.preventDefault();
            e.stopPropagation();
            
            this.container.style.cursor = 'grabbing';
        };

        this._mousemoveHandler = (e) => {
            if (!isMouseDown) return;
            
            mouseCurrentX = e.clientX;
            mouseCurrentY = e.clientY;
        };

        this._mouseupHandler = (e) => {
            if (!isMouseDown) return;
            
            isMouseDown = false;
            
            this.container.style.cursor = 'grab';
            
            const deltaX = mouseCurrentX - mouseStartX;
            const deltaY = mouseCurrentY - mouseStartY;
            
            if (Math.abs(deltaX) > 50) {
                this.handleSwipe(mouseStartX, mouseStartY, mouseCurrentX, mouseCurrentY);
            }
        };

        this._mouseleaveHandler = () => {
            if (isMouseDown) {
                isMouseDown = false;
                this.container.style.cursor = 'grab';
            }
            this.resumeAutoPlay();
        };

        this._mouseenterHandler = () => {
            this.pauseAutoPlay();
            this.container.style.cursor = 'grab';
        };

        // Add event listeners
        this.container.addEventListener('keydown', this._keydownHandler);
        this.container.addEventListener('touchstart', this._touchstartHandler);
        this.container.addEventListener('touchend', this._touchendHandler);
        this.container.addEventListener('mousedown', this._mousedownHandler);
        this.container.addEventListener('mousemove', this._mousemoveHandler);
        this.container.addEventListener('mouseup', this._mouseupHandler);
        this.container.addEventListener('mouseleave', this._mouseleaveHandler);
        this.container.addEventListener('mouseenter', this._mouseenterHandler);

        this.container.setAttribute('tabindex', '0');
    }

    addParticleEffects() {
        if (!this.container) return;
        
        for (let i = 0; i < 10; i++) {
            this.createParticle();
        }
    }

    createParticle() {
        if (!this.container) return;
        
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.cssText = `
            position: absolute;
            width: 3px;
            height: 3px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            pointer-events: none;
            animation: float 6s infinite linear;
            z-index: 1;
        `;
        
        particle.style.left = Math.random() * 100 + '%';
        particle.style.top = Math.random() * 100 + '%';
        
        particle.style.animationDelay = Math.random() * 6 + 's';
        
        this.container.appendChild(particle);
        
        setTimeout(() => {
            if (particle.parentNode) {
                particle.parentNode.removeChild(particle);
            }
            setTimeout(() => this.createParticle(), Math.random() * 3000);
        }, 6000);
    }

    goToSlide(index) {
        if (!this.slides || this.slides.length === 0) return;
        if (index < 0 || index >= this.totalSlides) return;

        // Remove active class from current slide
        if (this.slides[this.currentSlide]) {
            this.slides[this.currentSlide].classList.remove('active');
        }

        this.currentSlide = index;

        // Add active class to new slide
        if (this.slides[this.currentSlide]) {
            this.slides[this.currentSlide].classList.add('active');
        }

        this.resetAutoPlay();
    }

    nextSlide() {
        if (this.totalSlides === 0) return;
        const nextIndex = (this.currentSlide + 1) % this.totalSlides;
        this.goToSlide(nextIndex);
    }

    previousSlide() {
        if (this.totalSlides === 0) return;
        const prevIndex = this.currentSlide === 0 ? this.totalSlides - 1 : this.currentSlide - 1;
        this.goToSlide(prevIndex);
    }

    handleSwipe(startX, startY, endX, endY) {
        if (this.totalSlides === 0) return;
        
        const deltaX = endX - startX;
        const deltaY = endY - startY;
        const minSwipeDistance = 50;

        if (Math.abs(deltaX) > Math.abs(deltaY)) {
            if (Math.abs(deltaX) > minSwipeDistance) {
                if (deltaX > 0) {
                    this.previousSlide();
                } else {
                    this.nextSlide();
                }
            }
        }
    }

    startAutoPlay() {
        if (this.autoPlayInterval || this.totalSlides === 0) return;
        
        this.autoPlayInterval = setInterval(() => {
            if (this.isAutoPlaying) {
                this.nextSlide();
            }
        }, this.autoPlayDelay);
    }

    pauseAutoPlay() {
        this.isAutoPlaying = false;
    }

    resumeAutoPlay() {
        this.isAutoPlaying = true;
    }

    toggleAutoPlay() {
        this.isAutoPlaying = !this.isAutoPlaying;
        if (this.isAutoPlaying) {
            this.startAutoPlay();
        } else {
            this.pauseAutoPlay();
        }
    }

    resetAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.startAutoPlay();
        }
    }

    play() {
        this.isAutoPlaying = true;
        this.startAutoPlay();
    }

    pause() {
        this.isAutoPlaying = false;
        this.pauseAutoPlay();
    }

    setSpeed(delay) {
        this.autoPlayDelay = delay;
        this.resetAutoPlay();
    }

    goToSlideIndex(index) {
        this.goToSlide(index);
    }

    refreshSlides() {
        if (this.container) {
            this.container.removeEventListener('keydown', this._keydownHandler);
            this.container.removeEventListener('touchstart', this._touchstartHandler);
            this.container.removeEventListener('touchend', this._touchendHandler);
            this.container.removeEventListener('mousedown', this._mousedownHandler);
            this.container.removeEventListener('mousemove', this._mousemoveHandler);
            this.container.removeEventListener('mouseup', this._mouseupHandler);
            this.container.removeEventListener('mouseleave', this._mouseleaveHandler);
            this.container.removeEventListener('mouseenter', this._mouseenterHandler);
        }
        
        this.slides = this.container.querySelectorAll('.slide');
        this.totalSlides = this.slides.length;
        
        if (this.totalSlides > 0) {
            this.currentSlide = 0;
            this.goToSlide(0);
            
            this.addEventListeners();
            
            this.startAutoPlay();
        }
    }

    destroy() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.autoPlayInterval = null;
        }
        
        if (this.container) {
            this.container.removeEventListener('keydown', this._keydownHandler);
            this.container.removeEventListener('touchstart', this._touchstartHandler);
            this.container.removeEventListener('touchend', this._touchendHandler);
            this.container.removeEventListener('mousedown', this._mousedownHandler);
            this.container.removeEventListener('mousemove', this._mousemoveHandler);
            this.container.removeEventListener('mouseup', this._mouseupHandler);
            this.container.removeEventListener('mouseleave', this._mouseleaveHandler);
            this.container.removeEventListener('mouseenter', this._mouseenterHandler);
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    
    const desktopSliderContainer = document.querySelector('.d-none.d-md-block .slider-container');
    if (desktopSliderContainer) {
        window.desktopExpoSlider = new ExpoSlider(desktopSliderContainer);
    }
    
    const mobileSliderContainer = document.querySelector('.d-block.d-md-none .slider-container');
    if (mobileSliderContainer) {
        window.mobileExpoSlider = new ExpoSlider(mobileSliderContainer);
    }
    
    const allSliderContainers = document.querySelectorAll('.slider-container');
    
    if (allSliderContainers.length > 0 && !window.desktopExpoSlider && !window.mobileExpoSlider) {
        allSliderContainers.forEach((container, index) => {
            window[`expoSlider${index}`] = new ExpoSlider(container);
        });
    }
    
});

const style = document.createElement('style');
style.textContent = `
    @keyframes float {
        0% {
            transform: translateY(0px) rotate(0deg);
            opacity: 1;
        }
        100% {
            transform: translateY(-100px) rotate(360deg);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style); 