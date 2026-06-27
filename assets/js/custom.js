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

    document.addEventListener('DOMContentLoaded', function () {

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
