# Stomatologia Wiącek — Redesign Concept (Portfolio Project)

**This is an unofficial, non-commercial redesign concept created as a portfolio piece for a
Front-End Developer / WordPress job application. It is not affiliated with, endorsed by, or
built for the real Stomatologia Wiącek practice.** All content is placeholder/demo text unless
noted otherwise.

## What this demonstrates
- WordPress theme development: custom post types, ACF Pro field architecture, template hierarchy
- Front-end engineering: hand-authored CSS design system, vanilla JS (no framework/jQuery), accessibility
- SEO implementation: JSON-LD structured data, meta/OG tags, semantic markup, breadcrumbs
- Performance-conscious decisions: conditional asset loading, lazy images, deferred/module scripts, font optimization

See `/docs/architecture.md` (or the accompanying portfolio write-up) for the full audit →
strategy → wireframe → architecture process behind this build.

## Requirements
- WordPress 6.4+
- PHP 8.0+
- ACF Pro (for Options Page + repeater/relationship fields — the theme fails gracefully without it, but content editing loses its structured fields)

## Setup
1. Copy this theme folder into `wp-content/themes/`.
2. Activate **Stomatologia Wiacek – Redesign Concept** in Appearance → Themes.
3. Install & activate **Advanced Custom Fields PRO**.
4. Go to **Dane gabinetu** (custom admin menu) and fill in NAP, hours, socials, map coordinates — this single source of truth feeds the header, footer, contact section, and JSON-LD schema.
5. Add content under **Usługi** (Services), **Zespół** (Team), **Opinie** (Testimonials), **FAQ**.
6. Set a static homepage (Settings → Reading → a page using `front-page.php` is automatic since it's a template file, not a page template — no extra step needed).
7. Assign the **Kontakt** page template to your Kontakt page (Page Attributes → Template).
8. Set **Settings → Reading → Posts page** if you want `/aktualnosci/` as a proper blog archive URL.

## ACF field sync
Field groups are registered in `inc/acf-fields.php` for code-reviewability. In a live project,
export them to `/acf-json/` (ACF Pro does this automatically on save) and commit that folder —
it becomes the source of truth over the database copy, which is the standard professional
ACF workflow for version-controlled builds.

## Build step (production)
`assets/styles/main.css` and `assets/scripts/main.js` are authored as separate partials/modules
for readability. A production deploy should run a lightweight build (esbuild or PostCSS) to
output `main.min.css` / `main.min.js`, referenced automatically by `inc/enqueue.php` whenever
`WP_DEBUG` is `false`. Example `package.json` scripts are included as a starting point.

## Consciously scoped out (documented, not implemented)
Given the 1–2 day portfolio timeframe, the following were deliberately left as noted
recommendations rather than built:
- **Live Google Reviews API sync** — testimonials are currently CPT-managed/manual; a production
  build would pull live reviews via the Google Business Profile API on a cron schedule.
- **Online booking widget** (e.g. Booksy embed) — the contact form + tap-to-call cover the MVP
  conversion path; a real deployment would likely integrate the practice's existing booking system.
- **Caching / object cache plugin configuration** — recommended (WP Rocket / LiteSpeed / W3TC
  depending on host) but not configured in this local build.
- **Actual photography** — hero/team/gallery images are placeholders; a live build needs real,
  licensed photography of the practice, staff, and equipment.
- **Real WebP/AVIF asset pipeline** — `sw_image()` is written to support `wp_get_attachment_image`
  responsive output; an actual image-optimization plugin or build-time conversion step would
  generate the WebP variants themselves.
