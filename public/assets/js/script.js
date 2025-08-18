function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top < window.innerHeight - 60 &&
        rect.bottom > 0
    );
}

// Counter animation
function animateCounter(el, target) {
    let start = 0;
    let duration = 1200;
    let startTimestamp = null;
    let decimal = (target + '').includes('.') ? 1 : 0;
    let displayTarget = target;

    let prefix = '';
    let suffix = '';
    let text = el.textContent.trim();
    if (text.startsWith('~') || text.startsWith('>') || text.startsWith('$')) prefix = text[0];
    if (text.endsWith('%') || text.endsWith('+') || text.endsWith('ha') || text.endsWith('Tỷ') || text.endsWith('Triệu')) suffix = text.replace(/[0-9\.,]+/g, '').replace(prefix, '');

    function step(ts) {
        if (!startTimestamp) startTimestamp = ts;
        let progress = Math.min((ts - startTimestamp) / duration, 1);
        let value = start + (target - start) * progress;
        el.textContent = prefix + value.toLocaleString('vi-VN', {minimumFractionDigits: decimal, maximumFractionDigits: decimal}) + suffix;
        if (progress < 1) {
            requestAnimationFrame(step);
        } else {
            el.textContent = prefix + displayTarget.toLocaleString('vi-VN', {minimumFractionDigits: decimal, maximumFractionDigits: decimal}) + suffix;
        }
    }
    requestAnimationFrame(step);
}

function animateOnScroll() {
    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        if (isInViewport(el)) {
            if (!el.classList.contains('animated')) {
                el.classList.add('animated');
                // Counter cho intro-home
                if (el.classList.contains('line-2') && el.hasAttribute('data-target')) {
                    let target = parseFloat(el.getAttribute('data-target').replace(/[^\d\.]/g, ''));
                    animateCounter(el, target);
                }
                // Counter cho intro-location
                if (el.classList.contains('location-stat-value') && el.hasAttribute('data-target')) {
                    let target = parseFloat(el.getAttribute('data-target').replace(/[^\d\.]/g, ''));
                    animateCounter(el, target);
                }

                document.querySelectorAll('.line-2-intro-project[data-target]').forEach(el => {
                    let target = parseFloat(el.getAttribute('data-target').replace(/[^\d\.]/g, ''));
                    animateCounter(el, target);
                });
            }
        }
    });
}
window.addEventListener('scroll', animateOnScroll);
window.addEventListener('DOMContentLoaded', animateOnScroll);
