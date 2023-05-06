import Percentage from "../intl/percentage";
import Price from "../intl/price";
import { SummaryItemHistory } from "../../types/items";

interface Props {
  items: SummaryItemHistory[];
}

export default function TableBody({ items }: Props) {
  return (
    <tbody>
      {items.map((item, i) =>
        <tr
          className="h-16 hover:bg-gray-50 dark:hover:bg-neutral-800 border-t border-gray-200 dark:border-neutral-700"
          key={i}
        >
          <td>
            {item.position}
          </td>
          <td>
            {item.transactionId}
          </td>
          <td>
            <Percentage value={item.discount} />
          </td>
          <td>
            {item.price
              ? <Price value={item.price} />
              : '-'
            }
          </td>
          <td>
            <span
              className="cursor-help"
              title={item.date}
            >
              {item.dateDifference}
            </span>
          </td>
        </tr>
      )}
    </tbody>
  );
}