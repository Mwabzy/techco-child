/* ===========================================================
   Techco Child — custom JS for Visioner Training pages
   Brochure gate, scroll reveals, pricing card tilt, cursor
   glow, and accordion expand-all toggle.
   =========================================================== */
( function () {
    'use strict';

    /* ---------------------------------------------------------
       Brochure gate: reveal download once Fluent Form submits
       --------------------------------------------------------- */
    function unlockBrochure() {
        var box = document.querySelector('.tc-brochure');
        if ( ! box ) { return; }
        box.setAttribute('data-state', 'unlocked');
        var link = box.querySelector('.tc-brochure__link');
        if ( link ) { link.hidden = false; }
    }

    /* ---------------------------------------------------------
       Course-content accordion: "Expand all" / "Collapse all"
       --------------------------------------------------------- */
    function initExpandAll() {
        var btn = document.querySelector('[data-tc-expand-all]');
        if ( ! btn ) { return; }
        var acc = btn.closest('.tc-curriculum');
        if ( ! acc ) { return; }

        btn.addEventListener('click', function () {
            var items = acc.querySelectorAll('.tc-acc__item');
            var anyClosed = Array.prototype.some.call(items, function (d) { return ! d.open; });
            Array.prototype.forEach.call(items, function (d) { d.open = anyClosed; });
            btn.textContent = anyClosed ? 'Collapse all sections' : 'Expand all sections';
        });
    }

    /* ---------------------------------------------------------
       Scroll-triggered reveal (IntersectionObserver)
       Observes `.tc-reveal` elements, adds `.tc-revealed` on enter.
       --------------------------------------------------------- */
    function initScrollReveal() {
        var reveals = document.querySelectorAll('.tc-reveal');
        if ( ! reveals.length ) { return; }

        // Fallback: if IntersectionObserver is unsupported, reveal all
        if ( ! ('IntersectionObserver' in window) ) {
            Array.prototype.forEach.call(reveals, function (el) {
                el.classList.add('tc-revealed');
            });
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if ( entry.isIntersecting ) {
                    entry.target.classList.add('tc-revealed');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.08,
            rootMargin: '0px 0px -40px 0px'
        });

        Array.prototype.forEach.call(reveals, function (el) {
            observer.observe(el);
        });
    }

    /* ---------------------------------------------------------
       Pricing card 3D tilt on hover (lightweight, no library)
       Maps cursor position → subtle rotateX / rotateY transform
       Also tracks --mouse-x/--mouse-y for the CSS radial glow.
       --------------------------------------------------------- */
    function initCardTilt() {
        var cards = document.querySelectorAll('[data-tilt]');
        if ( ! cards.length ) { return; }

        // Skip on touch devices — tilt doesn't work well there
        if ( 'ontouchstart' in window ) { return; }

        Array.prototype.forEach.call(cards, function (card) {
            card.addEventListener('mousemove', function (e) {
                var rect = card.getBoundingClientRect();
                var x = e.clientX - rect.left;
                var y = e.clientY - rect.top;
                var midX = rect.width / 2;
                var midY = rect.height / 2;

                // Subtle tilt: ±6 degrees max
                var rotateY = ((x - midX) / midX) * 6;
                var rotateX = ((midY - y) / midY) * 6;

                card.style.transform =
                    'perspective(800px) rotateX(' + rotateX.toFixed(2) + 'deg) rotateY(' + rotateY.toFixed(2) + 'deg) translateY(-4px)';

                // Feed cursor position to CSS for the radial glow
                var percentX = ((x / rect.width) * 100).toFixed(1) + '%';
                var percentY = ((y / rect.height) * 100).toFixed(1) + '%';
                card.style.setProperty('--mouse-x', percentX);
                card.style.setProperty('--mouse-y', percentY);
            });

            card.addEventListener('mouseleave', function () {
                card.style.transform = '';
                card.style.removeProperty('--mouse-x');
                card.style.removeProperty('--mouse-y');
            });
        });
    }

    /* ---------------------------------------------------------
       Hero stat counter fade-in
       Stagger the data-animate attributes so they pop in sequence.
       --------------------------------------------------------- */
    function initStatAnimation() {
        var stats = document.querySelectorAll('.tc-stat__num[data-animate]');
        if ( ! stats.length ) { return; }

        Array.prototype.forEach.call(stats, function (el, i) {
            el.style.animationDelay = (i * 150) + 'ms';
        });
    }

    /* ---------------------------------------------------------
       Bootstrap on DOMContentLoaded
       --------------------------------------------------------- */
    document.addEventListener('DOMContentLoaded', function () {

        initExpandAll();
        initScrollReveal();
        initCardTilt();
        initStatAnimation();

        // Fluent Forms fires this jQuery event on successful AJAX submit.
        if ( window.jQuery ) {
            jQuery(document).on('fluentform_submission_success', function () {
                unlockBrochure();
            });
        }

        // Fallback: native event some Fluent Forms versions dispatch.
        document.addEventListener('fluentform_submission_success', unlockBrochure);
    });
} )();
