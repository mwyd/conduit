import { isEqual, reduce } from "lodash";

export const time = {
  day: 1000 * 60 * 60 * 24
}

export function getYScrollBarWidth(): number {
  return window.innerWidth - document.body.clientWidth;
}

export function objectDifference<T extends object>(source: T, target: T): Partial<T> {
  return reduce(source, (result, value, key) => {
    if (!isEqual(value, target[key as keyof T])) {
      result[key as keyof T] = value;
    }

    return result;
  }, {} as Partial<T>);
}

export function getLocale(fallback: string): string {
  return document.querySelector('html')?.getAttribute('lang') ?? fallback;
}