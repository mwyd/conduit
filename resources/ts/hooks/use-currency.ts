import { useSyncExternalStore } from "react";
import { Currency, CurrencyListener } from "../types/currency";

let currency = loadCurrency();

let listeners: CurrencyListener[] = [];

export default function useCurrency() {
  return useSyncExternalStore(subscribe, getSnapshot);
}

export function updateCurrency(nextCurrency: Currency) {
  currency = nextCurrency;

  localStorage.setItem('currency', JSON.stringify(nextCurrency));

  emitChange();
}

function subscribe(listener: CurrencyListener) {
  listeners = [...listeners, listener];

  return () => {
    listeners = listeners.filter(l => l !== listener);
  }
}

function getSnapshot() {
  return currency;
}

function emitChange() {
  for (const listener of listeners) {
    listener();
  }
}

function loadCurrency(): Currency {
  const currency = localStorage.getItem('currency');

  if (currency == null) {
    return { iso: 'USD', ratio: 1 }
  }

  return JSON.parse(currency) as Currency;
}