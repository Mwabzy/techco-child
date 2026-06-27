/* ===========================================================
   Techco Child — custom JS for Visioner Training pages
   Brochure gate: reveal the download once the Fluent Form submits OK.
   =========================================================== */
( function () {
    'use strict';

    function unlockBrochure() {
        var box = document.querySelector('.tc-brochure');
        if ( ! box ) { return; }
        box.setAttribute('data-state', 'unlocked');
        var link = box.querySelector('.tc-brochure__link');
        if ( link ) { link.hidden = false; }
    }

    // Course-content accordion: "Expand all" / "Collapse all" toggle.
    function initExpandAll() {
        var btn = document.querySelector('[data-tc-expand-all]');
        if ( ! btn ) { return; }
        var acc = btn.closest('.tc-curriculum');
        if ( ! acc ) { return; }

        btn.addEventListener('click', function () {
            var items = acc.querySelectorAll('.tc-acc__item');
            // If any item is closed, expand all; otherwise collapse all.
            var anyClosed = Array.prototype.some.call(items, function (d) { return ! d.open; });
            Array.prototype.forEach.call(items, function (d) { d.open = anyClosed; });
            btn.textContent = anyClosed ? 'Collapse all sections' : 'Expand all sections';
        });
    }

    document.addEventListener('DOMContentLoaded', function () {

        initExpandAll();

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
