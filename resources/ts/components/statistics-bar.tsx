import { MarketStatistics } from "@/types/statistics";
import Statistic from "@/components/statistic";
import Price from "@/components/intl/price";
import Percentage from "@/components/intl/percentage";
import { FormattedNumber } from "react-intl";

interface Props {
  statistics: MarketStatistics;
}

export default function StatisticsBar({ statistics: { count, sum, discount, star } }: Props) {
  return (
    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
      <Statistic
        difference={count.difference}
        title="Transactions"
      >
        <FormattedNumber value={count.value} />
      </Statistic>
      <Statistic
        difference={sum.difference}
        title="Transactions value"
      >
        <Price value={sum.value} />
      </Statistic>
      <Statistic
        difference={discount.difference}
        title="Average discount"
      >
        <Percentage value={discount.value} />
      </Statistic>
      <Statistic
        difference={star.difference}
        title="Star items"
      >
        <FormattedNumber value={star.value} />
      </Statistic>
    </div>
  );
}