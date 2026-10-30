#!/usr/bin/env bash
# Autotrader Search API – cURL example
# Usage: PILOTERR_API_KEY=your-key ./search.sh
set -euo pipefail

curl -sS -G "https://api.piloterr.com/v2/autotrader/search" \
  -H "x-api-key: ${PILOTERR_API_KEY}" \
  --data-urlencode 'query=https://www.autotrader.co.uk/car-search?channel=cars&postcode=W1F%208EB&price_search_type=total&sort=relevance&page=1'
