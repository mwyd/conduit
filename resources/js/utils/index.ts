import { ThemeColor, ThemeMode } from "../types/theme";
import { PaginatorLink } from "../types/pagination";

export function formatNumber(value: number, precision: number = 2): string {
  return value.toFixed(precision);
}

export function normalizePaginatorLinks(links: PaginatorLink[]): [PaginatorLink[], PaginatorLink[]] {
  if (links.length < 1) {
    return [links, links];
  }

  const md = [...links];

  md[0] = {
    ...links[0],
    label: '«'
  }

  md[md.length - 1] = {
    ...links[links.length - 1],
    label: '»'
  }

  let sm = [...md];

  if (sm.length > 5) {
    sm = sm.filter(link => link.label != '...');

    const activeIndex = sm.findIndex(link => link.active);

    const first = sm[0];
    const last = sm[sm.length - 1];

    let left = sm[activeIndex - 1];
    let right = sm[activeIndex + 1];

    if (left == first) {
      sm = [first, sm[activeIndex], right, sm[activeIndex + 2], last];
    } else if (right == last) {
      sm = [first, sm[activeIndex - 2], left, sm[activeIndex], last];
    } else {
      sm = [first, left, sm[activeIndex], right, last];
    }
  }

  return [sm, md];
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