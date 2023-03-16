import { ThemeColor, ThemeMode } from "../types/theme";
import { PaginatorLink } from "../types/pagination";

export function formatNumber(value: number, precision: number = 2): string {
  return value.toFixed(precision);
}

export function scalePaginatorLinks(links: PaginatorLink[]): [PaginatorLink[], PaginatorLink[]] {
  if (links.length < 1) {
    return [links, links];
  }

  let sm = [...links];

  if (sm.length > 5) {
    sm = sm.filter(link => link.label != '...');

    let activeIndex = sm.findIndex(link => link.active);

    if (activeIndex == -1) {
      activeIndex = sm.length - 2;
    }

    const first = sm[0];
    const last = sm[sm.length - 1];

    let left = sm[activeIndex - 1];
    let right = sm[activeIndex + 1];

    if (left == first) {
      sm = [sm[activeIndex], right, sm[activeIndex + 2]];
    } else if (right == last) {
      sm = [sm[activeIndex - 2], left, sm[activeIndex]];
    } else {
      sm = [left, sm[activeIndex], right];
    }

    sm = [first, ...sm, last];
  }

  return [sm, links];
}

export function detectThemeColor(): ThemeColor {
  return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
}

export function loadThemeMode(): ThemeMode {
  let theme = localStorage.getItem('theme');

  if (theme === null) {
    theme = 'auto';
  }

  return theme as ThemeMode;
}