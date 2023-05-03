export type CurrencyListener = () => void;

export interface Currency {
  iso: string;
  ratio: number;
}