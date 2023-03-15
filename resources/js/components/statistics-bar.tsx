import { MarketStatistics } from "../types/statistics";
import Statistic from "./statistic";
import UnitValue from "./unit-value";

interface Props {
  statistics: MarketStatistics;
}

export default function StatisticsBar({ statistics: { count, sum, discount, star } }: Props) {
  return (
    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
      <Statistic
        difference={count.difference}
        title="Sold items"
      >
        {count.value}
      </Statistic>
      <Statistic
        difference={sum.difference}
        title="Sold value"
      >
        <UnitValue
          value={sum.value}
          unit="$"
        />
      </Statistic>
      <Statistic
        difference={discount.difference}
        title="Average discount"
      >
        <UnitValue
          value={discount.value}
          unit="%"
        />
      </Statistic>
      <Statistic
        difference={star.difference}
        title="Star items"
      >
        {star.value}
      </Statistic>
    </div>
  );
}