export type Phase = 'Phase 1' | 'Phase 2' | 'Phase 3' | 'Phase 4' | 'Ruby' | 'Emerald' | 'Sapphire' | 'Black Pearl';

export interface SummaryItem {
  position: number;
  hashName: string;
  name: string;
  icon: string;
  exterior: string | null;
  phase: Phase | null;
  isStattrak: boolean;
  discount: number;
  price: number;
  steamPrice: number;
  buffPrice: number | null;
  goodId: number | null;
  sold: number;
  sparkline: string;
}