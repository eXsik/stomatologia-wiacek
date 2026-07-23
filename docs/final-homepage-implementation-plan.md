# Final Homepage Implementation Plan

**Project:** Stomatologia Wiącek  
**Goal:** finish the homepage so it visually matches `docs/references/homepage-desktop-concept.png`  
**Current issue:** Phase 1 improved the design foundation, header, hero and trust strip, but the rest of the homepage still uses the old card/grid templates. This is why the page looks unfinished compared with the generated concept.

This document replaces the Phase 1-only scope for the remaining homepage work. The old `implementation-plan.md` remains useful as historical context for what has already been attempted.

---

## 1. North star

The final homepage must feel like the generated desktop concept:

- editorial, calm, premium, warm;
- strong serif typography and restrained sans-serif UI;
- asymmetric image-led section compositions;
- thin separators instead of cards;
- one dark teal doctor section as the main contrast moment;
- compact contact CTA band before the footer;
- no blog teaser on the homepage;
- no generic card grids, icon circles, heavy shadows, decorative gradients or centered section after centered section.

When there is a conflict between current implementation and the concept, the concept wins unless a WordPress/content constraint makes it unsafe.

---

## 2. Current diagnosis

### Already close enough to keep

- Global color tokens and serif/sans direction.
- Header structure.
- Hero content model and general two-column shape.
- Trust strip concept.

### Must be rebuilt

- Services: currently a card grid; must become an editorial numbered list.
- Why-us: currently a text list paired with a doctor card; must become a manifest section with image.
- Doctor: currently a small light card; must become a full-width dark teal feature section.
- Gallery/metamorphoses: currently placeholder or small pairs; must become a substantial before/after band.
- Testimonials: currently cards with stars; must become open editorial quotes.
- FAQ: currently centered boxed accordion; must become a split editorial FAQ list.
- Contact: currently map + form; must become compact booking CTA band.
- Footer: must be tightened to match the dark footer in the concept.
- Blog teaser: remove from homepage.

---

## 3. Final homepage structure

The homepage order should be:

1. Header
2. Editorial hero
3. Trust strip
4. Services editorial list
5. Manifest / why-us with image
6. Featured doctor dark section
7. Before/after metamorphoses
8. Testimonials
9. FAQ
10. Contact CTA band
11. Footer

`front-page.php` should render exactly this sequence. Remove `blog-teaser` from the homepage.

---

## 4. Implementation principles

### Layout

- Use `--container-wide` for hero/trust and wide image rows.
- Use `--container-max` for ordinary content.
- Prefer section-specific CSS files under `assets/styles/sections/`.
- Avoid global centered headings except where the concept clearly centers content.
- Desktop sections should usually be two-column editorial layouts.

### Components

- Do not reuse card components for services, testimonials or doctor on the homepage.
- Do not use `.sw-icon` circles on the homepage.
- Use thin borders/separators as the main structure.
- Keep border radius at 0-8px.
- Coral is only for primary booking actions and focused interactive states.

### Content

- Keep ACF Free compatibility.
- Prefer existing CPTs where they already own content:
  - services from `service`;
  - doctor from `team_member`;
  - testimonials from `testimonial`;
  - FAQ from `faq`.
- Use fixed ACF slots only where no CPT exists yet, such as before/after gallery pairs and why-us points.

### Assets

The concept depends on real visual material. The final page needs:

- hero interior image;
- manifest/reception or lounge image;
- doctor portrait;
- before/after images with consistent crop and labels;
- optional small botanical/detail image in services section.

Temporary generated or placeholder images are acceptable during implementation, but the layout must be designed as if real clinic assets will replace them.

---

## 5. Task plan

### Task 1 - Stabilize Phase 1 base

**Goal:** remove fragile overrides and make header/hero/trust reliable before rebuilding the rest.

Files:

- `assets/styles/sections/_hero.css`
- `assets/styles/sections/_trust-bar.css`
- `assets/styles/layout/_header.css`
- `assets/styles/base/_typography.css`

Requirements:

- Simplify duplicate desktop override blocks in `_hero.css`.
- Keep hero near the concept: left text, right image, large serif heading.
- Ensure trust strip desktop height/typography matches the concept.
- Ensure mobile does not overflow.

Done when:

- Header, hero and trust visually form one intentional first viewport.
- No hard-to-explain duplicate final override blocks remain.

### Task 2 - Services editorial list

**Goal:** replace the current service card grid with the concept's numbered list layout.

Files:

- `template-parts/sections/services-grid.php`
- create `assets/styles/sections/_services-editorial.css`
- `assets/styles/main.css`
- optionally stop using `template-parts/components/card-service.php` on the homepage only

Markup shape:

- section eyebrow: `USLUGI`
- left column: heading `Kompleksowa opieka na najwyzszym poziomie.`
- optional support image/detail
- right column: rows with number, title, one-line summary and arrow

Data:

- Query `service` CPT by `menu_order`, limit 6.
- Use excerpt if available; otherwise trimmed content.

Done when:

- No homepage service cards are visible.
- Rows use thin separators and large serif numbers.

### Task 3 - Manifest / why-us with image

**Goal:** rebuild why-us as a human editorial statement, not a feature grid.

Files:

- `template-parts/sections/why-us.php`
- create `assets/styles/sections/_manifest.css`
- `assets/styles/main.css`
- optionally add fixed ACF image field for manifest image in `inc/acf-fields.php`

Markup shape:

- left text block with eyebrow `DLACZEGO MY`
- heading `Leczymy ludzi, nie tylko zeby.`
- short paragraph
- 3-5 concise points with minimal check marks
- right large image

Done when:

- Doctor is no longer nested inside this section.
- Layout matches the split image/text section in the concept.

### Task 4 - Featured doctor dark section

**Goal:** make the doctor section the main dark teal contrast band.

Files:

- `template-parts/sections/doctor.php`
- create `assets/styles/sections/_doctor-feature.css`
- `assets/styles/main.css`
- `front-page.php` if needed to render doctor as a standalone section

Markup shape:

- full-width dark teal section
- portrait column
- center biography column
- right qualification list
- CTA/link to team

Data:

- Use `featured_team_member` front-page field.
- Fallback to `team_member` with `featured_on_homepage`.
- Use featured image as portrait.
- Use title as doctor name.
- Use `role`.
- Use excerpt/content for short bio.
- Qualification data can initially use the existing `certifications` text field.

Done when:

- No light card doctor teaser remains on the homepage.
- Doctor section visually matches the concept's dark band.

### Task 5 - Before/after metamorphoses

**Goal:** turn the gallery into a credible outcome section.

Files:

- `template-parts/sections/gallery-teaser.php`
- create `assets/styles/sections/_gallery-editorial.css`
- `assets/styles/main.css`

Markup shape:

- left: eyebrow `METAMORFOZY`, heading
- right: one or two before/after cases
- labels `PRZED` and `PO` visible on images
- optional arrows only if there are more cases than shown

Data:

- Reuse `gallery_N_before`, `gallery_N_after`, `gallery_N_label`.
- If no pairs exist, hide the visual gallery or show a compact placeholder, but do not create a huge empty section.

Done when:

- Section is substantial and image-led, not a text placeholder.

### Task 6 - Testimonials editorial quotes

**Goal:** replace card reviews with open quote columns.

Files:

- `template-parts/sections/testimonials.php`
- `template-parts/components/card-testimonial.php` only if still reused safely elsewhere
- create `assets/styles/sections/_testimonials-editorial.css`
- `assets/styles/main.css`

Markup shape:

- left: eyebrow `OPINIE`, heading
- right: 3 quote columns
- large quote marks as typography, not decorative blobs
- no rating stars in the homepage concept unless intentionally requested

Data:

- Query latest 3 `testimonial` posts.
- Use ACF `quote` if present, otherwise content.
- Use title/name and treatment.

Done when:

- Reviews no longer appear as boxed cards.

### Task 7 - FAQ split list

**Goal:** keep native FAQ data but match the concept's compact split layout.

Files:

- `template-parts/sections/faq.php`
- create or update `assets/styles/sections/_faq-editorial.css`
- `assets/styles/main.css`
- possibly adjust `components/_accordion.css` only if it remains generic and does not fight homepage styles

Markup shape:

- left: eyebrow `FAQ`, heading
- right: accordion/list with thin horizontal separators
- plus icon on the right

Data:

- Keep `faq` CPT query and JSON-LD.

Done when:

- FAQ is no longer a centered stack of boxed items.

### Task 8 - Contact CTA band

**Goal:** replace map/form contact section on homepage with the compact band from the concept.

Files:

- `template-parts/sections/contact.php`
- create `assets/styles/sections/_contact-cta.css`
- `assets/styles/main.css`
- optionally preserve the full map/form for a separate Contact page later

Markup shape:

- heading `Umow sie na wizyte`
- short text
- phone block
- address block
- primary booking CTA using `sw_get_option( 'booking_url', '#kontakt' )`

Data:

- `clinic_phone`
- `clinic_address`
- `booking_url`
- optional hours

Done when:

- Homepage does not show a large map/form block.
- CTA band matches the concept before the footer.

### Task 9 - Footer tightening

**Goal:** align footer with the concept without changing site architecture unnecessarily.

Files:

- `footer.php`
- `assets/styles/layout/_footer.css`

Requirements:

- dark teal background;
- logo/contact/social column;
- navigation column;
- services column;
- hours column;
- contact column;
- compact legal row.

Done when:

- Footer feels like the concept, not a generic site footer.

### Task 10 - Build and verification

Files:

- `assets/styles/main.min.css` generated via `npm run build:css`

Checks:

- `php -l` for modified PHP files.
- `npm run build:css`.
- Homepage desktop screenshot at 1440/1600 width.
- Homepage mobile screenshot.
- Verify no horizontal overflow.
- Verify no homepage card grid remains in services/doctor/testimonials.
- Verify `blog-teaser` is not rendered on homepage.
- Verify booking CTA links use `booking_url` fallback.

---

## 6. Suggested CSS section files

Add these imports to `assets/styles/main.css` as each section is implemented:

```css
@import 'sections/_services-editorial.css';
@import 'sections/_manifest.css';
@import 'sections/_doctor-feature.css';
@import 'sections/_gallery-editorial.css';
@import 'sections/_testimonials-editorial.css';
@import 'sections/_faq-editorial.css';
@import 'sections/_contact-cta.css';
```

Keep `layout/_grid.css` for shared containers and generic layout only. Homepage section presentation should live in the section files.

---

## 7. Acceptance criteria

The work is complete only when:

1. The homepage order matches section 3 of this document.
2. The first full desktop scroll resembles the generated concept, not the old WordPress theme.
3. Services are a numbered editorial list, not cards.
4. Why-us is an image/text manifest, not a feature grid.
5. Doctor is a standalone dark section, not a card.
6. Metamorphoses show before/after images with labels.
7. Testimonials are editorial quotes, not card boxes.
8. FAQ uses compact separators and fits the concept.
9. Contact is a CTA band, not a map/form section.
10. Blog teaser is absent from the homepage.
11. Footer visually matches the dark concept footer.
12. Mobile layout is stacked, readable and free of overflow.
13. `main.min.css` is regenerated.

---

## 8. Future theme-from-screenshot system

After this project is finished, extract the workflow into a reusable system:

1. Put the screenshot/reference in `docs/references/`.
2. Create `docs/design-spec.md` from the screenshot.
3. Audit current theme into `docs/current-theme-audit.md`.
4. Create a content model that respects the CMS constraints.
5. Create a final implementation plan with:
   - section order;
   - component map;
   - allowed files;
   - data source per section;
   - CSS partial per section;
   - acceptance criteria tied to the screenshot.
6. Implement section by section.
7. Verify with desktop/mobile screenshots before calling it complete.

For this project, do not generalize too early. Finish the homepage first, then turn the process into a reusable theme-building playbook.
