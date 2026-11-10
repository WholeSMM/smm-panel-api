# SMM Panel API clients (PHP, Python, Node.js)

Small, dependency-light clients for the **standard SMM panel API (v2)**: the API that SMM panels and providers use to list services, place orders and check their status.

They work with any panel that speaks the standard API, including every panel made with [WholeSMM](https://wholesmm.com) (a platform for launching and running your own SMM panel, under your own brand and on your own domain).

Full API reference: https://wholesmm.com/docs/api

## Actions

| action | fields | answer |
|---|---|---|
| `services` | none | list of services with rate per 1,000, min, max, refill, cancel |
| `add` | `service`, `link`, `quantity` (optional `runs`, `interval`, `comments`) | `{"order": 23501}` |
| `status` | `order`, or `orders=1,2,3` (up to 100) | `{"charge","start_count","status","remains","currency"}` |
| `refill` | `order` | `{"refill": "1"}` |
| `refill_status` | `refill`, or `refills=1,2` | `{"status": "Completed"}` |
| `cancel` | `orders=1,2,3` | `{"cancelled": [...], "failed": [...]}` |
| `balance` | none | `{"balance": "100.84", "currency": "USD"}` |

Every answer is HTTP 200 JSON; a problem comes back as `{"error": "..."}`. Status is one of `Pending`, `In progress`, `Completed`, `Partial`, `Canceled`.

## PHP

```php
require 'php/SmmApi.php';
$api = new SmmApi('https://YOUR-PANEL-DOMAIN/api/v2', 'YOUR_KEY');
$order = $api->add(1, 'https://instagram.com/example', 1000);
print_r($api->status($order['order']));
```

## Python

```python
from python.smm_api import SmmApi
api = SmmApi("https://YOUR-PANEL-DOMAIN/api/v2", "YOUR_KEY")
order = api.add(service=1, link="https://instagram.com/example", quantity=1000)
print(api.status(order["order"]))
```

## Node.js (18+)

```js
import { SmmApi } from './node/smm-api.mjs';
const api = new SmmApi('https://YOUR-PANEL-DOMAIN/api/v2', 'YOUR_KEY');
const { order } = await api.add({ service: 1, link: 'https://instagram.com/example', quantity: 1000 });
console.log(await api.status(order));
```

## Start your own SMM panel

Want your own panel instead of only using one? [WholeSMM](https://wholesmm.com) runs it for you: your brand and domain, payments, providers and automatic orders built in. Prices: https://wholesmm.com/pricing · Compare platforms: https://wholesmm.com/compare

## License

MIT
