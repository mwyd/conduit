import { ThemeColor, ThemeMode } from "../types/theme";
import { PaginatorLink } from "../types/pagination";

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

    if (activeIndex - 1 == 0) {
      sm = sm.slice(activeIndex, activeIndex + 3);
    } else if (activeIndex + 1 == sm.length - 1) {
      sm = sm.slice(activeIndex - 2, activeIndex + 1);
    } else {
      sm = sm.slice(activeIndex - 1, activeIndex + 2);
    }

    sm = [first, ...sm, last];
  }

  return [sm, links];
}

export function getLocale(fallback: string): string {
  return document.querySelector('html')?.getAttribute('lang') ?? fallback;
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