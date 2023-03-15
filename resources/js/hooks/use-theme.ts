import { useSyncExternalStore } from "react";
import { Theme, ThemeMode, ThemeIcon, ThemeListener } from "../types/theme";
import { detectThemeColor, loadThemeMode } from "../utils";

const themeCases: Record<ThemeMode, ThemeIcon> = {
  'light': "☀️",
  'dark': "🌙",
  'auto': "🌓"
}

let theme: Theme = {
  mode: 'auto',
  color: 'light',
  icon: '🌓'
}

let listeners: ThemeListener[] = [];

window.addEventListener('DOMContentLoaded', () => {
  updateTheme(loadThemeMode());
});

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
  if (localStorage.getItem('theme') !== 'auto') {
    return;
  }

  updateTheme('auto');
});

export default function useTheme() {
  return useSyncExternalStore(subscribe, getSnapshot);
}

export function toggleTheme() {
  const modes = Object.keys(themeCases) as ThemeMode[];

  const index = modes.indexOf(theme.mode);

  const nextMode = modes[index >= modes.length - 1 ? 0 : index + 1];

  updateTheme(nextMode);
}

function updateTheme(mode: ThemeMode) {
  theme = {
    mode,
    color: mode === 'auto' ? detectThemeColor() : mode,
    icon: themeCases[mode]
  }

  if (theme.color === 'dark') {
    document.documentElement.classList.add('dark');
  } else {
    document.documentElement.classList.remove('dark');
  }

  localStorage.setItem('theme', mode);

  emitChange();
}

function subscribe(listener: ThemeListener) {
  listeners = [...listeners, listener];

  return () => {
    listeners = listeners.filter(l => l !== listener);
  }
}

function getSnapshot() {
  return theme;
}

function emitChange() {
  for (const listener of listeners) {
    listener();
  }
}