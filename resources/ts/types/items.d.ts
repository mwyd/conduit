export type Phase = 'Phase 1' | 'Phase 2' | 'Phase 3' | 'Phase 4' | 'Ruby' | 'Emerald' | 'Sapphire' | 'Black Pearl';

export type Exterior = 'FN' | 'MW' | 'FT' | 'BS' | 'WW' | 'Foil' | 'Holo' | 'Gold' | 'Blue' | 'Red' | 'Glitter';

export interface SummaryItem {
  position: number;
  hashName: string;
  name: string;
  icon: string;
  exterior: Exterior | null;
  phase: Phase | null;
  isStattrak: boolean;
  isSouvenir: boolean;
  discount: number;
  price: number;
  steamPrice: number;
  buffPrice: number | null;
  goodId: number | null;
  sold: number;
  sparkline: string;
}

export interface SummaryItemHistory {
  position: number,
  transactionId: string;
  discount: number;
  price: number | null;
  steamPrice: number | null;
  date: string;
  dateDifference: string;
}

export interface SummaryItemFilters {
  search: string;
  price_from: string;
  price_to: string;
  quantity_from: string;
  quantity_to: string;
  date_start: string;
  date_end: string;
  exteriors: string[];
  is_stattrak: string;
  is_souvenir: string;
}