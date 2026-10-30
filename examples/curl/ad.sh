#!/usr/bin/env bash
# Autotrader Ad API – cURL example
# Usage: PILOTERR_API_KEY=your-key ./ad.sh
set -euo pipefail

curl -sS -G "https://api.piloterr.com/v2/autotrader/ad" \
  -H "x-api-key: ${PILOTERR_API_KEY}" \
  --data-urlencode query=https://www.autotrader.co.uk/car-details/202606053030491
