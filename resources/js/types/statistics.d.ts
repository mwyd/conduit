export interface MarketStatistic {
  value: number;
  difference: number;
}

export interface MarketStatistics {
  count: MarketStatistic;
  sum: MarketStatistic;
  discount: MarketStatistic;
  star: MarketStatistic;
}