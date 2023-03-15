export type ThemeMode = 'dark' | 'light' | 'auto';

export type ThemeColor = Omit<ThemeMode, 'auto'>;

export type ThemeIcon = '☀️' | '🌙' | '🌓';

export type ThemeListener = () => void;

export interface Theme {
  mode: ThemeMode;
  color: ThemeColor;
  icon: ThemeIcon;
}