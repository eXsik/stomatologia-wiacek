#!/usr/bin/env bash
# Capture portfolio screenshots when Local site is running.
# Usage: ./scripts/capture-screenshots.sh [base_url]
# Example: ./scripts/capture-screenshots.sh http://127.0.0.1:10008

set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
BASE_URL="${1:-http://dental-care-concept.local}"
OUT_DIR="$ROOT/docs/screenshots"
CHROMIUM="${CHROMIUM:-chromium}"

if ! command -v "$CHROMIUM" >/dev/null 2>&1; then
	echo "Chromium not found. Set CHROMIUM= path or install chromium."
	exit 1
fi

mkdir -p "$OUT_DIR"

capture() {
	local url="$1"
	local file="$2"
	local width="$3"
	echo "→ $file ($width px) $url"
	"$CHROMIUM" --headless=new --disable-gpu --window-size="${width},900" \
		--screenshot="$OUT_DIR/$file" "$url" 2>/dev/null || {
		echo "Failed to capture $url — is Local running? Try: $BASE_URL in browser first."
		exit 1
	}
}

# Health check
if ! curl -sf --connect-timeout 5 "${BASE_URL}/" >/dev/null; then
	echo "Cannot reach ${BASE_URL}/ — start the site in Local and pass the URL from Local (e.g. http://127.0.0.1:PORT)."
	exit 1
fi

capture "${BASE_URL}/" "homepage-desktop.png" 1440
capture "${BASE_URL}/" "homepage-mobile.png" 390
capture "${BASE_URL}/oferta/" "archive-services.png" 1440
capture "${BASE_URL}/o-nas/" "page-about.png" 1440
capture "${BASE_URL}/zespol/" "page-team.png" 1440
capture "${BASE_URL}/kontakt/" "page-contact.png" 1440
capture "${BASE_URL}/faq/" "page-faq.png" 1440

# Single service — try first known slug or fallback
SERVICE_URL="${BASE_URL}/oferta/stomatologia-dziecieca/"
if ! curl -sf --connect-timeout 3 "$SERVICE_URL" >/dev/null; then
	SERVICE_URL="${BASE_URL}/oferta/"
fi
capture "$SERVICE_URL" "single-service.png" 1440

# Mobile menu requires JS — capture homepage mobile as fallback for menu doc
cp "$OUT_DIR/homepage-mobile.png" "$OUT_DIR/mobile-menu.png"

# WordPress theme thumbnail (1200×900)
if command -v convert >/dev/null 2>&1; then
	convert "$OUT_DIR/homepage-desktop.png" -resize 1200x900^ -gravity center -extent 1200x900 "$ROOT/screenshot.png"
elif command -v magick >/dev/null 2>&1; then
	magick "$OUT_DIR/homepage-desktop.png" -resize 1200x900^ -gravity center -extent 1200x900 "$ROOT/screenshot.png"
else
	python3 -c "
from PIL import Image
img = Image.open('$OUT_DIR/homepage-desktop.png')
img = img.resize((1200, 900), Image.Resampling.LANCZOS)
img.save('$ROOT/screenshot.png')
" 2>/dev/null || cp "$OUT_DIR/homepage-desktop.png" "$ROOT/screenshot.png"
fi

echo "Done. Files in docs/screenshots/ and screenshot.png"
