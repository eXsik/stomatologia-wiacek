# Current Theme Audit

**Project:** Stomatologia Wiącek — classic WordPress theme  
**Basis:** Code inspection of the theme as of the pre–Phase 1 redesign state  
**Design source of truth:** `docs/homepage-design-spec.md`  
**Status:** Audit complete; Phase 1 boundaries and content decisions approved

This document records architecture, content model, CSS/JS facts, gaps versus the approved design, concrete risks, and the locked Phase 1 scope. It does not contain implementation code.

---

## 1. Audit scope

### Inspected

- `docs/homepage-design-spec.md`
- `README.md`
- `functions.php`
- `front-page.php`
- `header.php`
- `footer.php`
- All modules under `inc/`
- All templates under `template-parts/sections/`
- Related layout/components under `template-parts/layout/` and `template-parts/components/` used by the homepage
- Styles under `assets/styles/` (source partials and `main.min.css`)
- Scripts under `assets/scripts/` (modules and `main.min.js`)
- `package.json` (build scripts only)

### Out of scope for this audit

- Live WordPress admin content and database values
- Runtime verification of enqueue timing under a running Local site
- Non-homepage templates beyond their coupling to shared tokens/assets
- Installation of dependencies or addition of font files

### Method

Conclusions about file structure, field names, helpers, and enqueue logic are based on inspected source. Items that require a running WordPress request are labelled **Requires runtime verification**.

---

## 2. Architecture summary

### Bootstrap

`functions.php` is a thin loader. It defines:

- `SW_THEME_VERSION`
- `SW_THEME_DIR`
- `SW_THEME_URI`

It then `require_once`s each path in `$sw_modules` when the file exists.

### Modules loaded from `functions.php`

| Path                                   | Responsibility                                                                                                                                  |
| -------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------- |
| `inc/setup.php`                        | `sw_setup()` — theme supports, image sizes, nav menus                                                                                           |
| `inc/enqueue.php`                      | `sw_enqueue_assets()`, `sw_module_script_tag()`, `sw_preload_fonts()`                                                                           |
| `inc/helpers.php`                      | `sw_get_option()`, `sw_get_trust_stats()`, `sw_get_why_us_points()`, `sw_get_gallery_pairs()`, `sw_phone_href()`, `sw_image()`, `sw_has_rows()` |
| `inc/clinic-settings.php`              | Settings API “Dane gabinetu”; option key `sw_clinic`                                                                                            |
| `inc/cpt-services.php`                 | `sw_register_cpt_service()` → post type `service`                                                                                               |
| `inc/cpt-team.php`                     | `sw_register_cpt_team_member()` → post type `team_member`                                                                                       |
| `inc/cpt-testimonials.php`             | `sw_register_cpt_testimonial()` → post type `testimonial`                                                                                       |
| `inc/cpt-faq.php`                      | `sw_register_cpt_faq()` → post type `faq`                                                                                                       |
| `inc/acf-fields.php`                   | ACF Free local field groups                                                                                                                     |
| `inc/nav-walker.php`                   | `SW_Nav_Walker`                                                                                                                                 |
| `inc/seo-meta.php`                     | Title / meta / Open Graph                                                                                                                       |
| `inc/seo-schema.php`                   | JSON-LD (`sw_output_dentist_schema()`, `sw_output_faq_schema()`, breadcrumbs)                                                                   |
| `inc/contact-form.php`                 | `admin-post.php` contact form handler                                                                                                           |
| `template-parts/components/button.php` | Defines `sw_button()`                                                                                                                           |

### Homepage composition

`front-page.php`:

1. `get_header()`
2. Opens `<main id="main">`
3. Includes section templates via `get_template_part()` in fixed order
4. `get_footer()`

Current include order:

1. `template-parts/sections/hero`
2. `template-parts/sections/trust-bar`
3. `template-parts/sections/services-grid`
4. `template-parts/sections/why-us` (internally includes `template-parts/sections/doctor`)
5. `template-parts/sections/gallery-teaser`
6. `template-parts/sections/testimonials`
7. `template-parts/sections/faq`
8. `template-parts/sections/blog-teaser`
9. `template-parts/sections/contact`

Section order is fixed in PHP. There is no Flexible Content / page-builder layer.

### Asset enqueue

`sw_enqueue_assets()` in `inc/enqueue.php`:

- Always enqueues `assets/styles/base/_typography.css` as handle `sw-fonts`
- Enqueues `assets/styles/main.css` when `WP_DEBUG` is true, otherwise `assets/styles/main.min.css` (handle `sw-main`)
- Enqueues `assets/scripts/main.js` when `WP_DEBUG` is true, otherwise `assets/scripts/main.min.js` (handle `sw-main`, footer, `defer`)
- Conditionally enqueues `assets/scripts/modules/gallery-slider.js` when `$GLOBALS['sw_needs_gallery_script']` is set

`sw_module_script_tag()` adds `type="module"` to `sw-main` in development and to `sw-gallery-slider` always.

`sw_preload_fonts()` preloads `assets/fonts/inter-variable.woff2`.

`package.json` defines `build:css` (PostCSS import + cssnano) and `build:js` (esbuild). **Fact:** no `node_modules` directory and no font files under `assets/fonts/` were present at audit time.

### Suitability for incremental redesign

The architecture supports phased work: homepage order lives in `front-page.php`, sections are isolated under `template-parts/sections/`, clinic data goes through `sw_get_option()`, and ACF Free field groups are registered in code. Shared design tokens in `assets/styles/base/_variables.css` couple Phase 1 visual changes to all templates that consume those variables.

---

## 3. Homepage section map

| Order | Section                  | Template                                                                                     | Primary CSS                                                                     | Content source                                                                                                                                                                   | Type                                      |
| ----- | ------------------------ | -------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------- |
| —     | Header                   | `header.php`, `template-parts/layout/nav-mobile.php`                                         | `assets/styles/layout/_header.css` (`.sw-header`, `.sw-nav`, `.sw-mobile-menu`) | Menu location `primary`; phone via `sw_get_option( 'clinic_phone' )`; booking CTA currently hardcoded `#kontakt`                                                                 | WP menu + clinic settings + hardcoded CTA |
| 1     | Hero                     | `template-parts/sections/hero.php`                                                           | Currently in `assets/styles/layout/_header.css` (`.sw-hero*`)                   | ACF: `hero_headline`, `hero_subheadline`, `hero_media`, `hero_cta_primary_label`, `hero_cta_primary_link`, `hero_cta_secondary_label`, `hero_cta_secondary_link` + PHP fallbacks | ACF-driven + fallbacks                    |
| 2     | Trust strip              | `template-parts/sections/trust-bar.php`                                                      | Currently in `assets/styles/layout/_grid.css` (`.sw-trust-bar*`)                | `sw_get_trust_stats()` → `trust_N_value`, `trust_N_label`, `trust_N_icon` + demo fallback array                                                                                  | ACF-driven + fallbacks                    |
| 3     | Services                 | `template-parts/sections/services-grid.php`, `template-parts/components/card-service.php`    | `_grid.css` (`.sw-services*`), `components/_cards.css`                          | `WP_Query` on `service`, `menu_order` ASC, limit 8                                                                                                                               | CPT-driven                                |
| 4     | Why us                   | `template-parts/sections/why-us.php`                                                         | `_grid.css` (`.sw-why-us*`)                                                     | `sw_get_why_us_points()` → `why_us_N_title`, `why_us_N_description` + fallbacks                                                                                                  | ACF-driven + fallbacks                    |
| 4b    | Featured doctor (nested) | `template-parts/sections/doctor.php`                                                         | Inline in `assets/styles/main.css` (`.sw-doctor-teaser*`)                       | `featured_team_member` or meta `featured_on_homepage`; CPT `role`; trimmed `post_content`                                                                                        | CPT + ACF                                 |
| 5     | Before / after           | `template-parts/sections/gallery-teaser.php`                                                 | `_grid.css` (`.sw-gallery-teaser*`)                                             | `sw_get_gallery_pairs()` → `gallery_N_before`, `gallery_N_after`, `gallery_N_label`                                                                                              | ACF-driven (no metamorphosis CPT)         |
| 6     | Testimonials             | `template-parts/sections/testimonials.php`, `template-parts/components/card-testimonial.php` | `_grid.css`, `_cards.css`                                                       | `WP_Query` on `testimonial`; fields `rating`, `quote`, `treatment`                                                                                                               | CPT + ACF                                 |
| 7     | FAQ                      | `template-parts/sections/faq.php`                                                            | `components/_accordion.css`                                                     | `WP_Query` on `faq`; title = question, content = answer; `sw_output_faq_schema()`                                                                                                | CPT-driven                                |
| —     | Blog teaser              | `template-parts/sections/blog-teaser.php`                                                    | `_grid.css`                                                                     | Native `post` query, 3 posts                                                                                                                                                     | WP posts (not in approved homepage order) |
| 8     | Contact                  | `template-parts/sections/contact.php`                                                        | `_grid.css`, `components/_forms.css`                                            | `sw_get_option()` NAP/coords; Google Maps iframe; native form                                                                                                                    | Clinic settings + form                    |
| —     | Footer                   | `footer.php`                                                                                 | `assets/styles/layout/_footer.css`                                              | Menu `footer`; address, phone, email, hours, socials via `sw_get_option()`                                                                                                       | Clinic settings + menu                    |
| —     | Sticky CTA bar           | `template-parts/layout/sticky-cta-bar.php`                                                   | `_footer.css` (`.sw-sticky-cta*`)                                               | Phone + hardcoded `#kontakt`                                                                                                                                                     | Clinic settings + hardcoded CTA           |

### Approved sections that do not currently exist in the intended form

- **Featured doctor** as a full-width dark teal section — only a nested card teaser inside why-us exists.
- **Contact CTA** band (phone, hours, address, booking CTA, no map) — current contact is map + NAP + form.
- **Before / after** as a substantial editorial case presentation — current gallery teaser lacks “Przed” / “Po” labels and approved layout weight.
- No dedicated metamorphosis / before-after CPT; homepage pairs are front-page ACF slots.

### Present but outside approved homepage structure

- `blog-teaser` section
- Mobile sticky CTA bar (`sticky-cta-bar.php`)

---

## 4. Current content model

### ACF Free compatibility

`inc/acf-fields.php` registers only Free-compatible types: text, textarea, image, url, select, true_false, post_object, tab. No Repeater, Flexible Content, Relationship, or ACF Options Page. Multi-row homepage content uses fixed numbered slots assembled by helpers in `inc/helpers.php`. If ACF is inactive, the file returns early; templates fall back to demo copy where defined.

### Clinic settings

Implemented in `inc/clinic-settings.php` via the WordPress Settings API (not ACF Options):

- Menu: `sw_register_clinic_settings_page()`
- Option: `sw_clinic`
- Read API: `sw_get_option( $field_key, $fallback )` in `inc/helpers.php`
- Defaults: `sw_clinic_defaults()`
- Sanitize: `sw_sanitize_clinic_options()`

Current keys: `clinic_phone`, `clinic_email`, `clinic_address`, `clinic_lat`, `clinic_lng`, `social_facebook`, `social_instagram`, `google_rating`, `google_review_count`, `clinic_hours`.

**Missing today:** `booking_url` (approved for Phase 1; default fallback `#kontakt`).

Consumers of clinic data today: `header.php`, `footer.php`, `template-parts/layout/nav-mobile.php`, `template-parts/layout/sticky-cta-bar.php`, `template-parts/sections/contact.php`, `inc/seo-schema.php` (`sw_output_dentist_schema()`), `inc/contact-form.php`.

### CPT registration and homepage use

| Post type     | Register function               | Rewrite / notes                                        | Homepage use                             |
| ------------- | ------------------------------- | ------------------------------------------------------ | ---------------------------------------- |
| `service`     | `sw_register_cpt_service()`     | slug `oferta`, has archive, supports `page-attributes` | Services grid, limit 8, `menu_order`     |
| `team_member` | `sw_register_cpt_team_member()` | slug `zespol`, no archive                              | Featured doctor selection                |
| `testimonial` | `sw_register_cpt_testimonial()` | slug `opinie`, no archive                              | Three latest by date                     |
| `faq`         | `sw_register_cpt_faq()`         | slug `faq`, no archive                                 | Six by `menu_order`; also FAQPage schema |

### Homepage ACF group (`group_front_page`)

Location: `page_type == front_page`.

| Area           | Field names                                                                                                                                                 |
| -------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Hero (current) | `hero_headline`, `hero_subheadline`, `hero_media`, `hero_cta_primary_label`, `hero_cta_primary_link`, `hero_cta_secondary_label`, `hero_cta_secondary_link` |
| Trust          | `trust_1_icon` … `trust_4_icon`, `trust_1_value` … `trust_4_value`, `trust_1_label` … `trust_4_label`                                                       |
| Why us         | `why_us_1_title` … `why_us_3_title`, `why_us_1_description` … `why_us_3_description`                                                                        |
| Gallery        | `gallery_1_before/after/label` … `gallery_3_before/after/label`                                                                                             |
| Doctor         | `featured_team_member` (`post_object` → `team_member`)                                                                                                      |

### CPT field groups

- `group_service`: `icon`, `price_range` (`price_range` used in `single-service.php`)
- `group_team_member`: `role`, `certifications`, `featured_on_homepage`
- `group_testimonial`: `rating`, `quote`, `treatment`

### Hardcoded content, fallbacks, and unused / overlapping fields

- Demo fallbacks in `hero.php`, `trust-bar.php`, `why-us.php`
- Booking/CTA href `#kontakt` hardcoded in `header.php`, `nav-mobile.php`, `sticky-cta-bar.php`; hero primary CTA defaults to `#kontakt` when ACF link empty
- Phone fallback `62 123 45 67` passed to `sw_get_option()` in multiple templates
- `trust_N_icon` collected by `sw_get_trust_stats()` but not rendered in `trust-bar.php`
- `certifications` registered on `team_member` but not read by `doctor.php` (or any other inspected template)
- Dual doctor selection: front-page `featured_team_member` with fallback query on meta `featured_on_homepage`
- `google_rating` / `google_review_count` feed schema only, not the trust strip UI
- Comment in `contact.php` still refers to an “ACF Options page”; implementation is Settings API

### Approved content-model changes for Phase 1 (not yet implemented)

Hero fields to add in `inc/acf-fields.php` and consume in `hero.php`:

- `hero_eyebrow`
- `hero_heading_before`
- `hero_heading_emphasis`
- `hero_heading_after`

`hero_headline` remains temporarily as a backwards-compatible fallback. Heading fields must be plain text only (no HTML input).

Clinic setting to add in `inc/clinic-settings.php` / `sw_clinic_defaults()` / sanitize / admin form:

- `booking_url` — single global source for header, mobile nav, hero primary CTA (when appropriate), and future contact CTA; fallback `#kontakt`

---

## 5. CSS architecture

### Entry and imports

`assets/styles/main.css` is the development entry. It `@import`s, in order:

1. `base/_variables.css`
2. `base/_reset.css`
3. `base/_typography.css`
4. `layout/_grid.css`
5. `layout/_header.css`
6. `layout/_footer.css`
7. `components/_buttons.css`
8. `components/_cards.css`
9. `components/_accordion.css`
10. `components/_forms.css`
11. `utilities/_utilities.css`

Doctor teaser rules are appended inline at the bottom of `main.css`.

### Design variables

`assets/styles/base/_variables.css` currently defines a clinical mint/teal palette (`--color-primary: #0D5F66`, `--color-bg: #F5F7F7`, `--color-bg-warm: #F3F1EE`, etc.), Poppins + Inter font families, `--container-max: 1120px`, spacing scale through `--space-8` / `--space-section`, radii, shadows, and transitions. These values do not match `docs/homepage-design-spec.md` §4.

### Grid / container

`.sw-container` and most section padding/grids live in `assets/styles/layout/_grid.css`. Breakpoints in use: `640px` and `900px`.

### Header and Phase 1 section styles (current placement)

- Header + mobile menu + **hero** styles: `assets/styles/layout/_header.css`
- Trust strip styles: `assets/styles/layout/_grid.css` (`.sw-trust-bar*`)

### Approved CSS organization for Phase 1

- Keep header styles in `assets/styles/layout/_header.css`
- Move hero rules from `_header.css` into `assets/styles/sections/_hero.css`
- Move trust strip rules from `_grid.css` into `assets/styles/sections/_trust-bar.css`
- Import the new section partials from `main.css`
- Do **not** perform a general CSS architecture migration; only extract styles touched by Phase 1

### Naming

BEM-like `sw-` prefix (`sw-hero__heading`, `sw-trust-bar__item`, `sw-btn--accent`). Shared section title class: `.sw-section-heading` (centered) in `_typography.css`.

### Generated versus source

- Source of truth for editing: partials under `assets/styles/`
- Production artifact: `assets/styles/main.min.css` (and `assets/scripts/main.min.js`)
- At audit time, `main.min.css` content matched the then-current source tokens and hero/trust rules
- Regenerate assets/styles/main.min.css after source CSS changes.
- Regenerate assets/scripts/main.min.js only if JavaScript source files are modified.

### Likely sources of visual inconsistency

- Page body uses `--color-bg` while hero/trust use `--color-bg-warm`
- No editorial serif in current tokens (Poppins for headings)
- Container max width 1120px versus approved 1280 / 1440
- Card grids, circular `.sw-icon`, and doctor teaser card/shadow conflict with Scandinavian Editorial Premium rules
- Hero styles co-located with header styles until Phase 1 extraction

### Reuse versus do-not-extend

**Reuse in Phase 1:** `.sw-container`, `.sw-btn` / `.sw-btn--accent` / `.sw-btn--outline`, `.sw-link`, sticky header `.is-scrolled`, mobile menu structure, `:focus-visible`, `prefers-reduced-motion` block, spacing token _structure_ (values will change).

**Do not extend further for the approved homepage direction:** `components/_cards.css` and `.sw-icon` circular placeholders, card-grid service/testimonial layouts, doctor teaser card presentation, boxed FAQ cards — leave untouched in Phase 1; rebuild in later phases.

---

## 6. JavaScript and accessibility

### Scripts

| Module         | Path                                                               | Behavior                                                                    | Needed for approved homepage                                       |
| -------------- | ------------------------------------------------------------------ | --------------------------------------------------------------------------- | ------------------------------------------------------------------ |
| Entry          | `assets/scripts/main.js`                                           | Imports and inits modules on `DOMContentLoaded`                             | Yes (as loader)                                                    |
| Mobile menu    | `assets/scripts/modules/mobile-menu.js` → `initMobileMenu()`       | Toggle, `aria-expanded`, focus trap, Escape, close on link click            | Yes (header)                                                       |
| Sticky header  | `assets/scripts/modules/sticky-header.js` → `initStickyHeader()`   | IntersectionObserver → `.is-scrolled`                                       | Allowed by design spec; keep for Phase 1 unless explicitly dropped |
| FAQ accordion  | `assets/scripts/modules/faq-accordion.js` → `initFaqAccordion()`   | Progressive enhancement over `<details>` / `<summary>`                      | Not required for Phase 1; FAQ excluded                             |
| Gallery slider | `assets/scripts/modules/gallery-slider.js` → `initGallerySlider()` | Keyboard horizontal scroll; comments mention scroll-snap not present in CSS | Not required for Phase 1; gallery excluded                         |

Production `main.min.js` bundles mobile menu, sticky header, and FAQ animation as an IIFE. Gallery remains a separate conditionally enqueued module.

### Accessibility facts from markup / scripts

- Skip link to `#main` in `header.php`
- Primary nav uses `SW_Nav_Walker` with `aria-current` and submenu `aria-expanded` attributes
- Mobile toggle exposes `aria-expanded` and `aria-controls="sw-mobile-menu"`
- FAQ uses native `<details>` / `<summary>` (keyboard operable without JS); design spec prefers button + `aria-expanded` for a later FAQ phase
- Global `:focus-visible` outline in `_reset.css`
- Sitewide `prefers-reduced-motion` overrides for CSS animations/transitions in `_variables.css`

### Phase 1 interaction scope

Necessary: mobile navigation behaviour. Sticky header behaviour is compatible with the approved header rules. FAQ and gallery scripts are out of Phase 1 scope.

---

## 7. Differences from approved design

Classification relative to `docs/homepage-design-spec.md`:

| Area                                   | Classification                            | Notes                                                                                  |
| -------------------------------------- | ----------------------------------------- | -------------------------------------------------------------------------------------- |
| Design tokens / typography foundations | Requires substantial rebuild (Phase 1)    | Palette, type scale, container, spacing vs §4; approved pairing Source Serif 4 + Inter |
| Header                                 | Reusable with small changes (Phase 1)     | Three-part layout exists; add `booking_url`; align background/tokens; keep a11y menu   |
| Editorial hero                         | Reusable with small changes (Phase 1)     | Asymmetric markup exists; add eyebrow + split heading fields; restyle; extract CSS     |
| Trust strip                            | Reusable with small changes (Phase 1)     | Four-slot text strip exists; restyle; extract CSS; icons unused in markup              |
| Services                               | Requires substantial rebuild              | Card grid + icon circles vs numbered editorial list; CPT query reusable later          |
| Manifest / Why us                      | Requires substantial rebuild              | No image/statement/eyebrow; nested with doctor                                         |
| Featured doctor                        | Requires substantial rebuild              | Nested light card vs full-width dark section                                           |
| Before / after                         | Requires substantial rebuild              | ACF slots usable later; layout/labels insufficient; no dedicated CPT                   |
| Testimonials                           | Requires substantial rebuild              | Card grid + stars vs open editorial quotes                                             |
| FAQ                                    | Reusable with small changes (later phase) | CPT + details solid; layout/a11y pattern to align later                                |
| Contact CTA                            | Missing / substantial rebuild             | Current contact ≠ approved CTA band                                                    |
| Footer                                 | Reusable with small changes (later phase) | Structure close; services column / privacy link gaps                                   |
| Blog teaser                            | Outside approved order                    | Present in `front-page.php`                                                            |
| Sticky CTA                             | Outside approved section list             | Present sitewide via `footer.php`                                                      |

---

## 8. Concrete risks

1. **Global token regression** — Editing `assets/styles/base/_variables.css` affects every template consuming those variables (archives, singles, footer, cards), not only the homepage Phase 1 sections.

2. **Missing font files** — `_typography.css` and `sw_preload_fonts()` reference `assets/fonts/inter-variable.woff2` and `assets/fonts/poppins-600.woff2`; no font files were present at audit time. Phase 1 uses fallback stacks until local Source Serif 4 + Inter files are added in a separate task.

3. **Production build artifact drift** — With `WP_DEBUG` false, `sw_enqueue_assets()` serves `main.min.css` / `main.min.js`. Source-only edits without regenerating artifacts leave production on stale CSS/JS. Dependencies for `package.json` scripts were not installed at audit time.

4. **Double typography load in development** — `sw-fonts` enqueues `_typography.css` while `main.css` also `@import`s it.

5. **Hardcoded booking targets** — `#kontakt` is duplicated in `header.php`, `template-parts/layout/nav-mobile.php`, `template-parts/layout/sticky-cta-bar.php`, and as the hero primary CTA default. Phase 1 introduces `booking_url` for header, mobile nav, and hero; sticky CTA redesign is excluded, so that bar may remain on `#kontakt` until a later phase unless explicitly wired to the same helper.

6. **Unused trust icon fields** — `trust_N_icon` still in ACF and `sw_get_trust_stats()` while UI ignores icons; leaving them creates admin noise; removing them without a note confuses existing saved values.

7. **Dual featured-doctor selection** — `featured_team_member` vs `featured_on_homepage` in `doctor.php` risks inconsistent content when the dark featured-doctor section is built later (out of Phase 1).

8. **Gallery script enqueue timing — Requires runtime verification** — `$GLOBALS['sw_needs_gallery_script']` is set inside `gallery-teaser.php` during template render, while `sw_enqueue_assets()` runs on `wp_enqueue_scripts`. The gallery script may never load on the front end despite the intended conditional pattern.

9. **FAQ `Element.animate()` vs reduced motion** — Global CSS respects `prefers-reduced-motion`; `initFaqAccordion()` uses the Web Animations API, which may not honour that preference (FAQ out of Phase 1, still a later a11y risk).

10. **Stale internal documentation / rules** — Project cursor rule text referring to “ACF Options” does not match `inc/clinic-settings.php` Settings API implementation.

11. **Homepage extras vs acceptance criteria** — `blog-teaser` and sticky CTA remain in the rendered page during Phase 1; they can make the page look incomplete relative to the approved section list even when Phase 1 work is correct.

---

## 9. Approved Phase 1 boundaries

### In scope

- Global design tokens in `assets/styles/base/_variables.css` (aligned to `docs/homepage-design-spec.md` §4)
- Typography foundations in `assets/styles/base/_typography.css` (Source Serif 4 for display headings; Inter for body, navigation, controls; fallback stacks until local files exist)
- Header markup/styles (`header.php`, `template-parts/layout/nav-mobile.php`, `assets/styles/layout/_header.css`)
- Hero markup/styles (`template-parts/sections/hero.php`, new `assets/styles/sections/_hero.css`)
- Trust strip markup/styles (`template-parts/sections/trust-bar.php`, new `assets/styles/sections/_trust-bar.css`)
- Clinic setting `booking_url` in `inc/clinic-settings.php` and consumption via `sw_get_option()` (fallback `#kontakt`) for header, mobile navigation, and hero booking CTA
- Hero ACF fields: `hero_eyebrow`, `hero_heading_before`, `hero_heading_emphasis`, `hero_heading_after`; retain `hero_headline` as temporary fallback; plain text only
- Wire `main.css` imports for extracted section partials
- Regenerate `assets/styles/main.min.css` after CSS source changes.
- Regenerate `assets/scripts/main.min.js` only if JavaScript source files are modified.

### Explicitly out of scope

- Services section and `card-service.php` / service card CSS
- Why-us section
- Featured doctor section / `doctor.php` redesign
- Gallery / before-after
- Testimonials
- FAQ
- Contact section
- Footer
- Blog teaser
- Sticky CTA redesign
- CPT registration or CPT field changes
- General CSS architecture migration beyond Phase 1 extractions
- Downloading or committing font binary files

### Files likely to be modified in Phase 1

- `assets/styles/base/_variables.css`
- `assets/styles/base/_typography.css`
- `assets/styles/layout/_header.css` (header only after hero extraction)
- `assets/styles/sections/_hero.css` (new)
- `assets/styles/sections/_trust-bar.css` (new)
- `assets/styles/layout/_grid.css` (remove trust rules only)
- `assets/styles/main.css` (imports)
- `assets/styles/components/_buttons.css` (token-aligned CTA polish if required)
- `header.php`
- `template-parts/layout/nav-mobile.php`
- `template-parts/sections/hero.php`
- `template-parts/sections/trust-bar.php`
- `inc/helpers.php` only if trust helper cleanup is explicitly approved
- No booking-specific helper is required; use `sw_get_option( 'booking_url', '#kontakt' )`
- `inc/clinic-settings.php`
- `inc/acf-fields.php`
- `assets/styles/main.min.css` (regenerated after CSS changes)
- `assets/scripts/main.min.js` only if JavaScript source files are modified

### Files that should not be modified in Phase 1

- `template-parts/sections/services-grid.php`, `why-us.php`, `doctor.php`, `gallery-teaser.php`, `testimonials.php`, `faq.php`, `blog-teaser.php`, `contact.php`
- `footer.php` (except unintended token cascade — no intentional footer redesign)
- `template-parts/layout/sticky-cta-bar.php` (redesign excluded)
- `inc/cpt-*.php`
- `template-parts/components/card-*.php`
- Gallery and FAQ JS modules (unless a Phase 1 regression forces a minimal fix)

### Recommended implementation order

1. Design tokens
2. Typography foundations (fallback stacks)
3. `booking_url` clinic setting + shared read path
4. Header (consume `booking_url`)
5. Hero fields + markup + extract/move CSS to `_hero.css`
6. Trust strip + extract/move CSS to `_trust-bar.css`
7. Smoke-check homepage and one interior template for token regressions
8. Regenerate minified build artifacts

---

## 10. Decisions already approved

1. **Typography**
   - Display / headings: Source Serif 4
   - Body, navigation, controls: Inter
   - Local font files handled in a separate task
   - Phase 1 may ship with correct CSS fallback stacks
   - Do not download or add font files as part of Phase 1 documentation or implementation kickoff

2. **Global booking CTA**
   - Add clinic setting key `booking_url` in Phase 1
   - Default fallback: `#kontakt`
   - Header, mobile navigation, hero, and the future contact CTA must share this global source

3. **Hero content model**
   - Add `hero_eyebrow`, `hero_heading_before`, `hero_heading_emphasis`, `hero_heading_after`
   - Keep `hero_headline` temporarily as backwards-compatible fallback
   - No HTML allowed in heading fields

4. **CSS organization for Phase 1**
   - Header remains in `assets/styles/layout/_header.css`
   - Hero moves to `assets/styles/sections/_hero.css`
   - Trust strip moves to `assets/styles/sections/_trust-bar.css`
   - No general CSS architecture migration

5. **Phase 1 product scope**
   - Tokens, typography foundations, header, hero, trust strip, `booking_url`, required hero fields, build artifact regeneration only
   - All later homepage sections and CPT changes excluded as listed in §9

---

## 11. Open issues that do not block Phase 1

1. **Gallery script enqueue** — Confirm at runtime whether `sw-gallery-slider` ever loads given flag timing versus `wp_enqueue_scripts` (**Requires runtime verification**).

2. **Sticky CTA and `booking_url`** — Redesign excluded; decide in a later phase whether to point `sticky-cta-bar.php` at `booking_url` for consistency without visual redesign.

3. **Trust icon fields** — Keep, hide in admin, or remove after Phase 1; not required to ship tokens/header/hero/trust visuals.

4. **Featured doctor selection model** — Resolve `featured_team_member` vs `featured_on_homepage` before the featured-doctor phase.

5. **Before/after data ownership** — Confirm whether front-page ACF gallery slots are sufficient long-term or a metamorphosis CPT is needed; design spec defers CPT creation until after audit (this audit: no such CPT exists).

6. **Blog teaser removal or relocation** — Outside Phase 1; affects final homepage acceptance against the approved section list.

7. **FAQ interaction pattern** — Native `<details>` vs button + `aria-expanded` to be decided in the FAQ phase.

8. **Font binary delivery** — Separate task for self-hosted Source Serif 4 and Inter files, preload updates, and removal of obsolete Poppins references.

9. **Dependency install for builds** — Running `npm install` / `npm run build` requires explicit approval; Phase 1 regeneration depends on that approval when production min files must update.

10. **Cursor / internal rule drift** — Update stale “ACF Options” wording in project rules after Phase 1 or in a docs hygiene pass; does not block implementation.

---

## Audit conclusion

The classic theme architecture (`functions.php` module loader, fixed `front-page.php` composition, section partials, ACF Free + Settings API clinic data) is safe for an incremental homepage redesign.

No blocking cleanup is required before Phase 1 beyond awareness of missing font binaries and build-artifact discipline. The current data model is sufficient for Phase 1 once `booking_url` and the approved hero fields are added; `hero_headline` remains as a temporary fallback.

Highest-priority items for implementation kickoff are already decided (§10). Remaining open issues (§11) can proceed in parallel or in later phases without delaying Phase 1.
