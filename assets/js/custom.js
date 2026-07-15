/* ===========================================================
   Techco Child — custom JS for Visioner Training pages
   Brochure gate, scroll reveals, pricing card tilt, cursor
   glow, and accordion expand-all toggle.
   =========================================================== */
(function () {
  "use strict";

  /* ---------------------------------------------------------
       Brochure gate: reveal download once Fluent Form submits
       --------------------------------------------------------- */
  function unlockBrochure() {
    var box = document.querySelector(".tc-brochure");
    if (!box) {
      return;
    }
    box.setAttribute("data-state", "unlocked");
    var link = box.querySelector(".tc-brochure__link");
    if (link) {
      link.hidden = false;
    }
  }

  /* ---------------------------------------------------------
       Course-content accordion: "Expand all" / "Collapse all"
       --------------------------------------------------------- */
  function initExpandAll() {
    var btn = document.querySelector("[data-tc-expand-all]");
    if (!btn) {
      return;
    }
    var acc = btn.closest(".tc-curriculum");
    if (!acc) {
      return;
    }

    btn.addEventListener("click", function () {
      var items = acc.querySelectorAll(".tc-acc__item");
      var anyClosed = Array.prototype.some.call(items, function (d) {
        return !d.open;
      });
      Array.prototype.forEach.call(items, function (d) {
        d.open = anyClosed;
      });
      btn.textContent = anyClosed
        ? "Collapse all sections"
        : "Expand all sections";
    });
  }

  /* ---------------------------------------------------------
       Scroll-triggered reveal (IntersectionObserver)
       Observes `.tc-reveal` elements, adds `.tc-revealed` on enter.
       --------------------------------------------------------- */
  function initScrollReveal() {
    var reveals = document.querySelectorAll(".tc-reveal");
    if (!reveals.length) {
      return;
    }

    // Fallback: if IntersectionObserver is unsupported, reveal all
    if (!("IntersectionObserver" in window)) {
      Array.prototype.forEach.call(reveals, function (el) {
        el.classList.add("tc-revealed");
      });
      return;
    }

    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add("tc-revealed");
            observer.unobserve(entry.target);
          }
        });
      },
      {
        // Fire while the element is still below the fold (positive bottom
        // margin expands the root downward) so full-bleed dark sections
        // finish fading in before they actually scroll into view — a late
        // reveal here briefly shows the page's light base background
        // through the still-transparent section.
        threshold: 0,
        rootMargin: "0px 0px 200px 0px",
      },
    );

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
    var cards = document.querySelectorAll("[data-tilt]");
    if (!cards.length) {
      return;
    }

    // Skip on touch devices — tilt doesn't work well there
    if ("ontouchstart" in window) {
      return;
    }

    Array.prototype.forEach.call(cards, function (card) {
      card.addEventListener("mousemove", function (e) {
        var rect = card.getBoundingClientRect();
        var x = e.clientX - rect.left;
        var y = e.clientY - rect.top;
        var midX = rect.width / 2;
        var midY = rect.height / 2;

        // Subtle tilt: ±6 degrees max
        var rotateY = ((x - midX) / midX) * 6;
        var rotateX = ((midY - y) / midY) * 6;

        card.style.transform =
          "perspective(800px) rotateX(" +
          rotateX.toFixed(2) +
          "deg) rotateY(" +
          rotateY.toFixed(2) +
          "deg) translateY(-4px)";

        // Feed cursor position to CSS for the radial glow
        var percentX = ((x / rect.width) * 100).toFixed(1) + "%";
        var percentY = ((y / rect.height) * 100).toFixed(1) + "%";
        card.style.setProperty("--mouse-x", percentX);
        card.style.setProperty("--mouse-y", percentY);
      });

      card.addEventListener("mouseleave", function () {
        card.style.transform = "";
        card.style.removeProperty("--mouse-x");
        card.style.removeProperty("--mouse-y");
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
    var stats = document.querySelectorAll(".tc-stat__num[data-animate]");
    if (!stats.length) {
      return;
    }

    var reduceMotion =
      window.matchMedia &&
      window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    Array.prototype.forEach.call(stats, function (el, i) {
      el.style.animationDelay = i * 150 + "ms";

      var raw = el.textContent.trim();
      var match = raw.match(/^([^\d]*)([\d,]*\.?\d+)([^\d]*)$/);
      if (!match || reduceMotion) {
        return;
      }

      var prefix = match[1];
      var numStr = match[2];
      var suffix = match[3];
      var target = parseFloat(numStr.replace(/,/g, ""));
      var decimals = (numStr.split(".")[1] || "").length;
      var hasCommas = numStr.indexOf(",") !== -1;

      function format(value) {
        var fixed = value.toFixed(decimals);
        if (hasCommas) {
          var parts = fixed.split(".");
          parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          fixed = parts.join(".");
        }
        return prefix + fixed + suffix;
      }

      el.textContent = format(0);

      var trigger = function () {
        var duration = 1200;
        var start = null;

        function step(timestamp) {
          if (start === null) {
            start = timestamp;
          }
          var progress = Math.min((timestamp - start) / duration, 1);
          var eased = 1 - Math.pow(1 - progress, 3); // ease-out cubic
          el.textContent = format(target * eased);
          if (progress < 1) {
            requestAnimationFrame(step);
          }
        }
        requestAnimationFrame(step);
      };

      if ("IntersectionObserver" in window) {
        var observer = new IntersectionObserver(
          function (entries) {
            entries.forEach(function (entry) {
              if (entry.isIntersecting) {
                setTimeout(trigger, i * 150);
                observer.unobserve(entry.target);
              }
            });
          },
          { threshold: 0.4 },
        );
        observer.observe(el);
      } else {
        trigger();
      }
    });
  }

  /* ---------------------------------------------------------
       Admissions form: multi-step wizard
       Each section of the form is a container tagged .tc-ff-step; we
       page through them one at a time (Back / Next) with a progress
       bar, keeping it a single-submission form (not Fluent Forms'
       native multi-page, which is a Pro feature). Scoped to the Apply
       page's form only — TPO form on page-colleges.php is untouched.
       --------------------------------------------------------- */
  function initApplyFormSteps() {
    var wrap = document.querySelector(".tc-apply-form");
    if (!wrap) {
      return;
    }

    var steps = Array.prototype.slice.call(
      wrap.querySelectorAll(".tc-ff-step"),
    );
    if (steps.length < 2) {
      return;
    }

    var form = steps[0].closest("form") || wrap.querySelector("form");
    if (!form) {
      return;
    }
    var submitWrap = form.querySelector(".ff_submit_btn_wrapper");

    // Scope all step-hiding CSS to this class so nothing is hidden
    // unconditionally — if this JS never runs, the form shows in full.
    form.classList.add("tc-ff-stepped");

    var current = 0;

    // Progress indicator: "Step X of N" + a fill bar.
    var progress = document.createElement("div");
    progress.className = "tc-ff-progress";
    var progressLabel = document.createElement("span");
    progressLabel.className = "tc-ff-progress__label";
    var barTrack = document.createElement("span");
    barTrack.className = "tc-ff-progress__bar";
    var fill = document.createElement("span");
    fill.className = "tc-ff-progress__fill";
    barTrack.appendChild(fill);
    progress.appendChild(progressLabel);
    progress.appendChild(barTrack);
    steps[0].parentNode.insertBefore(progress, steps[0]);

    // Back / Next controls, placed just before the real submit button.
    var nav = document.createElement("div");
    nav.className = "tc-ff-nav";
    var backBtn = document.createElement("button");
    backBtn.type = "button";
    backBtn.className = "tc-btn tc-btn--ghost tc-ff-nav__back";
    backBtn.textContent = "← Back";
    var nextBtn = document.createElement("button");
    nextBtn.type = "button";
    nextBtn.className = "tc-btn tc-btn--primary tc-ff-nav__next";
    nextBtn.textContent = "Next →";
    nav.appendChild(backBtn);
    nav.appendChild(nextBtn);
    if (submitWrap) {
      submitWrap.parentNode.insertBefore(nav, submitWrap);
    } else {
      form.appendChild(nav);
    }

    function render() {
      var last = current === steps.length - 1;
      steps.forEach(function (s, i) {
        s.classList.toggle("tc-ff-step--active", i === current);
      });
      backBtn.hidden = current === 0;
      nextBtn.hidden = last;
      if (submitWrap) {
        submitWrap.classList.toggle("tc-ff-submit--shown", last);
      }
      progressLabel.textContent =
        "Step " + (current + 1) + " of " + steps.length;
      fill.style.width = ((current + 1) / steps.length) * 100 + "%";
    }

    // Some steps hold only conditionally-shown fields (e.g. "Job Support"
    // only applies if an earlier answer was "Job" or "Career Switch").
    // Fluent Forms marks a hidden field's wrapper with .ff_excluded — if
    // every field in a step is excluded, the step has nothing to show, so
    // skip straight past it instead of landing on a blank page.
    function isStepBlank(step) {
      var fields = step.querySelectorAll(".ff-el-group, .ff-el-section-break");
      if (!fields.length) {
        return false;
      }
      for (var i = 0; i < fields.length; i++) {
        if (!fields[i].classList.contains("ff_excluded")) {
          return false;
        }
      }
      return true;
    }

    function goTo(index, direction) {
      direction = direction || (index >= current ? 1 : -1);
      var next = Math.max(0, Math.min(steps.length - 1, index));
      while (
        isStepBlank(steps[next]) &&
        next + direction >= 0 &&
        next + direction <= steps.length - 1
      ) {
        next += direction;
      }
      current = next;
      render();
      requestAnimationFrame(function () {
        progress.scrollIntoView({ behavior: "smooth", block: "start" });
      });
    }

    nextBtn.addEventListener("click", function () {
      // Only advance if the current step's required fields are valid.
      var invalid = steps[current].querySelector(":invalid");
      if (invalid) {
        invalid.reportValidity();
        return;
      }
      goTo(current + 1, 1);
    });
    backBtn.addEventListener("click", function () {
      goTo(current - 1, -1);
    });

    render();
  }

  /* ---------------------------------------------------------
       Magnetic CTAs — the button drifts a few px toward the
       cursor, then eases back on leave (CSS transition handles
       the return). Desktop + motion-safe only. Opt-in via
       [data-magnetic]; the inner label counter-shifts less so
       the text stays legible.
       --------------------------------------------------------- */
  function initMagneticButtons() {
    if ("ontouchstart" in window) {
      return;
    }
    if (
      window.matchMedia &&
      window.matchMedia("(prefers-reduced-motion: reduce)").matches
    ) {
      return;
    }

    var els = document.querySelectorAll("[data-magnetic]");
    if (!els.length) {
      return;
    }

    Array.prototype.forEach.call(els, function (el) {
      var strength = 0.28;
      el.addEventListener("mousemove", function (e) {
        var r = el.getBoundingClientRect();
        var mx = e.clientX - (r.left + r.width / 2);
        var my = e.clientY - (r.top + r.height / 2);
        el.style.transform =
          "translate(" +
          (mx * strength).toFixed(1) +
          "px," +
          (my * strength).toFixed(1) +
          "px)";
      });
      el.addEventListener("mouseleave", function () {
        el.style.transform = "";
      });
    });
  }

  /* ---------------------------------------------------------
       Share buttons ([data-share]) — native share sheet where
       available, else copy the URL to the clipboard with feedback.
       --------------------------------------------------------- */
  function initShareButtons() {
    var btns = document.querySelectorAll("[data-share]");
    if (!btns.length) {
      return;
    }

    Array.prototype.forEach.call(btns, function (btn) {
      btn.addEventListener("click", function () {
        var data = { title: document.title, url: window.location.href };
        if (navigator.share) {
          navigator.share(data).catch(function () {});
        } else if (navigator.clipboard) {
          navigator.clipboard
            .writeText(data.url)
            .then(function () {
              btn.classList.add("is-copied");
              setTimeout(function () {
                btn.classList.remove("is-copied");
              }, 1600);
            })
            .catch(function () {});
        }
      });
    });
  }

  /* ---------------------------------------------------------
       Copy buttons ([data-copy]) — copy bank/account details to the
       clipboard with brief visual feedback (Payments page).
       --------------------------------------------------------- */
  function initCopyButtons() {
    var btns = document.querySelectorAll("[data-copy]");
    if (!btns.length || !navigator.clipboard) {
      return;
    }

    Array.prototype.forEach.call(btns, function (btn) {
      btn.addEventListener("click", function () {
        navigator.clipboard
          .writeText(btn.dataset.copy)
          .then(function () {
            btn.classList.add("is-copied");
            setTimeout(function () {
              btn.classList.remove("is-copied");
            }, 1600);
          })
          .catch(function () {});
      });
    });
  }

  /* ---------------------------------------------------------
       Nav search suggestions — surface curriculum topics when the
       input is focused/clicked so users can jump to course content
       directly without typing a full query.
       --------------------------------------------------------- */
  function initNavSearchSuggestions() {
    var form = document.querySelector(".tc-nav__search");
    if (!form) {
      return;
    }

    var input = form.querySelector(".tc-nav__search-input");
    var list = form.querySelector(".tc-nav__search-suggestions");
    if (!input || !list) {
      return;
    }

    // keyboard / active state helpers
    var navSearchItems = [];
    var navSearchActive = -1;

    function escapeHtml(value) {
      return String(value)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#39;");
    }

    function showSuggestions(query) {
      var data = window.TC_SEARCH || {};
      var items = Array.isArray(data.items) ? data.items : [];
      var q = (query || "").trim().toLowerCase();

      if (q) {
        items = items.filter(function (item) {
          var hay = (item.topic || "") + " " + (item.text || "");
          return hay.toLowerCase().indexOf(q) !== -1;
        });
      }

      if (!items.length) {
        list.innerHTML =
          '<div class="tc-nav__search-suggestion tc-nav__search-suggestion--empty" role="none">No matching module found — try a different keyword or press Enter to search the full site.</div>';
        list.classList.add("is-open");
        list.hidden = false;
        input.setAttribute("aria-expanded", "true");
        navSearchItems = [];
        navSearchActive = -1;
        input.removeAttribute("aria-activedescendant");
        return;
      }

      var visible = items.slice(0, 6);
      list.innerHTML = visible
        .map(function (item, index) {
          var href = (data.url || "") + "#" + item.id;
          // Extract short name from topic (first word or key term)
          var topicText = item.topic || "";
          var shortName = topicText.split(/[—–\s]/)[0].trim(); // Get first segment
          if (!shortName || shortName.length < 3) { shortName = topicText.split(/\s+/)[0]; }
          var subtitle = [];
          if (item.phase) {
            subtitle.push(item.phase);
          }
          if (item.weeks) {
            subtitle.push(item.weeks);
          }
          if (item.milestone) {
            subtitle.push(item.milestone);
          }
          var phaseClass = ((item.phase || "") + "")
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, "-");
          return (
            '<button class="tc-nav__search-suggestion" type="button" data-href="' +
            escapeHtml(href) +
            '" role="option" id="tc-nav-search-suggestion-' +
            index +
            '">' +
            '<span class="tc-nav__search-suggestion-title">' +
            escapeHtml(shortName) +
            "</span>" +
            '<span class="tc-nav__search-suggestion-subtitle">' +
            escapeHtml(subtitle.join(" · ")) +
            "</span>" +
            '<span class="tc-nav__search-suggestion-meta">Open module</span>' +
            "</button>"
          );
        })
        .join("");

      navSearchItems = Array.prototype.slice.call(
        list.querySelectorAll(".tc-nav__search-suggestion"),
      );
      navSearchActive = -1;
      list.classList.add("is-open");
      list.hidden = false;
      input.setAttribute("aria-expanded", "true");
      input.removeAttribute("aria-activedescendant");
    }

    function hideSuggestions() {
      list.classList.remove("is-open");
      list.hidden = true;
      input.setAttribute("aria-expanded", "false");
    }

    input.addEventListener("focus", function () {
      showSuggestions(input.value);
    });
    input.addEventListener("click", function () {
      showSuggestions(input.value);
    });
    input.addEventListener("input", function () {
      showSuggestions(input.value);
    });
    input.addEventListener("keydown", function (e) {
      if (e.key === "Escape") {
        hideSuggestions();
        return;
      }
      if (e.key === "ArrowDown" || e.key === "ArrowUp") {
        if (!navSearchItems.length) {
          return;
        }
        e.preventDefault();
        var next = navSearchActive;
        if (e.key === "ArrowDown") {
          next = Math.min(navSearchItems.length - 1, navSearchActive + 1);
        } else {
          next = Math.max(0, navSearchActive - 1);
        }
        setActiveSuggestion(next);
        return;
      }
      if (e.key === "Enter") {
        // if an item is active, open it; otherwise allow form submit (site search)
        if (navSearchActive >= 0 && navSearchItems[navSearchActive]) {
          e.preventDefault();
          navSearchItems[navSearchActive].click();
        }
      }
    });

    list.addEventListener("click", function (e) {
      var btn = e.target.closest(".tc-nav__search-suggestion");
      if (!btn) {
        return;
      }
      e.preventDefault();
      var label = btn.querySelector(".tc-nav__search-suggestion-title");
      if (label) {
        input.value = label.textContent;
      }
      var href = btn.getAttribute("data-href");
      if (href) {
        window.location.href = href;
      }
    });

    document.addEventListener("click", function (e) {
      if (!form.contains(e.target)) {
        hideSuggestions();
      }
    });
  }

  /* ---------------------------------------------------------
       Nav search → jump to curriculum. Matches the query against the
       course-content index (window.TC_SEARCH) and, on a hit, redirects to
       the matching module in the Program page's accordion. Falls back to
       the native WordPress search (?s=) when nothing relevant matches.
       --------------------------------------------------------- */
  function initNavSearch() {
    var form = document.querySelector(".tc-nav__search");
    if (!form) {
      return;
    }

    form.addEventListener("submit", function (e) {
      var data = window.TC_SEARCH;
      if (!data || !data.items || !data.items.length) {
        return;
      } // let WP search run

      var input = form.querySelector(".tc-nav__search-input");
      var q = ((input && input.value) || "").trim().toLowerCase();
      if (!q) {
        return;
      }

      // Tokenise, keeping tech punctuation (.net, c#, c++).
      var tokens = q.split(/[^a-z0-9.+#]+/).filter(Boolean);
      var best = null,
        bestScore = 0;

      data.items.forEach(function (item) {
        var hay = item.text;
        var score = 0;
        if (hay.indexOf(q) !== -1) {
          score += 5;
        } // whole phrase
        if (item.topic.toLowerCase().indexOf(q) !== -1) {
          score += 3;
        } // topic phrase
        tokens.forEach(function (t) {
          if (hay.indexOf(t) !== -1) {
            score += 1;
          }
        });
        if (score > bestScore) {
          bestScore = score;
          best = item;
        }
      });

      if (best && bestScore > 0) {
        e.preventDefault();
        window.location.href = data.url + "#" + best.id;
      }
      // else: allow the native form submit (WordPress site search)
    });
  }

  /* ---------------------------------------------------------
       Curriculum deep-link. When the URL carries a #tc-module-N hash
       (from nav search or a shared link), open that accordion item,
       scroll it under the sticky nav, and pulse it briefly.
       --------------------------------------------------------- */
  function initCurriculumJump() {
    function reveal() {
      var hash = window.location.hash;
      if (hash.indexOf("#tc-module-") !== 0) {
        return;
      }
      var el = document.getElementById(hash.slice(1));
      if (!el) {
        return;
      }

      if (el.tagName === "DETAILS") {
        el.open = true;
      }

      var nav = document.getElementById("tc-nav");
      var offset = (nav ? nav.offsetHeight : 0) + 18;
      var y = el.getBoundingClientRect().top + window.pageYOffset - offset;
      var reduce =
        window.matchMedia &&
        window.matchMedia("(prefers-reduced-motion: reduce)").matches;
      window.scrollTo({ top: y, behavior: reduce ? "auto" : "smooth" });

      el.classList.remove("tc-acc__item--found");
      void el.offsetWidth; // restart the animation if re-triggered
      el.classList.add("tc-acc__item--found");
      window.setTimeout(function () {
        el.classList.remove("tc-acc__item--found");
      }, 2600);
    }

    if (window.location.hash.indexOf("#tc-module-") === 0) {
      window.setTimeout(reveal, 140); // let layout settle
    }
    window.addEventListener("hashchange", reveal);
  }

  /* ---------------------------------------------------------
       Nav scrollspy. Highlights the nav link for whichever page
       section is currently under the sticky nav, so `.is-active`
       tracks scroll position instead of only the initial template.
       --------------------------------------------------------- */
  function initNavScrollSpy() {
    var nav = document.getElementById("tc-nav");
    if (!nav || !("IntersectionObserver" in window)) {
      return;
    }
    var links = nav.querySelectorAll(".tc-nav__link");
    if (!links.length) {
      return;
    }

    var linkByHash = {};
    var homeLink = null;
    var sections = [];
    Array.prototype.forEach.call(links, function (link) {
      var href = link.getAttribute("href") || "";
      var hashIndex = href.indexOf("#");
      if (hashIndex === -1) {
        homeLink = link;
        return;
      }
      var id = href.slice(hashIndex + 1);
      var section = document.getElementById(id);
      if (!section) {
        return;
      }
      linkByHash[id] = link;
      sections.push(section);
    });
    if (!sections.length) {
      return;
    }

    function setActive(link) {
      Array.prototype.forEach.call(links, function (l) {
        l.classList.remove("is-active");
        l.removeAttribute("aria-current");
      });
      if (link) {
        link.classList.add("is-active");
        link.setAttribute("aria-current", "page");
      }
      // Let the sliding underline follow the active link (decoupled).
      if (typeof window.CustomEvent === "function") {
        nav.dispatchEvent(
          new CustomEvent("tc:navactive", { detail: { link: link } }),
        );
      }
    }

    var navHeight = nav.offsetHeight || 0;
    // Anchor jumps land a section's top at the CSS `scroll-padding-top` line
    // (see html { scroll-padding-top } in custom.css), which sits below the
    // nav. Match the scrollspy's reference line to that same offset so the
    // section you jumped to — not the one just above it — is the one selected.
    var scrollPad =
      parseFloat(getComputedStyle(document.documentElement).scrollPaddingTop) ||
      0;
    var refOffset = Math.max(navHeight, scrollPad) + 4;
    var current = null;

    // Active section = the last one (in document order) whose top has scrolled
    // to or past the reference line under the nav. Reading positions directly
    // (rather than an IntersectionObserver band) avoids two failure modes:
    // the boundary overlap where two sections both clip a band and the outgoing
    // one wins, and — critically — the dead zone where a smooth-scroll rests a
    // section between the band edges so the observer never re-fires at the true
    // resting position. A rAF-throttled scroll listener re-evaluates on every
    // settle and continuously during manual scrolling.
    function computeActive() {
      var found = null;
      for (var i = 0; i < sections.length; i++) {
        if (sections[i].getBoundingClientRect().top - refOffset <= 0) {
          found = sections[i].id;
        }
      }

      if (!found && window.scrollY > navHeight) {
        found = current; // scrolled past the last section — keep it lit
      }

      if (found !== current) {
        current = found;
        setActive(found ? linkByHash[found] : homeLink);
      }
    }

    var ticking = false;
    function onScroll() {
      if (ticking) {
        return;
      }
      ticking = true;
      window.requestAnimationFrame(function () {
        ticking = false;
        computeActive();
      });
    }

    window.addEventListener("scroll", onScroll, { passive: true });
    window.addEventListener("resize", function () {
      navHeight = nav.offsetHeight || 0;
      scrollPad =
        parseFloat(
          getComputedStyle(document.documentElement).scrollPaddingTop,
        ) || 0;
      refOffset = Math.max(navHeight, scrollPad) + 4;
      computeActive();
    });

    computeActive(); // light the correct link on load
  }

  /* ---------------------------------------------------------
       Motion One enhancements (progressive — only if window.Motion
       is present). Two signature effects the CSS reveal can't do:
         • [data-parallax]  scroll-linked translate on decorative layers
         • [data-motion-in] spring-stagger entrance for a container's
           direct children (inline styles are cleared on finish so CSS
           :hover transforms keep working).
       Everything degrades to visible + the CSS `.tc-reveal` system when
       Motion is missing or reduced-motion is requested.
       --------------------------------------------------------- */
  function initMotion() {
    var M = window.Motion;
    if (!M || typeof M.animate !== "function") {
      return;
    }
    var reduce =
      window.matchMedia &&
      window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    // Scroll-linked parallax on decorative layers. Explicit [data-parallax]
    // opt-ins, plus every ambient .tc-glow-orb site-wide gains gentle depth.
    if (!reduce && typeof M.scroll === "function") {
      var parallax = function (el, range) {
        try {
          M.scroll(
            M.animate(
              el,
              {
                transform: [
                  "translateY(-" + range + "%)",
                  "translateY(" + range + "%)",
                ],
              },
              { ease: "linear" },
            ),
            { target: el, offset: ["start end", "end start"] },
          );
        } catch (e) {
          /* never break the page over an effect */
        }
      };

      Array.prototype.forEach.call(
        document.querySelectorAll("[data-parallax]"),
        function (el) {
          parallax(el, parseFloat(el.getAttribute("data-parallax")) || 6);
        },
      );
      // Ambient orbs on hero sections across templates — subtle, generous range.
      Array.prototype.forEach.call(
        document.querySelectorAll(".tc-glow-orb:not([data-parallax])"),
        function (el) {
          parallax(el, 16);
        },
      );
    }

    // Spring-stagger entrance for opted-in containers.
    if (!reduce && typeof M.inView === "function") {
      var groups = document.querySelectorAll("[data-motion-in]");
      Array.prototype.forEach.call(groups, function (group) {
        var items = Array.prototype.slice.call(group.children);
        if (!items.length) {
          return;
        }

        var clear = function () {
          Array.prototype.forEach.call(items, function (el) {
            el.style.opacity = "";
            el.style.transform = "";
          });
        };

        try {
          Array.prototype.forEach.call(items, function (el) {
            el.style.opacity = "0";
          });
          M.inView(
            group,
            function () {
              var controls = M.animate(
                items,
                { opacity: [0, 1], y: [22, 0], scale: [0.96, 1] },
                {
                  duration: 0.5,
                  delay: M.stagger ? M.stagger(0.06) : 0,
                  ease: [0.22, 1, 0.36, 1],
                },
              );
              if (controls && controls.finished && controls.finished.then) {
                controls.finished.then(clear).catch(clear);
              }
            },
            { amount: 0.15 },
          );
        } catch (e) {
          clear(); // fall back to visible
        }
      });
    }
  }

  /* ---------------------------------------------------------
       Page-load fade-in
       Adds .tc-loaded so the CSS opacity transition can run.
       --------------------------------------------------------- */
  function initPageLoad() {
    var page = document.querySelector(".tc-page");
    if (!page) {
      return;
    }
    requestAnimationFrame(function () {
      page.classList.add("tc-loaded");
    });
  }

  /* ---------------------------------------------------------
       Read-in-place modals (Terms and Conditions etc.)
       Generic/id-driven: any [data-tc-modal-open="X"] trigger opens
       #tc-modal-X. Close via [data-tc-modal-close], overlay click,
       or Escape. See tc_render_terms_modal() in inc/legal-content.php.
       --------------------------------------------------------- */
  function initTcModals() {
    var openModal = null;
    var lastTrigger = null;

    function open(modal, trigger) {
      openModal = modal;
      lastTrigger = trigger || null;
      modal.classList.add("tc-modal--open");
      modal.setAttribute("aria-hidden", "false");
      document.body.classList.add("tc-modal-lock");
      var closeBtn = modal.querySelector(".tc-modal__close");
      if (closeBtn) {
        closeBtn.focus();
      }
    }

    function close() {
      if (!openModal) {
        return;
      }
      openModal.classList.remove("tc-modal--open");
      openModal.setAttribute("aria-hidden", "true");
      document.body.classList.remove("tc-modal-lock");
      if (lastTrigger && typeof lastTrigger.focus === "function") {
        lastTrigger.focus();
      }
      openModal = null;
      lastTrigger = null;
    }

    document.addEventListener("click", function (e) {
      var trigger = e.target.closest("[data-tc-modal-open]");
      if (trigger) {
        var modal = document.getElementById(
          "tc-modal-" + trigger.getAttribute("data-tc-modal-open"),
        );
        if (modal) {
          e.preventDefault();
          open(modal, trigger);
        }
        return;
      }

      if (e.target.closest("[data-tc-modal-close]")) {
        e.preventDefault();
        close();
      }
    });

    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && openModal) {
        close();
      }
    });
  }

  /* ---------------------------------------------------------
       Enquiry form: keep the submit button disabled until every
       required field holds valid data (Fluent Form fluent_form_3).
       Layered on top of Fluent Forms' own validation, not a replacement.
       --------------------------------------------------------- */
  function initEnquiryFormGate() {
    var form = document.querySelector(".fluent_form_3");
    if (!form) {
      return;
    }
    var btn =
      form.querySelector(".ff-btn-submit") ||
      form.querySelector('button[type="submit"]');
    if (!btn) {
      return;
    }

    // Required controls: prefer Fluent Forms' own required-group marker,
    // fall back to the known enquiry field names.
    var controls = form.querySelectorAll(
      ".ff-el-is-required input, .ff-el-is-required select, .ff-el-is-required textarea"
    );
    if (!controls.length) {
      controls = form.querySelectorAll(
        '[name="full_name"],[name="phone"],[name="email"],[name="status"],[name="qualification"],[name="batch_month"]'
      );
    }

    var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    function controlValid(el) {
      var val = (el.value || "").trim();
      if (val === "") {
        return false;
      }
      var name = el.getAttribute("name") || "";
      if (el.type === "email" || name === "email") {
        return emailRe.test(val);
      }
      if (name === "phone") {
        return (val.match(/\d/g) || []).length >= 8;
      }
      return true;
    }

    function evaluate() {
      var allValid = Array.prototype.every.call(controls, controlValid);
      btn.disabled = !allValid;
    }

    form.addEventListener("input", evaluate);
    form.addEventListener("change", evaluate);
    evaluate(); // start disabled until the form is valid
  }

  /* ---------------------------------------------------------
       Sliding underline indicator. A single bar glides beneath the
       active nav link (and previews on hover). Desktop only; driven
       by the scrollspy's "tc:navactive" event so there's no second
       observer. The CSS transition does the gliding; under
       prefers-reduced-motion the global CSS neutralises it to a snap.
       --------------------------------------------------------- */
  function initNavUnderline() {
    var nav = document.getElementById("tc-nav");
    if (!nav) {
      return;
    }
    var list = nav.querySelector(".tc-nav__list");
    if (!list) {
      return;
    }
    var desktop = window.matchMedia("(min-width: 992px)");

    var bar = document.createElement("span");
    bar.className = "tc-nav__underline";
    bar.setAttribute("aria-hidden", "true");
    list.appendChild(bar);

    function activeLink() {
      return list.querySelector(".tc-nav__link.is-active");
    }

    function moveTo(link) {
      if (!desktop.matches || !link) {
        bar.style.opacity = "0";
        return;
      }
      bar.style.transform = "translateX(" + link.offsetLeft + "px)";
      bar.style.width = link.offsetWidth + "px";
      bar.style.opacity = "1";
    }

    function settle() {
      moveTo(activeLink());
    }

    nav.addEventListener("tc:navactive", function (e) {
      moveTo((e.detail && e.detail.link) || activeLink());
    });

    // Hover preview: glide to the hovered link, snap back to active on leave.
    Array.prototype.forEach.call(
      list.querySelectorAll(".tc-nav__link"),
      function (link) {
        link.addEventListener("mouseenter", function () {
          if (desktop.matches) {
            moveTo(link);
          }
        });
        link.addEventListener("mouseleave", settle);
      },
    );

    var resizeTimer;
    window.addEventListener("resize", function () {
      window.clearTimeout(resizeTimer);
      resizeTimer = window.setTimeout(settle, 120);
    });

    // Initial placement once layout/fonts settle.
    window.setTimeout(settle, 60);
  }

  /* ---------------------------------------------------------
       Premium eased scroll for in-page section links, with a brief
       "arrival" highlight on the destination section. Replaces the
       browser's native smooth scroll for nav clicks only; cross-page
       links and non-section anchors (e.g. #tc-module-N) are left alone.
       --------------------------------------------------------- */
  function initSmoothNav() {
    var nav = document.getElementById("tc-nav");
    var reduce =
      window.matchMedia &&
      window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    var raf = null;

    function cancel() {
      if (raf) {
        window.cancelAnimationFrame(raf);
        raf = null;
      }
      // Restore the global CSS smooth-scroll we borrow during a tween.
      document.documentElement.style.scrollBehavior = "";
    }

    // Abort the tween the instant the user takes over scrolling.
    ["wheel", "touchstart", "keydown"].forEach(function (evt) {
      window.addEventListener(
        evt,
        function () {
          if (raf) {
            cancel();
          }
        },
        { passive: true },
      );
    });

    function highlight(section) {
      if (!section) {
        return;
      }
      section.classList.remove("tc-section--arrived");
      void section.offsetWidth; // restart the animation if re-triggered
      section.classList.add("tc-section--arrived");
      window.setTimeout(function () {
        section.classList.remove("tc-section--arrived");
      }, 1000);
    }

    function targetY(section) {
      var offset = (nav ? nav.offsetHeight : 0) + 8;
      return Math.max(
        0,
        section.getBoundingClientRect().top + window.pageYOffset - offset,
      );
    }

    function scrollToSection(section, hash) {
      var end = targetY(section);

      function finish() {
        if (hash && window.history && history.pushState) {
          history.pushState(null, "", hash);
        }
        highlight(section);
      }

      if (reduce) {
        window.scrollTo(0, end);
        finish();
        return;
      }

      var start = window.pageYOffset;
      var dist = end - start;
      if (Math.abs(dist) < 2) {
        finish();
        return;
      }
      var duration = Math.min(1100, Math.max(500, Math.abs(dist) * 0.6));
      var startTime = null;

      // Borrow control from the global `scroll-behavior: smooth` so it
      // doesn't fight our per-frame scrollTo. Restored in cancel().
      document.documentElement.style.scrollBehavior = "auto";

      function step(now) {
        if (startTime === null) {
          startTime = now;
        }
        var t = Math.min(1, (now - startTime) / duration);
        // easeInOutCubic
        var eased = t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
        window.scrollTo(0, start + dist * eased);
        if (t < 1) {
          raf = window.requestAnimationFrame(step);
        } else {
          cancel();
          finish();
        }
      }
      raf = window.requestAnimationFrame(step);
    }

    document.addEventListener("click", function (e) {
      var link = e.target.closest ? e.target.closest('a[href*="#tc-"]') : null;
      if (!link) {
        return;
      }
      // Resolve to an absolute URL so bare "#tc-why" and full home URLs
      // are handled uniformly.
      var resolved = document.createElement("a");
      resolved.href = link.href;
      if (resolved.pathname !== window.location.pathname) {
        return; // targets another page — let the browser navigate.
      }
      var hash = resolved.hash;
      if (!hash || hash.indexOf("#tc-") !== 0) {
        return;
      }
      var section = document.getElementById(hash.slice(1));
      // Only take over for real page sections, not accordion/module anchors.
      if (!section || section.tagName !== "SECTION") {
        return;
      }
      e.preventDefault();
      cancel();
      scrollToSection(section, hash);
    });
  }

  /* ---------------------------------------------------------
       Bootstrap on DOMContentLoaded
       --------------------------------------------------------- */
  document.addEventListener("DOMContentLoaded", function () {
    initPageLoad();
    initExpandAll();
    initScrollReveal();
    initCardTilt();
    initStatAnimation();
    initApplyFormSteps();
    initMagneticButtons();
    initShareButtons();
    initCopyButtons();
    initNavSearchSuggestions();
    initNavSearch();
    initCurriculumJump();
    initNavScrollSpy();
    initSmoothNav();
    initNavUnderline();
    initMotion();
    initTcModals();
    initEnquiryFormGate();

    // Fluent Forms fires this jQuery event on successful AJAX submit.
    if (window.jQuery) {
      jQuery(document).on("fluentform_submission_success", function () {
        unlockBrochure();
      });
    }

    // Fallback: native event some Fluent Forms versions dispatch.
    document.addEventListener("fluentform_submission_success", unlockBrochure);
  });
})();
