# Phase 1 Content Model

**Project:** Stomatologia Wiącek  
**Related docs:** `docs/homepage-design-spec.md`, `docs/current-theme-audit.md`  
**Status:** Approved for Phase 1 implementation  
**Constraint:** ACF Free only — no Repeater, Flexible Content, Relationship, or ACF Options Page

This document defines the content model for Phase 1 only. It does not contain implementation code.

---

## 1. Scope

### Included

- Global clinic setting `booking_url`
- Header booking CTA (`header.php`)
- Mobile navigation booking CTA (`template-parts/layout/nav-mobile.php`)
- Editorial hero fields and CTA URL priority (`template-parts/sections/hero.php`, `inc/acf-fields.php`)
- Trust strip fixed text slots (`trust_N_value` / `trust_N_label`, `sw_get_trust_stats()`)

### Explicitly excluded

Later homepage sections and their fields remain unchanged and are **out of scope**:

- Services, why-us, featured doctor, gallery / before-after, testimonials, FAQ, contact section, footer, blog teaser, sticky CTA redesign
- CPT registration and CPT field groups
- Removal of unused `trust_N_icon` fields
- New helpers beyond existing `sw_get_option()` / `sw_get_trust_stats()` / `sw_image()`

---

## 2. Global clinic setting

| Property | Value |
|---|---|
| Key | `booking_url` |
| Storage | WordPress option `sw_clinic` |
| Implementation file | `inc/clinic-settings.php` |
| Admin UI | Dane gabinetu (`sw_register_clinic_settings_page()`) |
| Field type | URL input |
| Sanitize on save | `esc_url_raw` (via `sw_sanitize_clinic_options()`) |
| Default / empty fallback | `#kontakt` |
| Read API | `sw_get_option( 'booking_url', '#kontakt' )` in `inc/helpers.php` |

### Phase 1 consumers

- `header.php` — primary booking button
- `template-parts/layout/nav-mobile.php` — mobile booking CTA
- `template-parts/sections/hero.php` — primary CTA URL when `hero_cta_primary_link` is empty

Header and mobile booking CTAs **always** use `sw_get_option( 'booking_url', '#kontakt' )`.

The future contact CTA band must use the same global source. That section is **not** part of Phase 1.

No dedicated booking helper is introduced; templates call `sw_get_option()` directly.

---

## 3. Hero fields

Registered in `inc/acf-fields.php` on group `group_front_page` (location: `page_type == front_page`). Consumed by `template-parts/sections/hero.php`.

### 3.1 New fields

| Field | Type | Purpose | Example | Required | Escape | Fallback |
|---|---|---|---|---|---|---|
| `hero_eyebrow` | text | Optional label above H1 | `Stomatologia rodzinna i estetyczna` | Optional | `esc_html()` | Omit if empty |
| `hero_heading_before` | text | H1 segment before emphasis | `Stomatologia,` | Optional* | `esc_html()` | See §3.2 |
| `hero_heading_emphasis` | text | Emphasized H1 phrase (italic via template CSS/markup) | `w której czujesz się` | Optional* | `esc_html()` | See §3.2 |
| `hero_heading_after` | text | H1 segment after emphasis | `zaopiekowany` | Optional* | `esc_html()` | See §3.2 |

\*Optional individually; together they form the preferred H1 when any split field has content.

**Rules**

- All four new heading-related fields are ACF **text** fields (not textarea, not WYSIWYG).
- No HTML is stored in any heading field.
- Output is always `esc_html()`.
- Visual emphasis for `hero_heading_emphasis` is applied by the template (e.g. `<em>` or a class), never by editor-entered tags.
- `hero_headline` remains registered and readable as a temporary backwards-compatible fallback.

### 3.2 Heading fallback priority

1. If **at least one** of `hero_heading_before`, `hero_heading_emphasis`, `hero_heading_after` contains content → render the split H1; omit empty segments (no empty visual lines).
2. If **all** split heading fields are empty → use existing `hero_headline`.
3. If `hero_headline` is also empty → use the existing PHP demo fallback in `hero.php` (`Stomatologia, której możesz zaufać.`).

`hero_eyebrow` is independent: shown when set, omitted when empty. It does not participate in the H1 fallback chain.

### 3.3 Existing hero fields (unchanged)

| Field | Type | Notes |
|---|---|---|
| `hero_headline` | text | Temporary fallback only; keep registered |
| `hero_subheadline` | textarea | Supporting copy; current PHP demo fallback retained |
| `hero_media` | image (return `id`) | Rendered with `sw_image( …, 'sw-hero', true, … )` when set; text-only layout when empty |
| `hero_cta_primary_label` | text | Default / fallback: `Umów wizytę` |
| `hero_cta_primary_link` | url | See CTA priority below |
| `hero_cta_secondary_label` | text | Default / fallback: `Poznaj ofertę` (current template) |
| `hero_cta_secondary_link` | url | Fallback: `#oferta` |

### 3.4 CTA URL priority

**Primary hero CTA** (`hero.php`):

1. `hero_cta_primary_link` if populated
2. `sw_get_option( 'booking_url', '#kontakt' )`
3. `#kontakt` (implicit via booking_url fallback)

**Header and mobile booking CTAs:** always `sw_get_option( 'booking_url', '#kontakt' )` — they do not read `hero_cta_primary_link`.

**Secondary hero CTA:** unchanged — `hero_cta_secondary_link` with existing `#oferta` fallback.

---

## 4. Trust strip fields

Fixed ACF Free slots on `group_front_page` (no Repeater). Assembled by `sw_get_trust_stats()` in `inc/helpers.php`. Rendered by `template-parts/sections/trust-bar.php`.

### Rendered in Phase 1

| Field | Type | Purpose |
|---|---|---|
| `trust_1_value` … `trust_4_value` | text | Large value / keyword |
| `trust_1_label` … `trust_4_label` | text | Supporting label |

### Unrendered (retained)

| Field | Type | Phase 1 rule |
|---|---|---|
| `trust_1_icon` … `trust_4_icon` | select | Still registered and still collected by `sw_get_trust_stats()`; **not rendered**; **not removed** |

### Behaviour

- Four-slot model stays for Phase 1.
- `sw_get_trust_stats()` remains the template data source.
- Slots with empty `trust_N_value` are skipped (not rendered).
- Existing demo fallback in `trust-bar.php` when `sw_get_trust_stats()` returns no rows remains unless implementation review proves incorrect output.
- Output uses `esc_html()` for value and label.

---

## 5. Data ownership

| Content item | Owner / source | Storage | Read path | Fallback |
|---|---|---|---|---|
| Booking URL | Clinic settings | `sw_clinic['booking_url']` | `sw_get_option( 'booking_url', '#kontakt' )` | `#kontakt` |
| Hero eyebrow | Front page ACF | `hero_eyebrow` | `get_field( 'hero_eyebrow' )` in `hero.php` | Omit |
| Hero heading | Front page ACF | Split fields, then `hero_headline` | `hero.php` per §3.2 | PHP demo string |
| Hero supporting copy | Front page ACF | `hero_subheadline` | `get_field( 'hero_subheadline' )` | Existing demo paragraph |
| Hero media | Front page ACF | `hero_media` (attachment ID) | `get_field` + `sw_image()` | No media column |
| Hero primary CTA label | Front page ACF | `hero_cta_primary_label` | `get_field` | `Umów wizytę` |
| Hero primary CTA URL | ACF, then clinic | `hero_cta_primary_link` → `booking_url` | §3.4 | `#kontakt` |
| Hero secondary CTA | Front page ACF | `hero_cta_secondary_label` / `_link` | `get_field` | Label + `#oferta` |
| Trust values / labels | Front page ACF | `trust_N_value` / `trust_N_label` | `sw_get_trust_stats()` → `trust-bar.php` | Demo array if no rows |

---

## 6. Validation and escaping rules

- **URLs saved:** `esc_url_raw` (`booking_url` in `sw_sanitize_clinic_options()`; ACF url fields follow ACF save behaviour).
- **URLs output:** `esc_url()`.
- **Text fields:** sanitized by WordPress / ACF on save; output with `esc_html()`.
- **Textarea** (`hero_subheadline`): output with `esc_html()` (plain text, no HTML).
- **Images:** `sw_image()` / `wp_get_attachment_image()` with existing attributes.
- **No raw HTML** from ACF heading or eyebrow fields.
- **No new helper** for `booking_url`.

---

## 7. Backwards compatibility

- `hero_headline` stays registered in `inc/acf-fields.php` and readable by `hero.php`.
- Existing front-page content continues to render until editors fill the split heading fields.
- No database migration: new ACF fields and `booking_url` are additive.
- Empty `booking_url` resolves to `#kontakt` via `sw_get_option()`.
- Trust `value` / `label` fields and `sw_get_trust_stats()` behaviour stay as today.
- `trust_N_icon` values may remain in post meta; they are unused in the UI for Phase 1.

---

## 8. Phase 1 acceptance criteria

1. `booking_url` is editable under Dane gabinetu and stored in `sw_clinic`.
2. Header and mobile booking CTAs use `sw_get_option( 'booking_url', '#kontakt' )`.
3. Hero primary CTA follows: `hero_cta_primary_link` → `booking_url` → `#kontakt`.
4. Split H1 renders from plain-text fields; emphasis markup is template-controlled only.
5. When split heading fields are empty, `hero_headline` (then PHP demo) still works.
6. Trust strip uses existing four text slots via `sw_get_trust_stats()`; icons are not shown.
7. No ACF Pro feature is introduced.
8. No later-section content model (services, why-us, doctor, gallery, testimonials, FAQ, contact, footer, blog, sticky CTA) is changed.
