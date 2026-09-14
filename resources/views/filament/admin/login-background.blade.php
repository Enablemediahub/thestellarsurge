<style>
    .stellar-login-backdrop {
        position: fixed;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        background:
            linear-gradient(rgba(50, 21, 47, 0.68), rgba(50, 21, 47, 0.68)),
            url('https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1800&q=80') center / cover no-repeat;
        opacity: 0.38;
    }

    .fi-simple-layout {
        position: relative;
        background: #f7f2e9;
    }

    .fi-simple-main-ctn {
        position: relative;
        z-index: 1;
    }

    .stellar-login-credit {
        position: fixed;
        right: 1.5rem;
        bottom: 1.25rem;
        z-index: 2;
        color: #32152f;
        font-size: 0.7rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }
</style>
<div class="stellar-login-backdrop" aria-hidden="true"></div>
<div class="stellar-login-credit">Developed and Designed by DALE QUIST [Enable Technologies]</div>
