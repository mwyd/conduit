import { SummaryItemHistory } from "@/types/items";
import Percentage from "@/components/intl/percentage";
import Price from "@/components/intl/price";
import classNames from "classnames";

const profitablePriceClass = (isProfitable: boolean) => classNames([
  isProfitable ? 'text-green-450' : 'text-red-450'
]);

interface Props {
  item: SummaryItemHistory;
}

export default function Row({ item }: Props) {
  return (
    <>
      <td className="pr-2">
        {item.position}
      </td>
      <td className="px-2">
        {item.transactionId}
      </td>
      <td className="px-2">
        <Percentage value={item.discount} />
      </td>
      <td className="px-2">
        {item.price
          ? (
            <span className={profitablePriceClass(item.steamPrice != null && item.steamPrice * 0.95 < item.price)}>
              <Price value={item.price} />
            </span>
          )
          : '-'
        }
      </td>
      <td className="px-2">
        {item.steamPrice
          ? <Price value={item.steamPrice} />
          : '-'
        }
      </td>
      <td className="pl-2">
        <span
          className="cursor-help"
          title={item.date}
        >
          {item.dateDifference}
        </span>
      </td>
    </>
  );
}