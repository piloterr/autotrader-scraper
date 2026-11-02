<p align="center">
  <a href="https://www.piloterr.com"><img src="images/banner.png" alt="Autotrader Scraper API by Piloterr – scrape Autotrader data as JSON" width="100%"></a>
</p>

# Autotrader Scraper API

[![Discord](https://img.shields.io/badge/Discord-Join%20the%20community-5865F2?logo=discord&logoColor=white)](https://discord.gg/CFj3ph8aHU) [![Get API key](https://img.shields.io/badge/Piloterr-Get%20a%20free%20API%20key-111827)](https://app.piloterr.com) [![API docs](https://img.shields.io/badge/Docs-OpenAPI-0EA5E9)](https://app.piloterr.com/openapi) [![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

The **Piloterr Autotrader Scraper API** lets you extract public data from Autotrader as **clean, structured JSON** — no proxies, headless browsers or HTML parsing to maintain. Endpoints available in production:

- **Autotrader Ad API** — Extract full vehicle details from an AutoTrader UK car-details URL, including price, specs, gallery, seller, and description via browser rendering.
- **Autotrader Search API** — Search AutoTrader UK listings from a car-search URL and retrieve prices, specs, photos, seller info, and pagination via browser rendering.

Use it for listing monitoring, price benchmarks, stock sourcing or market analytics on second-hand and vehicle marketplaces.

| Endpoint | Path | Credits | What you get |
|---|---|---|---|
| [Autotrader Ad API](#autotrader-ad-api) | `/v2/autotrader/ad` | 2 | Extract full vehicle details from an AutoTrader UK car-details URL, including price, specs, gallery, seller, and description via browser rendering. |
| [Autotrader Search API](#autotrader-search-api) | `/v2/autotrader/search` | 2 | Search AutoTrader UK listings from a car-search URL and retrieve prices, specs, photos, seller info, and pagination via browser rendering. |

## Table of contents

- [How it works](#how-it-works)
- [Autotrader Ad API](#autotrader-ad-api)
- [Autotrader Search API](#autotrader-search-api)
- [Code examples in other languages](#code-examples-in-other-languages)
- [Practical use cases](#practical-use-cases)
- [Why Piloterr?](#why-piloterr)
- [FAQ](#faq)
- [Related scrapers](#related-scrapers)
- [Support](#support)

## How it works

1. **Create a free Piloterr account** and copy your API key from the [dashboard](https://app.piloterr.com).
2. **Send a `GET` (or `POST`) request** to `https://api.piloterr.com/v2/...` with the header `x-api-key: YOUR_API_KEY`.
3. **Receive structured JSON** — Piloterr handles rendering, proxies, retries and parsing.

```bash
export PILOTERR_API_KEY="your-api-key"
pip install requests        # Python
# TypeScript: Node.js 18+ (native fetch), run with `npx tsx file.ts`
```

> Every endpoint accepts both `GET` (query string) and `POST` (JSON body with the same fields).

## Autotrader Ad API

Extract full vehicle details from an AutoTrader UK car-details URL, including price, specs, gallery, seller, and description via browser rendering.

`GET | POST https://api.piloterr.com/v2/autotrader/ad` · **2 credits per request** · [Full reference](https://app.piloterr.com/openapi)

### Request parameters

| Parameter | Type | Required | Description |
|---|---|---|---|
| `query` | string | ✅ | Full AutoTrader UK car details URL. |

### Python example

```python
import json
import os
import requests

response = requests.get(
    "https://api.piloterr.com/v2/autotrader/ad",
    headers={"x-api-key": os.environ["PILOTERR_API_KEY"]},
    params={
        "query": "https://www.autotrader.co.uk/car-details/202606053030491",
    },
    timeout=120,
)
response.raise_for_status()
data = response.json()

print(json.dumps(data, indent=2, ensure_ascii=False)[:2000])
```

### TypeScript example

```typescript
type AutotraderAd = {
  id?: string;
  url?: string;
  image?: string;
  price?: string;
  title?: string;
  images?: string[];
  seller?: {
    name?: string;
    type?: string;
    phone?: string;
    rating?: number;
    location?: string;
  };
  subtitle?: unknown;
  description?: string;
  price_amount?: number;
  specifications?: {
    doors?: string;
    seats?: string;
    engine?: string;
    gearbox?: string;
    mileage?: string;
    body_type?: string;
    fuel_type?: string;
    body_colour?: string;
    registration?: string;
    emission_class?: string;
  };
  reserve_available?: boolean;
};

const params = new URLSearchParams({
  "query": "https://www.autotrader.co.uk/car-details/202606053030491",
});

const response = await fetch(`https://api.piloterr.com/v2/autotrader/ad?${params}`, {
  headers: { "x-api-key": process.env.PILOTERR_API_KEY! },
});
if (!response.ok) throw new Error(`Piloterr error ${response.status}: ${await response.text()}`);

const data = (await response.json()) as AutotraderAd;

console.log(JSON.stringify(data, null, 2).slice(0, 2000));
```

<details>
<summary><b>POST variant</b></summary>

```http
POST https://api.piloterr.com/v2/autotrader/ad
x-api-key: YOUR_API_KEY
Content-Type: application/json

{"query": "https://www.autotrader.co.uk/car-details/202606053030491"}
```
</details>

### Output example

Example response from the API reference, abridged — real values depend on the page you scrape.

```json
{
  "id": "202606053030491",
  "url": "https://www.autotrader.co.uk/car-details/202606053030491",
  "image": "https://m.atcdn.co.uk/a/media/w800/ed2eccf887a74d7b99442845d25c21ce.jpg",
  "price": "£2,499",
  "title": "2011 Vauxhall Astra",
  "images": [
    "https://m.atcdn.co.uk/a/media/w800/ed2eccf887a74d7b99442845d25c21ce.jpg",
    "https://m.atcdn.co.uk/a/media/w600/d0da32981b3e414e9cc118f4002bc0a2.jpg"
  ],
  "seller": {
    "name": "example",
    "type": "example",
    "phone": "example",
    "rating": 0,
    "location": "example"
  },
  "subtitle": null,
  "description": "Example Motors present this Beautiful Vauxhall  Astra 1.4L petrol !!! A GREAT SPEC CAR with Low miles and ONLY 2 OWNERS FROM NEW !! Drive…",
  "price_amount": 2499,
  "specifications": {
    "doors": "5",
    "seats": "5",
    "engine": "1.4L",
    "gearbox": "Manual",
    "mileage": "59,000 miles",
    "body_type": "Hatchback",
    "fuel_type": "Petrol",
    "body_colour": "Silver",
    "registration": "2011 (11 reg)",
    "emission_class": "Euro 5"
  },
  "reserve_available": false
}
```

### Response fields

| Field | Type | Description |
|---|---|---|
| `id` | string |  |
| `url` | string |  |
| `image` | string |  |
| `price` | string |  |
| `title` | string |  |
| `images` | string[] |  |
| `seller` | object |  |
| `seller.name` | string |  |
| `seller.type` | string |  |
| `seller.phone` | string |  |
| `seller.rating` | number |  |
| `seller.location` | string |  |
| `subtitle` | object |  |
| `description` | string |  |
| `price_amount` | integer |  |
| `specifications` | object |  |
| `specifications.doors` | string |  |
| `specifications.seats` | string |  |
| `specifications.engine` | string |  |
| `specifications.gearbox` | string |  |
| `specifications.mileage` | string |  |
| `specifications.body_type` | string |  |
| `specifications.fuel_type` | string |  |
| `specifications.body_colour` | string |  |
| `specifications.registration` | string |  |

## Autotrader Search API

Search AutoTrader UK listings from a car-search URL and retrieve prices, specs, photos, seller info, and pagination via browser rendering.

`GET | POST https://api.piloterr.com/v2/autotrader/search` · **2 credits per request** · [Full reference](https://app.piloterr.com/openapi)

### Request parameters

| Parameter | Type | Required | Description |
|---|---|---|---|
| `query` | string | ✅ | Full AutoTrader UK car search URL. |

### Python example

```python
import json
import os
import requests

response = requests.get(
    "https://api.piloterr.com/v2/autotrader/search",
    headers={"x-api-key": os.environ["PILOTERR_API_KEY"]},
    params={
        "query": "https://www.autotrader.co.uk/car-search?channel=cars&postcode=W1F%208EB&price_search_type=total&sort=relevance&page=1",
    },
    timeout=120,
)
response.raise_for_status()
data = response.json()

print(json.dumps(data, indent=2, ensure_ascii=False)[:2000])
```

### TypeScript example

```typescript
type AutotraderSearch = {
  results?: {
    id?: string;
    url?: string;
    year?: string;
    image?: string;
    price?: string;
    title?: string;
    images?: string[];
    mileage?: string;
    location?: string;
    subtitle?: string;
    seller_type?: string;
    price_amount?: number;
    attention_grabber?: string;
  }[];
  pagination?: {
    next?: number;
    current?: number;
    next_url?: string;
    per_page?: number;
    total_count?: number;
    total_pages?: number;
    has_next_page?: boolean;
  };
};

const params = new URLSearchParams({
  "query": "https://www.autotrader.co.uk/car-search?channel=cars&postcode=W1F%208EB&price_search_type=total&sort=relevance&page=1",
});

const response = await fetch(`https://api.piloterr.com/v2/autotrader/search?${params}`, {
  headers: { "x-api-key": process.env.PILOTERR_API_KEY! },
});
if (!response.ok) throw new Error(`Piloterr error ${response.status}: ${await response.text()}`);

const data = (await response.json()) as AutotraderSearch;

console.log(JSON.stringify(data, null, 2).slice(0, 2000));
```

<details>
<summary><b>POST variant</b></summary>

```http
POST https://api.piloterr.com/v2/autotrader/search
x-api-key: YOUR_API_KEY
Content-Type: application/json

{"query": "https://www.autotrader.co.uk/car-search?channel=cars&postcode=W1F%208EB&price_search_type=total&sort=relevance&page=1"}
```
</details>

### Output example

Example response from the API reference, abridged — real values depend on the page you scrape.

```json
{
  "results": [
    {
      "id": "202605302836426",
      "url": "https://www.autotrader.co.uk/car-details/202605302836426?journey=FEATURED_LISTING_JOURNEY&sort=relevance&twcs=true&searchId=3e386cc3-ab04…",
      "year": "2007 (07 reg)",
      "image": "https://m.atcdn.co.uk/a/media/w480/a75ac2d47f854a5ebaf070a25c3fe883.jpg",
      "price": "£2,500",
      "title": "Ford Focus1.8 Sport S 5dr",
      "images": [
        "https://m.atcdn.co.uk/a/media/w480/a75ac2d47f854a5ebaf070a25c3fe883.jpg",
        "https://m.atcdn.co.uk/a/media/w480/5f16246bee0e45d68ea4af8ee80b0d41.jpg"
      ],
      "mileage": "93,018 miles",
      "location": "Leicester",
      "subtitle": "1.8 Sport S 5dr",
      "seller_type": "dealer",
      "price_amount": 2500,
      "attention_grabber": "FULL SERVICE HISTORY+2 KEYS!!!"
    },
    {
      "id": "202606053041984",
      "url": "https://www.autotrader.co.uk/car-details/202606053041984?sort=relevance&twcs=true&searchId=3e386cc3-ab04-4465-bc96-dc0210e1801f&page=1&po…",
      "year": "2014 (14 reg)",
      "image": "https://m.atcdn.co.uk/a/media/w480/27178641a4bc471ebd9a6ea3d1d388fe.jpg",
      "price": "£3,795",
      "title": "Toyota Prius1.5 CVT 4dr",
      "images": [
        "https://m.atcdn.co.uk/a/media/w480/27178641a4bc471ebd9a6ea3d1d388fe.jpg",
        "https://m.atcdn.co.uk/a/media/w480/8834d446806d446c826019ae2ad60870.jpg"
      ],
      "mileage": "82,000 miles",
      "location": "Sidcup",
      "subtitle": "1.5 CVT 4dr",
      "seller_type": "dealer",
      "price_amount": 3795,
      "attention_grabber": "LOW MILEAGE|CHEAP INSURANCE"
    }
  ],
  "pagination": {
    "next": 2,
    "current": 1,
    "next_url": "https://www.autotrader.co.uk/car-search?page=2",
    "per_page": 25,
    "total_count": 464626,
    "total_pages": 18586,
    "has_next_page": true
  }
}
```

### Response fields

| Field | Type | Description |
|---|---|---|
| `results[]` | object[] |  |
| `results[].id` | string |  |
| `results[].url` | string |  |
| `results[].year` | string |  |
| `results[].image` | string |  |
| `results[].price` | string |  |
| `results[].title` | string |  |
| `results[].images` | string[] |  |
| `results[].mileage` | string |  |
| `results[].location` | string |  |
| `results[].subtitle` | string |  |
| `results[].seller_type` | string |  |
| `results[].price_amount` | integer |  |
| `results[].attention_grabber` | string |  |
| `pagination` | object |  |
| `pagination.next` | integer |  |
| `pagination.current` | integer |  |
| `pagination.next_url` | string |  |
| `pagination.per_page` | integer |  |
| `pagination.total_count` | integer |  |
| `pagination.total_pages` | integer |  |
| `pagination.has_next_page` | boolean |  |

## Code examples in other languages

Ready-to-run examples live in the [`examples/`](examples) folder. Each one reads your key from the `PILOTERR_API_KEY` environment variable.

| Language | Ad | Search |
|---|---|---|
| cURL (Bash) | [`ad`](examples/curl/ad.sh) | [`search`](examples/curl/search.sh) |
| PHP | [`ad`](examples/php/ad.php) | [`search`](examples/php/search.php) |
| C# | [`ad`](examples/csharp/Ad.cs) | [`search`](examples/csharp/Search.cs) |
| Go | [`ad`](examples/go/ad.go) | [`search`](examples/go/search.go) |
| Java | [`ad`](examples/java/AdExample.java) | [`search`](examples/java/SearchExample.java) |
| Ruby | [`ad`](examples/ruby/ad.rb) | [`search`](examples/ruby/search.rb) |
| Node.js | [`ad`](examples/nodejs/ad.mjs) | [`search`](examples/nodejs/search.mjs) |

## Practical use cases

- **Listing monitoring** — Get alerted when new ads matching your criteria are published.
- **Price benchmarks** — Compute market prices per model, category or location.
- **Sourcing** — Find stock, vehicles, parts or equipment faster than manual browsing.
- **Market analytics** — Measure supply, turnover and pricing trends over time.
- **Data products** — Feed valuation models and dashboards with structured listings.

## Why Piloterr?

- **No infrastructure** — no proxies, headless browsers or CAPTCHA solving to run yourself.
- **Structured JSON** — stable, documented fields instead of brittle HTML selectors.
- **Pay per request** — transparent credit cost per endpoint, failed requests are retried for you.
- **One API key, hundreds of sources** — Autotrader plus many other e-commerce, search and company data endpoints in the [Piloterr library](https://www.piloterr.com/library).
- **Any language** — plain HTTPS + JSON, with examples for Python, TypeScript, cURL, PHP, C#, Go, Java, Ruby and Node.js.

## FAQ

### Is it legal to scrape Autotrader?

Collecting publicly available data is generally allowed in many jurisdictions, but rules depend on your country, the data you collect and how you use it. Avoid personal data unless you have a lawful basis, respect the website's terms where they apply, and get legal advice for your specific use case. This is not legal advice.

### Do I need proxies or a headless browser?

No. Piloterr handles rendering, proxy rotation and retries on its side. You only send an HTTPS request with your `x-api-key` header and receive JSON.

### How much does a request cost?

Credits per call: `/v2/autotrader/ad` **2**, `/v2/autotrader/search` **2**. See the [Piloterr website](https://www.piloterr.com) for plans.

### What data does the Autotrader API return?

Each endpoint returns structured JSON: **Autotrader Ad** — `id`, `url`, `image`, `price`, `title`, `images`; **Autotrader Search** — `results[]`, `results[].id`, `results[].url`, `results[].year`, `results[].image`, `results[].price`.

### Which languages are supported?

Any language that can make an HTTP request. This README shows Python and TypeScript; the [`examples/`](examples) folder contains cURL, PHP, C#, Go, Java, Ruby and Node.js.

## Related scrapers

- [AutoScout24 Scraper API](https://github.com/piloterr/autoscout24-scraper)
- [Copart Scraper API](https://github.com/piloterr/copart-scraper)
- [Kijiji Scraper API](https://github.com/piloterr/kijiji-scraper)
- [Leboncoin Scraper API](https://github.com/piloterr/leboncoin-scraper)
- [Mascus Scraper API](https://github.com/piloterr/mascus-scraper)
- [mobile.de Scraper API](https://github.com/piloterr/mobile-de-scraper)
- [All Piloterr scrapers on GitHub](https://github.com/piloterr)

## Support

- 💬 Join the [Piloterr Discord](https://discord.gg/CFj3ph8aHU) to ask questions and share what you build.
- 📚 Browse the [API reference (OpenAPI)](https://app.piloterr.com/openapi) and the [Piloterr library](https://www.piloterr.com/library).
- 🔑 [Get your API key](https://app.piloterr.com).

---

<p align="center">
  <a href="https://www.piloterr.com">
    <picture>
      <source media="(prefers-color-scheme: dark)" srcset="images/logo-dark.svg">
      <img src="images/logo.svg" alt="Piloterr" height="32">
    </picture>
  </a>
  <br>
  <sub>Built by <a href="https://www.piloterr.com">Piloterr</a> — web scraping APIs for e-commerce, search, real estate and more, one API key.</sub>
</p>

<sub>Autotrader is a trademark of its respective owner. This repository is not affiliated with or endorsed by Autotrader. Examples are released under the MIT license.</sub>
