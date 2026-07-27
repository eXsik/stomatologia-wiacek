# Theme architecture

Current map of the **Stomatologia Wiącek — Redesign Concept** theme (as shipped).

## Stack

- Classic PHP WordPress theme (no FSE, no page builder)
- ACF Free — field groups in `inc/acf-fields.php` (no Repeater / Options Page)
- Vanilla JS (ES modules in dev, esbuild IIFE in prod), no jQuery on the front end
- Hand-authored CSS (BEM `sw-*`, design tokens in `assets/styles/base/_variables.css`)

## Bootstrap

`functions.php` loads modules from `inc/`:

| Module | Role |
|--------|------|
| `setup.php` | Theme supports, image sizes, head cleanup, nav current-state helpers |
| `enqueue.php` | CSS/JS, font preload, defer scripts |
| `helpers.php` | `sw_image()`, clinic helpers, `sw_page_hero_aside()`, gallery/trust helpers |
| `clinic-settings.php` | Admin **Dane gabinetu** (NAP, hours, socials, booking URL → JSON-LD) |
| `theme-pages.php` | Seeds core pages; maps menu `#hashes` → real permalinks; nav fallbacks |
| `cpt-*.php` | Services, team, testimonials, FAQ |
| `acf-fields.php` | Homepage + CPT field groups |
| `seo-meta.php` / `seo-schema.php` | Meta, OG, JSON-LD |
| `contact-form.php` | Native contact handler |
| `nav-walker.php` | Accessible desktop nav + submenus |

## Template hierarchy

```
front-page.php
  → hero, trust-bar, services-grid, why-us, doctor,
    gallery-teaser, testimonials, faq, contact (CTA band)

page.php                          → generic pages + unified page-hero
templates/page-about.php          → O nas
templates/page-team.php           → Zespół
templates/page-gallery.php        → Metamorfozy
templates/page-faq.php            → FAQ
templates/page-contact.php        → Kontakt (+ contact-full)
archive-service.php, single-service.php
archive.php, single.php, 404.php
```

Shared chrome: `template-parts/components/page-hero.php` (editorial hero + aside panel).

Composition: thin templates + `get_template_part()`.

## Content sources

| Data | Source |
|------|--------|
| NAP, hours, map, booking URL, socials | **Dane gabinetu** (`sw_clinic`) |
| Homepage hero / trust / why-us / gallery / doctor | ACF on front page |
| Usługi, zespół, FAQ, opinie | CPTs |
| Subpage titles / leads | Page title + excerpt (with PHP demo fallbacks) |
| Primary / footer menus | Appearance → Menus (hash links rewritten to pages) |

## Assets

- **CSS:** `assets/styles/main.css` → PostCSS → `main.min.css` (prod)
- **JS:** `assets/scripts/main.js` → esbuild → `main.min.js` (prod)
- **Fonts:** self-hosted Source Serif 4 + Inter in `assets/fonts/`

## SEO

- Breadcrumbs UI synced with `BreadcrumbList` JSON-LD
- `Dentist` / `LocalBusiness` from clinic settings
- `FAQPage` from the same FAQ query as the UI

## Conscious scope-out

See README — booking API, live Google Reviews, caching plugins, WebP pipeline, WooCommerce.

## Related docs

- [`homepage-design-spec.md`](homepage-design-spec.md) — original design brief (historical)
- [`portfolio-case-study.md`](portfolio-case-study.md) — short recruiter write-up
- [`application-meetco.md`](application-meetco.md) — application copy template
- [`screenshots/`](screenshots/) — visual previews
