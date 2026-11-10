// Client for the standard SMM panel API (v2). Node.js 18+. https://wholesmm.com/docs/api
export class SmmApi {
  constructor(url, key) { this.url = url; this.key = key; }

  async call(action, fields = {}) {
    const r = await fetch(this.url, { method: 'POST', body: new URLSearchParams({ key: this.key, action, ...fields }) });
    try { return await r.json(); } catch { return { error: 'Invalid JSON answer' }; }
  }

  services() { return this.call('services'); }
  add({ service, link, quantity, ...extra }) { return this.call('add', { service, link, quantity, ...extra }); }
  status(order) { return this.call('status', { order }); }
  multiStatus(orders) { return this.call('status', { orders: orders.join(',') }); }
  refill(order) { return this.call('refill', { order }); }
  refillStatus(refill) { return this.call('refill_status', { refill }); }
  cancel(orders) { return this.call('cancel', { orders: orders.join(',') }); }
  balance() { return this.call('balance'); }
}
