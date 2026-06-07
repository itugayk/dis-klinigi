import './bootstrap';

/**
 * Scroll-reveal: .reveal öğeleri görünüm alanına girince .is-visible alır.
 * Sayaçlar (data-counter) görününce 0'dan hedefe sayar.
 */
function initReveal() {
    const revealEls = document.querySelectorAll('.reveal:not(.is-visible)');
    if (!('IntersectionObserver' in window)) {
        revealEls.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const obs = new IntersectionObserver(
        (entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );

    revealEls.forEach((el) => obs.observe(el));
}

function initCounters() {
    const counters = document.querySelectorAll('[data-counter]:not([data-counted])');
    if (!counters.length) return;

    const run = (el) => {
        el.setAttribute('data-counted', '1');
        const target = parseFloat(el.getAttribute('data-counter')) || 0;
        const dur = 1600;
        const start = performance.now();
        const fmt = new Intl.NumberFormat('tr-TR');
        const tick = (now) => {
            const p = Math.min((now - start) / dur, 1);
            const eased = 1 - Math.pow(1 - p, 3);
            el.textContent = fmt.format(Math.floor(eased * target));
            if (p < 1) requestAnimationFrame(tick);
            else el.textContent = fmt.format(target);
        };
        requestAnimationFrame(tick);
    };

    if (!('IntersectionObserver' in window)) {
        counters.forEach(run);
        return;
    }
    const obs = new IntersectionObserver((entries, o) => {
        entries.forEach((e) => {
            if (e.isIntersecting) {
                run(e.target);
                o.unobserve(e.target);
            }
        });
    }, { threshold: 0.4 });
    counters.forEach((el) => obs.observe(el));
}

function boot() {
    initReveal();
    initCounters();
}

document.addEventListener('DOMContentLoaded', boot);
// Livewire navigate / DOM güncellemeleri sonrası tekrar bağla
document.addEventListener('livewire:navigated', boot);
window.addEventListener('load', boot);
