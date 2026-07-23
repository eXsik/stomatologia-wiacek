# Homepage Design Specification — Stomatologia Wiącek

## 1. Document status

- **Project:** Stomatologia Wiącek
- **Page:** Homepage
- **Status:** Approved visual direction, ready for technical audit
- **Target viewport:** Desktop first, responsive implementation required
- **Implementation:** Classic custom WordPress theme
- **Content system:** WordPress + ACF Free + existing CPTs
- **Visual direction:** Scandinavian Editorial Premium

This document is the source of truth for the homepage redesign. Implementation must not introduce visual patterns that conflict with the rules below.

---

## 2. Design objectives

The homepage should present the clinic as modern, trustworthy and premium without feeling cold, corporate or inaccessible.

The design must:

- feel calm, editorial and intentional;
- use strong typography and generous spacing;
- avoid the appearance of a generic medical template;
- prioritize trust, expertise and real treatment outcomes;
- guide the user toward booking an appointment;
- remain practical to implement and maintain in a classic WordPress theme.

The page should not imitate a SaaS landing page, a beauty salon website or a prebuilt medical template.

---

## 3. Global visual direction

### 3.1 Approved characteristics

- warm, light background;
- dark teal as the primary brand color;
- coral used only for high-priority calls to action;
- large editorial serif headings;
- restrained sans-serif body typography;
- asymmetrical image compositions;
- thin separators and borders;
- minimal use of shadows;
- strong contrast between light editorial sections and one dark featured-doctor section;
- generous whitespace;
- clear vertical rhythm.

### 3.2 Prohibited patterns

Do not use:

- full-width turquoise content blocks;
- icon circles;
- repeated grids of identical cards;
- glassmorphism;
- gradients;
- decorative animations;
- oversized rounded cards;
- excessive border radii;
- heavy drop shadows;
- floating decorative blobs;
- generic medical icons as primary visual elements;
- sliders where static content is sufficient;
- autoplay carousels;
- centered layouts for every section;
- coral as a decorative accent throughout the page.

---

## 4. Global design tokens

The final values may be adjusted slightly during implementation, but the hierarchy and relationships must remain unchanged.

### 4.1 Color palette

```css
--color-bg: #F6F2EA;
--color-bg-alt: #EEE8DE;
--color-surface: #FFFDF8;
--color-text: #123F43;
--color-text-muted: #5F6F6E;
--color-brand: #0D4A4D;
--color-brand-dark: #08383B;
--color-accent: #EF6A57;
--color-border: rgba(18, 63, 67, 0.18);
--color-white: #FFFFFF;
```

Rules:

- `--color-bg` is the default page background.
- `--color-brand` is used for headings, navigation and structural emphasis.
- `--color-accent` is reserved for the primary booking CTA and important interactive states.
- Body copy must not use pure black.
- Borders must remain subtle.
- The dark teal section must use white or warm-white text.

### 4.2 Typography

Recommended pairing:

- **Display / headings:** elegant editorial serif.
- **Body / navigation / labels:** clean modern sans-serif.

Implementation may use locally hosted or properly enqueued web fonts. Avoid decorative, high-contrast fashion fonts that reduce legibility.

Suggested hierarchy:

```text
Display XL: clamp(3.5rem, 5.5vw, 6.75rem)
Display L:  clamp(2.75rem, 4vw, 5rem)
Heading 2:  clamp(2.1rem, 3vw, 3.5rem)
Heading 3:  clamp(1.5rem, 2vw, 2.25rem)
Body L:     1.125rem
Body:       1rem
Small:      0.875rem
Eyebrow:    0.75rem–0.8125rem, uppercase, increased letter spacing
```

Rules:

- Main headings should use serif.
- Navigation, labels, metadata and buttons should use sans-serif.
- Do not use more than two font families.
- Avoid excessive italic text. Italic may emphasize one phrase in a major heading.
- Line length for body text should usually remain between 45 and 70 characters.

### 4.3 Layout

```text
Maximum content width: 1440px
Default content width: 1280px
Narrow text width: 640–760px
Desktop side padding: 48–72px
Tablet side padding: 32px
Mobile side padding: 20px
```

Use CSS Grid for major layouts and Flexbox for smaller alignment patterns.

### 4.4 Spacing

Recommended section spacing:

```text
Desktop section padding: 112–160px
Compact desktop section padding: 72–96px
Tablet section padding: 80–112px
Mobile section padding: 64–88px
```

Spacing should create a strong editorial rhythm. Do not compensate for weak layout with random margins.

### 4.5 Borders and radii

- Standard separator: `1px solid var(--color-border)`.
- Small interface radius: 0–4px.
- Images may use 0–8px radius.
- Avoid pill-shaped containers except where semantically justified.
- Buttons should not appear as oversized rounded pills.

### 4.6 Shadows

Shadows should be absent or almost imperceptible.

Allowed only when necessary:

```css
box-shadow: 0 12px 32px rgba(18, 63, 67, 0.06);
```

Do not use shadows as the primary separation method.

### 4.7 Buttons and links

Primary CTA:

- coral background;
- warm-white text;
- compact rectangular shape;
- visible hover and focus states;
- optional small arrow icon;
- used mainly for “Umów wizytę”.

Secondary CTA:

- text link or subtle outlined button;
- dark teal text;
- underline or arrow treatment;
- no coral background.

Buttons must include clear keyboard focus states.

---

## 5. Page structure

The homepage must contain these sections in this order:

1. Header
2. Editorial hero
3. Trust strip
4. Services
5. Manifest / Why us
6. Featured doctor
7. Before and after
8. Testimonials
9. FAQ
10. Contact CTA
11. Footer

The order must not change without updating this document.

---

## 6. Header

### 6.1 Purpose

Provide brand recognition, direct navigation and an immediate booking path without visually competing with the hero.

### 6.2 Desktop layout

Three-part horizontal layout:

- left: logo;
- center: primary navigation;
- right: telephone link and primary booking CTA.

The header should be visually light and integrated with the warm page background.

### 6.3 Content

Navigation may include:

- O nas
- Usługi
- Zespół
- Metamorfozy
- Opinie
- FAQ
- Kontakt

Do not add unnecessary menu items.

### 6.4 Visual rules

- Header height: approximately 84–104px.
- No heavy bottom shadow.
- Optional thin bottom separator.
- Logo must have adequate clear space.
- Telephone may include a minimal line icon.
- Booking CTA uses coral.
- Navigation uses small sans-serif typography.

### 6.5 Sticky behavior

A sticky header is allowed only if:

- its height becomes more compact;
- it retains clear contrast;
- it does not cover anchor targets;
- the animation is subtle;
- it does not introduce a large shadow.

### 6.6 Mobile behavior

- logo on the left;
- menu toggle on the right;
- booking CTA may remain visible only if space allows;
- navigation opens as an accessible panel;
- menu toggle must expose `aria-expanded`;
- focus must remain usable by keyboard.

### 6.7 Data source

- WordPress registered menu;
- clinic phone from existing clinic settings;
- booking URL from clinic settings or a dedicated ACF field.

---

## 7. Editorial hero

### 7.1 Purpose

Immediately communicate trust, individual care and premium treatment quality.

### 7.2 Desktop layout

Asymmetrical two-column composition:

- left column: headline, description and CTAs;
- right column: large clinic image;
- image should begin close to the upper header rhythm and dominate the right side;
- text area should have generous breathing space.

Recommended ratio:

```text
Text: 42–46%
Image: 54–58%
```

### 7.3 Content hierarchy

1. optional eyebrow;
2. large H1;
3. one emphasized italic phrase inside the H1;
4. short supporting paragraph;
5. primary CTA;
6. secondary CTA.

Suggested message direction:

```text
Stomatologia,
w której czujesz się
zaopiekowany
```

The final copy may differ, but the emotional promise must remain clear and concise.

### 7.4 Visual rules

- H1 must be the strongest typographic element on the page.
- Do not place text on top of the image.
- Do not add decorative background shapes.
- The image should feel architectural, calm and natural.
- Use warm daylight and premium interior photography.
- Avoid generic stock imagery of smiling dentists with crossed arms.

### 7.5 Image requirements

Preferred subject:

- real clinic interior;
- real treatment room;
- natural light;
- neutral materials;
- minimal visual clutter;
- no visible third-party branding.

Recommended aspect ratio: approximately 4:3 or 5:4 on desktop.

### 7.6 Mobile behavior

- text appears first;
- image appears directly below CTAs;
- H1 remains large but must not create isolated one-word lines;
- CTAs may stack;
- image fills container width;
- no horizontal overflow.

### 7.7 Data source

Prefer editable ACF fields:

- hero eyebrow;
- hero heading;
- hero emphasized phrase if technically needed;
- hero description;
- primary CTA label and URL;
- secondary CTA label and URL;
- hero image.

Because ACF Free is used, avoid unnecessarily complex nested field structures.

---

## 8. Trust strip

### 8.1 Purpose

Provide immediate factual reassurance below the hero.

### 8.2 Desktop layout

A horizontal row of four trust statements separated by thin vertical rules.

Possible items:

- years of experience;
- number of patients;
- modern technology;
- individual approach.

### 8.3 Visual rules

- warm light background;
- thin top and bottom separators;
- large serif value or keyword;
- smaller sans-serif label;
- no icons;
- no cards;
- no colored boxes.

### 8.4 Mobile behavior

Use a two-column grid or vertical list.

Do not force all items into one narrow row.

### 8.5 Data source

With ACF Free, use fixed fields rather than a repeater:

```text
trust_1_value
trust_1_label
trust_2_value
trust_2_label
trust_3_value
trust_3_label
trust_4_value
trust_4_label
```

---

## 9. Services section

### 9.1 Purpose

Show treatment scope without using a generic card grid.

### 9.2 Desktop layout

Two-column editorial composition:

- left: section eyebrow, heading, short introduction and optional supporting image;
- right: numbered list of services.

Each service row contains:

- two-digit number;
- service title;
- one-line summary;
- directional arrow or text link.

### 9.3 Service list rules

- one service per horizontal row;
- thin separator between rows;
- large serif number;
- service title in sans-serif or restrained serif;
- short summary;
- no icons;
- no thumbnails inside every row;
- the entire row may be clickable.

### 9.4 Content source

Use the existing `usługi` CPT.

Recommended query behavior:

- show selected or featured services;
- define order through `menu_order` or an existing ordering field;
- limit homepage output to approximately 5–7 services;
- link each item to its single service page.

Do not manually duplicate service content in homepage ACF fields if the CPT already owns that content.

### 9.5 Mobile behavior

- left and right columns stack;
- supporting image may move below the heading or be omitted if it adds no value;
- service number, title and arrow must remain readable;
- summaries may wrap to two lines;
- rows require adequate touch height.

---

## 10. Manifest / Why us

### 10.1 Purpose

Explain the clinic’s philosophy in human language, not as a feature grid.

### 10.2 Desktop layout

Asymmetrical split:

- one side: editorial text block;
- other side: large lifestyle or clinic-context image.

The composition may alternate relative to the services section to maintain rhythm.

### 10.3 Content

Suggested structure:

- eyebrow;
- strong statement such as “Leczymy ludzi, nie tylko zęby”;
- one short paragraph;
- 3–5 concise principles.

Principles should be presented as a restrained text list with minimal checkmarks or short rule marks. Do not turn them into cards.

### 10.4 Image direction

Use:

- real clinic environment;
- consultation context;
- calm reception or patient interaction;
- material and light details connected to the clinic.

Do not use unrelated luxury apartment photography in the final implementation.

### 10.5 Mobile behavior

- text first;
- image below;
- principles remain a simple vertical list;
- avoid tiny two-column text.

### 10.6 Data source

Use fixed ACF fields or page content fields.

Avoid a repeater unless replaced with a fixed set of fields compatible with ACF Free.

---

## 11. Featured doctor

### 11.1 Purpose

Make the expertise and personality of the clinic tangible.

### 11.2 Desktop layout

Full-width dark teal section with an internal multi-column composition:

- left: large portrait;
- center: eyebrow, doctor name, role, short biography and team link;
- right: selected qualifications or trust points.

This is the primary contrast section of the page.

### 11.3 Visual rules

- dark teal background;
- warm-white text;
- portrait should feel professional but natural;
- no white card placed over the section;
- no decorative gradient;
- one vertical separator may divide biography and qualifications;
- qualifications should remain concise.

### 11.4 Content source

Use the existing `zespół` CPT.

Recommended implementation:

- select one featured team member for the homepage;
- use title as the doctor’s name;
- use featured image as portrait;
- use role/specialization ACF field;
- use excerpt or dedicated short biography;
- use fixed qualification fields or a carefully defined text field.

Do not duplicate the entire team profile manually on the homepage.

### 11.5 Mobile behavior

- portrait first;
- biography second;
- qualifications last;
- remove vertical separator and replace with horizontal spacing or border;
- text must not become too small on the dark background.

---

## 12. Before and after

### 12.1 Purpose

Provide concrete visual evidence of treatment outcomes.

### 12.2 Desktop layout

Editorial split:

- left: eyebrow, heading and supporting text;
- right: one prominent before/after case or two carefully spaced cases.

This section should feel more substantial than a row of tiny thumbnails.

### 12.3 Visual rules

- labels “Przed” and “Po” must be clearly visible;
- images should use consistent crop and lighting;
- case presentation should be factual and restrained;
- no sensational transformations;
- no autoplay carousel;
- slider comparison is optional, not required.

### 12.4 Content and compliance

Only use images for which the clinic has valid permission.

Consider adding a short note that results vary depending on the patient and treatment plan.

### 12.5 Data source

Use the existing content structure if a transformation CPT already exists. If not, define a minimal solution during the content-model stage.

Do not introduce a new CPT before the current theme audit confirms it is necessary.

### 12.6 Mobile behavior

- section heading first;
- cases stack vertically;
- before and after images may remain side by side if labels are readable;
- otherwise stack each comparison internally;
- controls must be touch-friendly.

---

## 13. Testimonials

### 13.1 Purpose

Show credible patient trust without relying on generic review cards.

### 13.2 Desktop layout

Editorial section with:

- left column: eyebrow and heading;
- right area: 2–3 visible testimonial excerpts in an open layout.

Testimonials may be separated by spacing and quotation marks rather than boxes.

### 13.3 Visual rules

- no large card backgrounds;
- no star icons unless based on real review data;
- no fake avatars;
- quotation mark can be used as a restrained typographic element;
- patient name or approved identifier appears below the text;
- keep excerpts concise.

### 13.4 Content source

Use the existing `opinie` CPT.

Homepage query should:

- display approved testimonials;
- limit output;
- use a defined order;
- avoid exposing private patient data.

### 13.5 Interaction

A carousel is not the default solution.

If there are more testimonials, provide a clear link to the testimonials section or page.

### 13.6 Mobile behavior

Stack testimonials vertically.

Do not hide important testimonials behind mandatory swiping.

---

## 14. FAQ

### 14.1 Purpose

Resolve common objections and reduce friction before contact.

### 14.2 Desktop layout

Two-column structure:

- left: eyebrow and section heading;
- right: accordion list.

### 14.3 Accordion rules

- each item separated by a thin line;
- question is a real button element;
- plus/minus indicator;
- only necessary motion;
- content uses semantic HTML;
- keyboard interaction must work;
- `aria-expanded` and controlled region relationship required.

### 14.4 Content source

Use the existing `FAQ` CPT.

Each item:

- title = question;
- content or dedicated field = answer;
- defined ordering;
- limited number displayed on homepage.

### 14.5 Mobile behavior

Stack heading above accordion.

Questions require sufficient touch height and readable line spacing.

---

## 15. Contact CTA

### 15.1 Purpose

Provide a direct final conversion point before the footer.

### 15.2 Desktop layout

A wide, structured band containing:

- short booking headline;
- telephone;
- opening hours;
- address;
- primary booking CTA.

Items may be divided by thin vertical separators.

### 15.3 Visual rules

- remain visually lighter than the featured-doctor section;
- CTA uses coral;
- contact data uses dark teal;
- minimal line icons are allowed;
- no contact cards;
- no embedded map in this band.

### 15.4 Data source

Use existing clinic settings:

- phone;
- address;
- opening hours;
- booking URL.

Do not hardcode the same data in multiple templates.

### 15.5 Mobile behavior

Stack all contact elements.

Telephone and booking action should be easy to tap.

---

## 16. Footer

### 16.1 Purpose

Close the page with practical navigation and clinic information.

### 16.2 Desktop layout

Dark teal footer with multiple restrained columns:

- logo and social links;
- navigation;
- services;
- opening hours;
- contact details.

A narrow legal row appears at the bottom.

### 16.3 Visual rules

- no gradient;
- no large decorative graphics;
- use subtle separators;
- text contrast must meet accessibility requirements;
- link hover state should be visible;
- coral should not dominate the footer.

### 16.4 Data source

- WordPress footer menu;
- selected service links;
- clinic settings;
- social links;
- copyright year generated dynamically;
- privacy policy link.

### 16.5 Mobile behavior

Columns stack.

Optional accordion behavior may be used only if implemented accessibly and if the footer becomes excessively long.

---

## 17. Responsive requirements

### 17.1 Breakpoint strategy

Use content-driven breakpoints rather than device-specific assumptions.

Indicative breakpoints:

```text
Small mobile: below 480px
Mobile/tablet: below 768px
Tablet/small desktop: below 1024px
Desktop: 1024px and above
Wide desktop: 1440px and above
```

### 17.2 Required behavior

- no horizontal scrolling;
- no text overlap;
- no image distortion;
- navigation remains accessible;
- touch targets should be at least approximately 44px;
- typography scales using `clamp()` where useful;
- section spacing reduces consistently;
- columns stack in a meaningful content order;
- important CTA remains visible without becoming sticky by default.

---

## 18. Accessibility requirements

Implementation must include:

- one H1 only;
- logical heading order;
- semantic landmarks;
- visible keyboard focus;
- accessible navigation toggle;
- accessible FAQ accordion;
- meaningful image alternative text;
- empty alt text for purely decorative images;
- sufficient color contrast;
- no information communicated by color alone;
- reduced-motion support for any optional transitions;
- descriptive link labels;
- no placeholder-only form labels.

Target: practical WCAG 2.2 AA compliance.

---

## 19. Performance requirements

- use responsive WordPress images;
- define image dimensions to reduce layout shift;
- use modern image formats where supported;
- lazy-load below-the-fold imagery;
- do not lazy-load the primary hero image if it is the likely LCP element;
- avoid heavy JavaScript libraries;
- avoid carousel dependencies unless justified;
- use a minimal font weight set;
- preload only truly critical assets;
- keep animation and interaction code small.

The design must not sacrifice performance for decorative effects.

---

## 20. WordPress and ACF constraints

### 20.1 Platform constraints

- classic custom WordPress theme;
- no Elementor;
- no page builder;
- ACF Free;
- existing CPTs should remain the primary content source;
- no new plugin dependency without approval.

### 20.2 Existing CPT ownership

```text
Services section       → usługi CPT
Featured doctor        → zespół CPT
Testimonials           → opinie CPT
FAQ                    → FAQ CPT
```

### 20.3 ACF Free implications

Do not design the content model around:

- repeater fields;
- flexible content;
- options pages requiring ACF Pro.

Use:

- fixed field groups;
- post relationships if available and justified;
- page-level fields;
- existing clinic settings implementation;
- fixed numbered trust or principle fields where necessary.

Final field names must be defined in `docs/content-model.md` after the current theme audit.

---

## 21. Implementation constraints

The implementation must:

- preserve the approved section order;
- avoid redesigning unrelated templates;
- reuse existing theme utilities where suitable;
- avoid large uncontrolled CSS patches;
- use reusable section-level classes and tokens;
- keep template logic separate from presentation where practical;
- not hardcode CPT content into `front-page.php`;
- not implement all sections in one uncontrolled change;
- be delivered in phases defined in `docs/implementation-plan.md`.

---

## 22. Acceptance criteria

The homepage redesign is accepted only if:

1. The page clearly reflects the Scandinavian Editorial Premium direction.
2. The hero no longer resembles a generic medical template.
3. Services are presented as a numbered editorial list, not cards.
4. Coral is limited to important calls to action.
5. The page uses warm backgrounds and dark teal consistently.
6. The featured doctor section creates deliberate contrast.
7. Before/after content is visually prominent and credible.
8. Testimonials do not use a generic card grid.
9. FAQ is accessible and keyboard-operable.
10. Contact information is editable and not duplicated unnecessarily.
11. The page works across desktop, tablet and mobile.
12. No unapproved plugin or dependency is introduced.
13. No ACF Pro-only feature is required.
14. Performance and accessibility requirements are respected.
15. Implementation matches this specification closely enough that differences are deliberate and documented.

---

## 23. Items requiring confirmation after theme audit

The following must be confirmed before implementation:

- current homepage template structure;
- existing CSS architecture;
- existing design token or variable system;
- current ACF field groups;
- current clinic settings storage;
- how homepage services are selected and ordered;
- whether a before/after data structure already exists;
- how the featured team member is selected;
- available photography and image permissions;
- current menu registrations;
- current responsive navigation behavior;
- any existing accessibility or JavaScript utilities.

No implementation plan should assume answers to these questions before the audit.
