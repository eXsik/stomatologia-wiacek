# Portfolio case study — Stomatologia Wiącek redesign concept

**Author:** eXsik · **Repo:** [stomatologia-wiacek](https://github.com/eXsik/stomatologia-wiacek)

## Problem

Build a portfolio-grade WordPress theme that demonstrates front-end craft, SEO, and maintainable PHP — using a dental practice as a realistic single-site scenario (not a generic landing page).

## Approach

1. Define an editorial design direction (`docs/homepage-design-spec.md`).
2. Classic theme architecture — thin templates, `template-parts/`, ACF Free only (no Options Page / Repeater).
3. Single source of truth — custom admin **Dane gabinetu** for NAP, hours, and schema (not ACF Options).
4. SEO without plugins — meta/OG + JSON-LD synced with visible UI (breadcrumbs, FAQ).
5. Performance defaults — self-hosted fonts, lazy images with LCP exception, defer JS, no jQuery, minified prod bundles.

## Stack

WordPress 6.4+, PHP 8, ACF Free, vanilla JS (esbuild), PostCSS/cssnano, BEM + CSS custom properties.

## Highlights for code review

| Area | Where to look |
|------|----------------|
| CPT + templates | `inc/cpt-*.php`, `single-service.php`, `archive-service.php` |
| Subpages + nav | `inc/theme-pages.php`, `templates/page-*.php` |
| Unified page hero | `template-parts/components/page-hero.php` |
| ACF (Free) | `inc/acf-fields.php`, helpers in `inc/helpers.php` |
| SEO | `inc/seo-meta.php`, `inc/seo-schema.php` |
| CSS system | `assets/styles/base/_variables.css`, section partials |
| A11y JS | `assets/scripts/modules/mobile-menu.js`, `nav-dropdown.js` |
| Images | `sw_image()` in `inc/helpers.php` |

## Trade-offs (intentional)

- **No WooCommerce** — practice site, not e-commerce.
- **No page builder** — full control over markup and CSS.
- **Fixed-slot ACF fields** instead of Repeater — ACF Free constraint, assembled via helpers.
- **Placeholder media / demo fallbacks** — layout and patterns without licensed photography.

## Outcome

Editorial homepage (9 sections), service archive/single, O nas / Zespół / Metamorfozy / FAQ / Kontakt, unified page hero, accessible navigation, and screenshots for recruiter review. Local setup documented in the root README.
