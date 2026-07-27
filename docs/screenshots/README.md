# Screenshoty portfolio

Pliki PNG generowane skryptem `scripts/capture-screenshots.sh`. Linki w głównym README.

## Pliki

| Plik | Widok |
|------|--------|
| `homepage-desktop.png` | Strona główna ~1440px |
| `homepage-mobile.png` | Strona główna ~390px |
| `archive-services.png` | `/oferta/` |
| `single-service.png` | Pojedyncza usługa |
| `page-about.png` | `/o-nas/` |
| `page-team.png` | `/zespol/` |
| `page-contact.png` | `/kontakt/` |
| `page-faq.png` | `/faq/` |
| `mobile-menu.png` | Widok mobile (menu wymaga JS — kopia mobile homepage) |

## Miniatura motywu

`screenshot.png` w root motywu — **1200×900** (Wygląd → Motywy).

## Jak zrobić zrzuty

```bash
# Włącz site w Local, potem:
./scripts/capture-screenshots.sh http://dental-care-concept.local
# albo URL z portem Local, np.:
./scripts/capture-screenshots.sh http://127.0.0.1:10025
```
