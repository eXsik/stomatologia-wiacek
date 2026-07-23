# Phase 1 Implementation Plan

**Project:** Stomatologia Wiącek  
**Branch:** `redesign/homepage-editorial`  
**Source of truth:** `docs/homepage-design-spec.md`, `docs/current-theme-audit.md`, `docs/content-model.md`  
**Constraint:** ACF Free only; no font binaries; no dependency install without approval

> **Status update:** This document is intentionally limited to Phase 1. It is not sufficient to reach the final generated homepage concept. For the remaining work, use `docs/final-homepage-implementation-plan.md` as the active implementation plan.

This plan covers Phase 1 implementation only. It does not contain implementation code.

---

## 1. Goal

Deliver the first homepage slice of the Scandinavian Editorial Premium redesign:

- approved global design tokens and typography foundations (Source Serif 4 + Inter **fallback stacks**);
- editable global `booking_url` in Dane gabinetu;
- redesigned header (desktop + mobile) using that booking URL;
- editorial hero with split heading fields and approved CTA priority;
- redesigned trust strip using existing four text slots;
- hero/trust CSS extracted into section partials;
- regenerated `assets/styles/main.min.css`;
- validated backwards compatibility for existing hero and trust content.

Later homepage sections remain visually and structurally unchanged except for unavoidable global token cascade.

---

## 2. Scope boundaries

### Included

- Tokens in `assets/styles/base/_variables.css`
- Typography foundations in `assets/styles/base/_typography.css`
- `booking_url` in `inc/clinic-settings.php` via option `sw_clinic`
- Header + mobile nav booking CTA wiring
- Hero ACF fields + markup in `inc/acf-fields.php` / `template-parts/sections/hero.php`
- Trust strip restyle (existing fields via `sw_get_trust_stats()`)
- Extract `.sw-hero*` → `assets/styles/sections/_hero.css`
- Extract `.sw-trust-bar*` → `assets/styles/sections/_trust-bar.css`
- Update `assets/styles/main.css` imports
- Optional token-aligned polish in `assets/styles/components/_buttons.css` and `assets/styles/layout/_header.css`
- `npm run build:css` → `assets/styles/main.min.css`
- Regression / acceptance testing

### Excluded

- Services, why-us, featured doctor, gallery, testimonials, FAQ, contact, footer, blog teaser
- Sticky CTA redesign (`template-parts/layout/sticky-cta-bar.php`)
- All `inc/cpt-*.php` and CPT field groups
- Removing `trust_N_icon` fields
- New booking helper (use `sw_get_option( 'booking_url', '#kontakt' )` only)
- Font file download / commit
- General CSS architecture migration
- `npm run build:js` / `main.min.js` unless JS source changes (Phase 1 expects no JS source changes)
- `npm install` without explicit approval
- Push to remote

---

## 3. Preconditions

1. Current git branch is `redesign/homepage-editorial`.
2. Working tree must be clean before implementation starts.
3. Docs above are the source of truth for design, content model, and boundaries.
4. Do **not** download or add font binaries; Phase 1 uses CSS fallback stacks for Source Serif 4 and Inter.
5. Do **not** run `npm install` without explicit approval.
6. Existing content must remain backwards-compatible per `docs/content-model.md` §7 (`hero_headline`, trust slots, `#kontakt` fallback).

---

## 4. Implementation steps

### Task 1 — Design tokens

- **Objective:** Align CSS custom properties with `docs/homepage-design-spec.md` §4 (palette, spacing, container, radii, shadows, type scale hooks).
- **Files allowed:** `assets/styles/base/_variables.css`
- **Requirements:** Introduce approved colors (`--color-bg: #F6F2EA`, `--color-brand: #0D4A4D`, `--color-accent: #EF6A57`, etc.). Map or alias legacy names (`--color-primary`, `--color-bg-warm`, …) so untouched sections do not break, **or** update tokens carefully and accept cascade—prefer aliases where existing components reference old names. Set the default content container to 1280px and provide a separate wide-layout maximum of 1440px where required by the approved design. Keep `prefers-reduced-motion` block.
- **Forbidden:** Section templates; CPT files; font binaries; `_cards.css` redesign.
- **Validation:** Grep for hardcoded old hex in Phase 1 files; load homepage and one interior page.
- **Done when:** Token file matches approved hierarchy; no pure-black body text token; coral reserved for accent/CTA.

### Task 2 — Typography foundations

- **Objective:** Set Source Serif 4 for display/headings and Inter for body, nav, controls via fallback stacks.
- **Files allowed:** `assets/styles/base/_typography.css`, `inc/enqueue.php`; may touch `_variables.css` font-family variables only if not finished in Task 1.
- **Requirements:** `--font-heading` / display → Source Serif 4 + serif fallbacks; `--font-body` → Inter + sans fallbacks. Update or neutralize broken `@font-face` / Poppins references so missing files do not confuse the stack. Do not add `assets/fonts/*`. Update `sw_preload_fonts()` in `inc/enqueue.php` so the theme does not preload a missing font file. Do not replace it with a preload for another non-existent font. Until local font files are added, no font preload should be output.
- **Forbidden:** Font downloads; JS changes; later sections.
- **Validation:**
  - Computed `font-family` on H1 vs body/nav in DevTools (fallback names acceptable).
  - Rendered page does not contain a preload link to a missing font file.
  - Network panel shows no font-related `404` caused by the theme.
- **Done when:** Heading vs body pairing matches approved direction without local font files.

### Task 3 — `booking_url` clinic setting

- **Objective:** Add global booking URL to Dane gabinetu.
- **Files allowed:** `inc/clinic-settings.php` only (`sw_clinic_defaults()`, `sw_sanitize_clinic_options()`, `sw_render_clinic_settings_page()`).
- **Requirements:** Key `booking_url`; URL input; sanitize with `esc_url_raw`; empty → read fallback `#kontakt` via `sw_get_option( 'booking_url', '#kontakt' )`. No new helper in `inc/helpers.php`.
- **Forbidden:** `inc/helpers.php` booking helper; sticky CTA; footer; contact section.
- **Validation:** Save URL in admin; `get_option( 'sw_clinic' )` contains key; empty value returns `#kontakt` from `sw_get_option`.
- **Done when:** Setting is editable and readable as specified in `docs/content-model.md` §2.

### Task 4 — Header

- **Objective:** Wire booking CTAs and align header visuals with tokens.
- **Files allowed:** `header.php`, `template-parts/layout/nav-mobile.php`, `assets/styles/layout/_header.css` (header/nav/mobile only—no `.sw-hero*` once Task 6 extracts them; until then avoid expanding hero rules).
- **Requirements:** Replace hardcoded `#kontakt` booking links with `esc_url( sw_get_option( 'booking_url', '#kontakt' ) )`. Preserve `SW_Nav_Walker`, mobile toggle `aria-expanded` / `aria-controls`, skip link. Keep sticky behaviour via existing `data-sw-sticky-header` / `initStickyHeader()`. Visual: warm page integration, thin separator, coral primary CTA, ~84–104px height target.
- **Forbidden:** `sticky-cta-bar.php`; menu registration changes in `inc/setup.php` unless broken; hero markup.
- **Validation:** Desktop CTA + mobile CTA href; keyboard open/close menu; focus trap still works.
- **Done when:** Header/mobile booking always use `booking_url` with `#kontakt` fallback.

### Task 5 — Hero content fields and markup

- **Objective:** Implement Phase 1 hero content model.
- **Files allowed:** `inc/acf-fields.php`, `template-parts/sections/hero.php`
- **Requirements:** Add ACF Free text fields `hero_eyebrow`, `hero_heading_before`, `hero_heading_emphasis`, `hero_heading_after` on `group_front_page`. Keep `hero_headline`. Heading fallback priority per `docs/content-model.md` §3.2. Emphasis via template markup/CSS only; all text via `esc_html()`. Primary CTA URL: `hero_cta_primary_link` → `sw_get_option( 'booking_url', '#kontakt' )`. Retain `hero_subheadline`, `hero_media`, secondary CTA fields and `sw_image()` LCP behaviour.
- **Forbidden:** WYSIWYG/HTML heading fields; ACF Pro; `inc/helpers.php` unless approved for non-booking reason; later sections.
- **Validation:** Combinations: split filled; split empty + `hero_headline`; both empty → PHP demo; empty segments omitted; primary link override vs booking_url.
- **Done when:** Content-model §3 and §8 criteria for hero are met in markup.

### Task 6 — Hero CSS extraction and redesign

- **Objective:** Move hero styles out of header partial and match editorial layout.
- **Files allowed:** create `assets/styles/sections/_hero.css`; modify `assets/styles/layout/_header.css` (remove `.sw-hero*`); modify `assets/styles/main.css` (add `@import` for `_hero.css`); optionally `_buttons.css` if CTA sizing needs token alignment.
- **Requirements:** Asymmetric text/image split (~42–46% / 54–58% desktop); no text overlay on image; warm background; serif H1; stack on mobile (text then image). Import order: after layout header or with other section imports—keep `main.css` readable.
- **Forbidden:** Restyling services/why-us/etc.; changing `_grid.css` beyond not owning hero.
- **Validation:** Desktop/mobile layout; text-only modifier `.sw-hero--text-only` still works; no horizontal overflow.
- **Done when:** No `.sw-hero` rules remain in `_header.css`; section file owns hero presentation.

### Task 7 — Trust strip CSS extraction and redesign

- **Objective:** Extract and restyle trust strip per spec §8.
- **Files allowed:** create `assets/styles/sections/_trust-bar.css`; modify `assets/styles/layout/_grid.css` (remove `.sw-trust-bar*` only); modify `assets/styles/main.css` (import); optionally `template-parts/sections/trust-bar.php` for class/markup tweaks that do not change field model.
- **Requirements:** Four text slots; thin separators; serif value / sans label; no icons/cards; 2-col or stack on small screens. Keep `sw_get_trust_stats()`; empty values skipped; demo fallback retained unless it causes wrong output. Do not remove `trust_N_icon` from ACF/`sw_get_trust_stats()`.
- **Forbidden:** Repeater; CPT; icon UI; editing why-us/services grids in `_grid.css` beyond trust removal.
- **Validation:** 1–4 items render; icons never appear; separators readable.
- **Done when:** Trust rules live only in `_trust-bar.css`; visuals match Phase 1 direction.

### Task 8 — Build artifacts

- **Objective:** Regenerate production CSS artifact after source CSS changes.
- **Files allowed:** generated `assets/styles/main.min.css` only (via build). Do not edit min file by hand.
- **Requirements:** Follow §6 Build procedure. Rebuild `main.min.js` **only** if JS sources changed (not expected).
- **Forbidden:** Hand-editing min CSS; inventing other bundlers; `npm install` without approval.
- **Validation:** With `WP_DEBUG` false, page loads `main.min.css` and shows Phase 1 styles; with true, `main.css` path works.
- **Done when:** Min CSS reflects new tokens, typography, header, hero, trust imports.

### Task 9 — Regression and acceptance testing

- **Objective:** Prove Phase 1 acceptance and no forbidden file drift.
- **Files allowed:** none for feature work; fixes only in Phase 1–allowed files if bugs found.
- **Requirements:** Execute §7 checklist; confirm §8 criteria; `git status` shows only expected paths.
- **Forbidden:** “Drive-by” fixes in excluded sections.
- **Validation:** Full checklist pass.
- **Done when:** Phase 1 acceptance criteria met; stop conditions not triggered.

---

## 5. Exact file change map

| File                                    | Action            | Reason                                         | Task |
| --------------------------------------- | ----------------- | ---------------------------------------------- | ---- |
| `assets/styles/base/_variables.css`     | modify            | Approved tokens / aliases                      | 1    |
| `assets/styles/base/_typography.css`    | modify            | Source Serif 4 + Inter fallbacks               | 2    |
| `inc/enqueue.php`                       | modify            | Remove or disable preload of missing font file | 2    |
| `inc/clinic-settings.php`               | modify            | Add `booking_url`                              | 3    |
| `header.php`                            | modify            | Booking CTA → `booking_url`                    | 4    |
| `template-parts/layout/nav-mobile.php`  | modify            | Mobile booking CTA                             | 4    |
| `assets/styles/layout/_header.css`      | modify            | Header visuals; remove hero rules              | 4, 6 |
| `inc/acf-fields.php`                    | modify            | New hero text fields                           | 5    |
| `template-parts/sections/hero.php`      | modify            | Split heading + CTA priority                   | 5    |
| `assets/styles/sections/_hero.css`      | create            | Hero presentation                              | 6    |
| `assets/styles/main.css`                | modify            | Import section partials                        | 6, 7 |
| `assets/styles/components/_buttons.css` | modify (optional) | Token-aligned CTA                              | 6    |
| `assets/styles/layout/_grid.css`        | modify            | Remove trust-bar rules only                    | 7    |
| `assets/styles/sections/_trust-bar.css` | create            | Trust presentation                             | 7    |
| `template-parts/sections/trust-bar.php` | modify (optional) | Markup/class tweaks only                       | 7    |
| `assets/styles/main.min.css`            | generated         | Production CSS                                 | 8    |

`inc/helpers.php` is **not** in the map unless a later review explicitly approves trust helper cleanup (icons still collected, not rendered).

---

## 6. Build procedure

1. **Source entry:** `assets/styles/main.css` (imports partials including new `sections/_hero.css` and `sections/_trust-bar.css`).
2. **Generated artifact:** `assets/styles/main.min.css` via `package.json` script `build:css` (`postcss` + `postcss-import` + `cssnano`).
3. After CSS source changes, run: `npm run build:css`
4. Do **not** run `npm run build:js` unless `assets/scripts/**` changed.
5. Do **not** run `npm install` without explicit approval.
6. If `node_modules` is missing and `npm run build:css` fails: **stop** and request approval to install `package.json` `devDependencies`. Do not introduce alternate build tools.
7. `inc/enqueue.php`: `WP_DEBUG` true → `main.css`; false → `main.min.css`. Both paths must be verified after rebuild.

---

## 7. Testing checklist

- [ ] `php -l` on every modified PHP file
- [ ] Homepage desktop: header, hero, trust match Phase 1 direction
- [ ] Homepage mobile: stacked hero, trust 2-col/stack, mobile menu
- [ ] Primary nav + mobile menu keyboard / Escape / focus trap
- [ ] Empty `booking_url` → header/mobile/hero (without primary link) use `#kontakt`
- [ ] Set `booking_url` → header/mobile update; hero uses it when `hero_cta_primary_link` empty
- [ ] `hero_cta_primary_link` populated overrides booking URL on hero only
- [ ] Split heading combinations + empty split → `hero_headline` → PHP demo
- [ ] Empty split segments omit blank lines; no editor HTML in H1
- [ ] Trust: omit empty values; no icons; demo fallback if no rows
- [ ] Visible `:focus-visible` on CTAs and nav
- [ ] One interior page (e.g. service single or page) for token regression
- [ ] `WP_DEBUG` true loads `main.css`; false loads updated `main.min.css`
- [ ] Browser console clean of Phase 1 regressions
- [ ] `git status` / diff limited to file map in §5

---

## 8. Phase 1 acceptance criteria

1. Tokens reflect approved warm bg, brand teal, coral accent, layout widths from design spec §4.
2. Typography uses Source Serif 4 and Inter **fallback stacks** (no new font binaries required).
3. `booking_url` editable in Dane gabinetu; sanitized with `esc_url_raw`; read via `sw_get_option( 'booking_url', '#kontakt' )`.
4. Header and mobile booking CTAs always use that API.
5. Hero primary CTA priority: `hero_cta_primary_link` → `booking_url` → `#kontakt`.
6. Split H1 + optional eyebrow work; `hero_headline` remains fallback; plain text only.
7. Trust strip is typography-led four-slot strip without icons/cards.
8. Hero CSS in `assets/styles/sections/_hero.css`; trust CSS in `assets/styles/sections/_trust-bar.css`; header file has no hero rules.
9. `main.min.css` regenerated and serves Phase 1 styles when `WP_DEBUG` is false.
10. No ACF Pro; no CPT changes; no intentional edits to excluded section templates.
11. Existing content without new fields still renders.

---

## 9. Commit strategy

Prefer small local commits (no push):

1. **Tokens + typography** — `_variables.css`, `_typography.css`
2. **Content model wiring** — `inc/clinic-settings.php`, `inc/acf-fields.php` (fields only if not yet consumed)
3. **Header, hero, trust UI** — PHP templates + `_header.css` + new section CSS + `main.css` (+ optional buttons/trust-bar.php/`_grid.css`)
4. **Build artifact + fixes** — `main.min.css` and any validation fixes in allowed files

Do not push to remote as part of this plan.

---

## 10. Stop conditions

Stop implementation and request review if:

- A later homepage section or CPT file appears necessary to change for Phase 1 to work
- ACF Pro (Repeater, Flexible Content, Options Page, etc.) would be required
- A new npm/Composer dependency appears necessary beyond existing `package.json` scripts
- Backwards compatibility for `hero_headline` / trust / `#kontakt` cannot be preserved
- `npm run build:css` fails because dependencies are missing (request install approval)
- Design/content-model requirements conflict with inspected code and cannot be resolved within allowed files
- Font binaries seem mandatory to ship Phase 1 (they are not; use fallbacks)

When stopped, report the blocking file/function, the conflicting requirement, and the smallest proposed resolution—do not expand scope unilaterally.
