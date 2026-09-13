import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

const installPrompt = document.querySelector('[data-install-prompt]');
const installButton = document.querySelector('[data-install-app]');
const installDismiss = document.querySelector('[data-install-dismiss]');
const cookieBanner = document.querySelector('[data-cookie-banner]');
const cookieAccept = document.querySelector('[data-cookie-accept]');
const cookieDismiss = document.querySelector('[data-cookie-dismiss]');
const portalLoader = document.querySelector('[data-portal-loader]');
const portalLoaderLogo = document.querySelector('[data-portal-loader-logo]');
const portalLoaderLabel = document.querySelector('[data-portal-loader-label]');
let deferredPrompt = null;

if (cookieBanner && !localStorage.getItem('stellar-surge-cookie-choice')) {
    cookieBanner.hidden = false;
}

const closeCookieBanner = (choice) => {
    localStorage.setItem('stellar-surge-cookie-choice', choice);

    if (cookieBanner) {
        cookieBanner.hidden = true;
    }
};

cookieAccept?.addEventListener('click', () => closeCookieBanner('accepted'));
cookieDismiss?.addEventListener('click', () => closeCookieBanner('dismissed'));

document.querySelectorAll('[data-portal-loading]').forEach((portalLink) => {
    portalLink.addEventListener('click', () => {
        if (!portalLoader) {
            return;
        }

        portalLoader.style.setProperty('--portal-loader-color', portalLink.dataset.portalColor || '#e27f7f');
        portalLoaderLogo.src = portalLink.dataset.portalLogo || portalLoaderLogo.src;
        portalLoaderLabel.textContent = `Opening ${portalLink.getAttribute('aria-label') || 'portal'}`;
        portalLoader.hidden = false;
    });
});

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => navigator.serviceWorker.register('/sw.js').catch(() => {}));
}

window.addEventListener('beforeinstallprompt', (event) => {
    event.preventDefault();
    deferredPrompt = event;

    if (installPrompt && !localStorage.getItem('stellar-surge-install-dismissed')) {
        installPrompt.hidden = false;
    }
});

if (installButton) {
    installButton.addEventListener('click', async () => {
        if (!deferredPrompt) {
            return;
        }

        deferredPrompt.prompt();
        await deferredPrompt.userChoice;
        deferredPrompt = null;
        installPrompt.hidden = true;
    });
}

installDismiss?.addEventListener('click', () => {
    localStorage.setItem('stellar-surge-install-dismissed', 'true');
    installPrompt.hidden = true;
});

const featuredLayer = document.querySelector('[data-featured-slider]');
const featuredSlides = [...document.querySelectorAll('[data-featured-slide]')];
const featuredDots = [...document.querySelectorAll('[data-featured-dot]')];
let featuredIndex = 0;

if (featuredLayer && featuredSlides.length) {
    const showFeatured = (index) => {
        featuredIndex = (index + featuredSlides.length) % featuredSlides.length;
        featuredSlides.forEach((slide, slideIndex) => slide.classList.toggle('is-active', slideIndex === featuredIndex));
        featuredDots.forEach((dot, dotIndex) => dot.classList.toggle('is-active', dotIndex === featuredIndex));
    };

    document.querySelector('[data-featured-close]')?.addEventListener('click', () => {
        featuredLayer.hidden = true;
    });
    document.querySelector('[data-featured-prev]')?.addEventListener('click', () => showFeatured(featuredIndex - 1));
    document.querySelector('[data-featured-next]')?.addEventListener('click', () => showFeatured(featuredIndex + 1));
    featuredDots.forEach((dot, index) => dot.addEventListener('click', () => showFeatured(index)));
}

document.querySelectorAll('[data-share-url]').forEach((shareButton) => {
    shareButton.addEventListener('click', async () => {
        const url = shareButton.dataset.shareUrl;
        const title = shareButton.dataset.shareTitle || document.title;

        if (navigator.share) {
            await navigator.share({ title, url });
            return;
        }

        await navigator.clipboard.writeText(url);
        const originalLabel = shareButton.textContent;
        shareButton.textContent = 'Link copied';
        setTimeout(() => { shareButton.textContent = originalLabel; }, 1800);
    });
});
