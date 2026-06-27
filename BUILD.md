# BUILD.md — Visioner Training pages (Techco Child)

This child theme is the build surface for the Visioner Fullstack Training site.
Work **only** inside `techco-child/`. Never edit the parent `techco/` theme.

## Source of truth
The page content comes from the Visioner deck (Program/Curriculum, Fees & Batches,
Admissions, For Colleges/TPO, registration fields). Fill every `CLAUDE CODE:` marker
with real content from those slides. Keep Indian context: ₹, 18% GST, Razorpay, EMI.

## File map
| File | Purpose |
|---|---|
| `page-program.php` | Template "Visioner — Program / Curriculum". 14-week ladder. |
| `page-fees.php` | Template "Visioner — Fees & Batches". Pricing (incl. GST), batch table, Razorpay button, EMI. |
| `page-apply.php` | Template "Visioner — Admissions / Apply". Fluent Form + gated brochure. |
| `page-colleges.php` | Template "Visioner — For Colleges (TPO)". Value cards + TPO enquiry form. |
| `inc/page-banner.php` | `techco_child_page_banner($title,$subtitle)` — native Techco title bar. |
| `inc/whatsapp-widget.php` | Floating WhatsApp button. Set the real number in `techco_child_wa_number`. |
| `assets/css/custom.css` | Section/card/widget styles. Tune to deck palette (navy + blue/orange). |
| `assets/js/custom.js` | Unlocks brochure on Fluent Forms submit success. |
| `functions.php` | Enqueues custom CSS/JS, includes the WhatsApp widget. Existing FF validation kept. |

## Conventions (match the parent theme)
- Every template: `get_header()` → `techco_child_page_banner(...)` → `#primary.content-area.page-content-area.pt-120.pb-120` → `.container` → `get_footer()`.
- Use Bootstrap grid (`row`, `col-lg-*`) — Techco bundles Bootstrap.
- Header, menu, logo, footer come from Techco Core automatically. Don't rebuild them.
- New CSS classes are namespaced `tc-`. Keep it that way.

## The form (Fluent Forms — already chosen)
Build TWO forms in **wp-admin → Fluent Forms**:
1. **Registration** (Apply page): Full name · Email · Phone/WhatsApp · College/Company ·
   Program & preferred batch · Timing track · Payment plan · How did you hear about us? ·
   Accept No-Refund policy (required checkbox).
   - Add class `ff-validate-email` to the email field and `ff-number-only` to the phone field
     (the existing JS in functions.php validates them).
   - Integrations: **Google Sheets** (FF → Integrations), **confirmation email**
     (Settings → Email Notifications), **WhatsApp** (webhook → Cloud API / provider on submit).
2. **TPO enquiry** (Colleges page): College name · TPO contact · Email · Phone · No. of students · Message.
Then put each real form ID into the `[fluentform id="X"]` shortcodes in `page-apply.php` / `page-colleges.php`.

## Razorpay
`page-fees.php` has a `.tc-razorpay-slot`. Paste the Razorpay **Payment Button** snippet
(Dashboard → Payment Button → Generate). It's hosted — no server code. Keep the LIVE key on live only.

## Brochure
Upload the PDF to Media, drop its URL into the `.tc-brochure__link` href in `page-apply.php`.
It stays hidden until the form submits successfully (handled by custom.js).

## Deploy to live (after local testing)
Remember the split — files deploy by upload, DB-stored config does not:
1. **Files** → cPanel File Manager → `public_html/wp-content/themes/techco-child/` → upload changed files (or zip + extract).
2. **Forms** → Fluent Forms → export form JSON locally → import on live (don't expect it via file upload).
3. **Razorpay** → swap test key for live key on the live button.
4. **Pages** → live wp-admin → Pages → Add New → Page Attributes → Template → pick each
   "Visioner — …" template → Publish. Match slugs used in internal links
   (e.g. `/admissions-apply/`).
5. **Permalinks** → Settings → Permalinks → Save (flush) so new pages don't 404.

## Local test checklist
- [ ] Techco Child active, Techco Core active.
- [ ] Each page created in wp-admin with the matching template selected.
- [ ] Header/footer/menu render around the page (inherited from Techco Core).
- [ ] WhatsApp float appears bottom-right with the correct number.
- [ ] Form submits; brochure unlocks; confirmation email arrives; row lands in the Sheet.
