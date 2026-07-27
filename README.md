# Stomatologia Wiącek — koncepcja redesignu (projekt portfolio)

**Repozytorium:** [github.com/eXsik/stomatologia-wiacek](https://github.com/eXsik/stomatologia-wiacek)

**To nieoficjalna, niekomercyjna koncepcja redesignu** przygotowana jako element portfolio
pod aplikacje na stanowisko Front-End Developer / WordPress. Projekt nie jest powiązany
z rzeczywistym gabinetem Stomatologia Wiącek. Treści są demonstracyjne / placeholderowe,
o ile nie zaznaczono inaczej.

## Podgląd (screenshoty)

Brak publicznego live demo — podgląd przez GitHub i zrzuty poniżej. Uruchomienie lokalne: [Instalacja](#instalacja).

| Widok | Screenshot |
|-------|------------|
| Homepage (desktop) | [`docs/screenshots/homepage-desktop.png`](docs/screenshots/homepage-desktop.png) |
| Homepage (mobile) | [`docs/screenshots/homepage-mobile.png`](docs/screenshots/homepage-mobile.png) |
| Archiwum usług | [`docs/screenshots/archive-services.png`](docs/screenshots/archive-services.png) |
| Pojedyncza usługa | [`docs/screenshots/single-service.png`](docs/screenshots/single-service.png) |
| O nas | [`docs/screenshots/page-about.png`](docs/screenshots/page-about.png) |
| Zespół | [`docs/screenshots/page-team.png`](docs/screenshots/page-team.png) |
| Kontakt | [`docs/screenshots/page-contact.png`](docs/screenshots/page-contact.png) |
| FAQ | [`docs/screenshots/page-faq.png`](docs/screenshots/page-faq.png) |

Miniatura motywu w panelu WP: `screenshot.png` (Wygląd → Motywy).

## Co pokazuje ten projekt

- **Rozwój motywu WordPress:** własne typy treści (CPT), pola ACF Free, hierarchia szablonów, panel **Dane gabinetu**
- **Front-end:** ręczny system CSS (BEM, tokeny, mobile-first), vanilla JS bez jQuery/frameworka, dostępność
- **SEO:** własne meta/OG, JSON-LD (Dentist, FAQPage, BreadcrumbList), semantyczny HTML, breadcrumbs
- **Wydajność:** lazy/eager LCP, defer JS, self-hosted fonty, pipeline PostCSS + esbuild

**Świadomie poza zakresem:** WooCommerce / e-commerce — to koncepcja strony gabinetu, nie sklepu.

Więcej: [`docs/architecture.md`](docs/architecture.md) (mapa kodu) oraz [`docs/portfolio-case-study.md`](docs/portfolio-case-study.md) (case study).

## Wymagania

- WordPress 6.4+
- PHP 8.0+
- Advanced Custom Fields (**Free**) — opcjonalnie, ale zalecane. Bez ACF motyw działa; sekcje homepage mają fallbacki demo.

## Instalacja

1. Skopiuj folder motywu do `wp-content/themes/`.
2. Aktywuj **Stomatologia Wiacek – Redesign Concept** (Wygląd → Motywy).
3. Zainstaluj i włącz **Advanced Custom Fields** (wystarczy Free).
4. Uzupełnij **Dane gabinetu** (własne menu w adminie): telefon, adres, godziny, social, mapa — jedno źródło prawdy dla headera, stopki, kontaktu i JSON-LD.
5. Dodaj treści: **Usługi**, **Zespół**, **Opinie**, **FAQ**.
6. Ustaw stronę główną (Ustawienia → Czytanie). Szablon `front-page.php` działa automatycznie.
7. Motyw może sam utworzyć podstrony: `/o-nas/`, `/zespol/`, `/metamorfozy/`, `/faq/`, `/kontakt/` (z odpowiednimi szablonami).
8. (Opcjonalnie) Ustaw stronę wpisów pod `/aktualnosci/`.

### Local by Flywheel

Utwórz site w Local, skopiuj motyw do `wp-content/themes/` i otwórz URL z Local (np. `http://dental-care-concept.local`).

## Treści z panelu WordPress

| Treść | Gdzie edytować |
|-------|----------------|
| NAP, godziny, mapa, booking URL | **Dane gabinetu** |
| Hero i sekcje homepage | ACF na stronie głównej |
| Usługi / zespół / FAQ / opinie | CPT w menu bocznym |
| Tytuły i leady podstron | Strony → zajawka / treść |
| Menu | Wygląd → Menu |

Część copy w hero (eyebrow, notki w panelu bocznym) ma sensowne **domyślne teksty w kodzie** — na potrzeby portfolio. W produkcji łatwo przenieść je do ACF.

## ACF (Free)

Grupy pól są w `inc/acf-fields.php` (czytelne w code review). Tylko typy z ACF Free — bez Repeater, Relationship i Options Page. Wielowierszowe sloty homepage (trust, why-us, gallery) to pola o stałej liczbie, składane helperami.

## Build produkcyjny

```bash
npm install
npm run build
```

Źródła: `assets/styles/main.css`, `assets/scripts/main.js`.  
Produkcja: `main.min.css` / `main.min.js` (gdy `WP_DEBUG` jest `false`).

### Screenshoty portfolio

Przy działającym Local:

```bash
./scripts/capture-screenshots.sh http://dental-care-concept.local
```

## Świadomie poza zakresem

- Sync Google Reviews API — opinie z CPT / ręcznie
- Pełny widget rezerwacji (Booksy itd.) — demo modal + tap-to-call
- Konfiguracja cache / object cache
- Docelowa fotografia gabinetu (placeholdery)
- Pipeline WebP/AVIF
- WooCommerce

## Dokumentacja

| Plik | Opis |
|------|------|
| `docs/architecture.md` | Aktualna mapa architektury / kodu |
| `docs/homepage-design-spec.md` | Brief designu homepage (historyczny) |
| `docs/portfolio-case-study.md` | Krótki case study |
| `docs/application-meetco.md` | Szablon treści aplikacji |
| `docs/screenshots/` | Zrzuty ekranu |
