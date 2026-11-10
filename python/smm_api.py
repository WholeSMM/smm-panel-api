"""Client for the standard SMM panel API (v2). https://wholesmm.com/docs/api"""
import requests


class SmmApi:
    def __init__(self, url: str, key: str, timeout: int = 30):
        self.url, self.key, self.timeout = url, key, timeout

    def call(self, action: str, **fields):
        r = requests.post(self.url, data={"key": self.key, "action": action, **fields}, timeout=self.timeout)
        try:
            return r.json()
        except ValueError:
            return {"error": "Invalid JSON answer"}

    def services(self):
        return self.call("services")

    def add(self, service: int, link: str, quantity: int, **extra):
        return self.call("add", service=service, link=link, quantity=quantity, **extra)

    def status(self, order: int):
        return self.call("status", order=order)

    def multi_status(self, orders):
        return self.call("status", orders=",".join(map(str, orders)))

    def refill(self, order: int):
        return self.call("refill", order=order)

    def refill_status(self, refill: str):
        return self.call("refill_status", refill=refill)

    def cancel(self, orders):
        return self.call("cancel", orders=",".join(map(str, orders)))

    def balance(self):
        return self.call("balance")
