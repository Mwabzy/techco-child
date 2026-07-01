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
       Hero stat counter: real 0 → target count-up on scroll into
       view, staggered. Parses the leading number out of the
       element's own text (keeping any prefix/suffix, e.g. "4.8★",
       "12,000+", decimals via toFixed) so no markup changes are
       needed beyond the existing data-animate attribute.
       --------------------------------------------------------- */
    function initStatAnimation() {
        var stats = document.querySelectorAll('.tc-stat__num[data-animate]');
        if ( ! stats.length ) { return; }

        var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        Array.prototype.forEach.call(stats, function (el, i) {
            el.style.animationDelay = (i * 150) + 'ms';

            var raw = el.textContent.trim();
            var match = raw.match(/^([^\d]*)([\d,]*\.?\d+)([^\d]*)$/);
            if ( ! match || reduceMotion ) { return; }

            var prefix = match[1];
            var numStr = match[2];
            var suffix = match[3];
            var target = parseFloat(numStr.replace(/,/g, ''));
            var decimals = (numStr.split('.')[1] || '').length;
            var hasCommas = numStr.indexOf(',') !== -1;

            function format(value) {
                var fixed = value.toFixed(decimals);
                if ( hasCommas ) {
                    var parts = fixed.split('.');
                    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                    fixed = parts.join('.');
                }
                return prefix + fixed + suffix;
            }

            el.textContent = format(0);

            var trigger = function () {
                var duration = 1200;
                var start = null;

                function step(timestamp) {
                    if ( start === null ) { start = timestamp; }
                    var progress = Math.min((timestamp - start) / duration, 1);
                    var eased = 1 - Math.pow(1 - progress, 3); // ease-out cubic
                    el.textContent = format(target * eased);
                    if ( progress < 1 ) {
                        requestAnimationFrame(step);
                    }
                }
                requestAnimationFrame(step);
            };

            if ( 'IntersectionObserver' in window ) {
                var observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if ( entry.isIntersecting ) {
                            setTimeout(trigger, i * 150);
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.4 });
                observer.observe(el);
            } else {
                trigger();
            }
        });
    }

    /* ---------------------------------------------------------
       Admissions form: two-step reveal
       Step 2 (.tc-ff-step2) stays visually collapsed until Step 1's
       required fields validate, keeping this a single-submission
       form (not Fluent Forms' native multi-page). Scoped to the
       Apply page's form only — TPO form on page-colleges.php is
       untouched.
       --------------------------------------------------------- */
    function initApplyFormSteps() {
        var step1 = document.querySelector('.tc-apply-form .tc-ff-step1');
        var step2 = document.querySelector('.tc-apply-form .tc-ff-step2');
        var continueBtn = document.getElementById('tc-ff-continue');
        if ( ! step1 || ! step2 || ! continueBtn ) { return; }

        var form = step2.closest('form') || step2.closest('.fluentform');
        var submitWrap = form ? form.querySelector('.ff_submit_btn_wrapper') : null;

        // Only hide the submit button now that we've confirmed the full
        // two-step structure is in place — never hidden unconditionally.
        if ( submitWrap ) { submitWrap.classList.add('tc-ff-submit--hidden'); }

        // Small "Step 1 of 2 / Step 2 of 2" progress indicator, inserted above the form.
        var progress = document.createElement('div');
        progress.className = 'tc-ff-progress';
        progress.innerHTML =
            '<span class="tc-ff-progress__step tc-ff-progress__step--active">' +
                '<span class="tc-ff-progress__dot"></span>Step 1 of 2' +
            '</span>' +
            '<span class="tc-ff-progress__step">' +
                '<span class="tc-ff-progress__dot"></span>Step 2 of 2' +
            '</span>';
        step1.parentNode.insertBefore(progress, step1);

        var steps = progress.querySelectorAll('.tc-ff-progress__step');

        continueBtn.addEventListener('click', function () {
            var invalid = step1.querySelector(':invalid');
            if ( invalid ) {
                invalid.reportValidity();
                return;
            }

            step2.classList.add('tc-ff-step2--visible');
            if ( submitWrap ) {
                submitWrap.classList.remove('tc-ff-submit--hidden');
                submitWrap.classList.add('tc-ff-submit--visible');
            }
            (continueBtn.closest('.ff-el-group') || continueBtn).hidden = true;

            if ( steps[0] ) { steps[0].classList.remove('tc-ff-progress__step--active'); }
            if ( steps[1] ) { steps[1].classList.add('tc-ff-progress__step--active'); }

            requestAnimationFrame(function () {
                step2.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    }

    /* ---------------------------------------------------------
       Page-load fade-in
       Adds .tc-loaded so the CSS opacity transition can run.
       --------------------------------------------------------- */
    function initPageLoad() {
        var page = document.querySelector('.tc-page');
        if ( ! page ) { return; }
        requestAnimationFrame(function () {
            page.classList.add('tc-loaded');
        });
    }

    /* ---------------------------------------------------------
       Bootstrap on DOMContentLoaded
       --------------------------------------------------------- */
    document.addEventListener('DOMContentLoaded', function () {

        initPageLoad();
        initExpandAll();
        initScrollReveal();
        initCardTilt();
        initStatAnimation();
        initApplyFormSteps();

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
