import { SummaryItemHistory } from "@/types/items";
import Percentage from "@/components/intl/percentage";
import Price from "@/components/intl/price";

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
          ? <Price value={item.price} />
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