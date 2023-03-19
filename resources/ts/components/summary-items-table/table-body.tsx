import Image from "../common/image";
import CompactItemName from "../compact-item-name";
import Percentage from "../intl/percentage";
import Anchor from "../common/anchor";
import Price from "../intl/price";
import { SummaryItem } from "../../types/items";
import { FormattedNumber } from "react-intl";

interface Props {
  items: SummaryItem[];
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
            <Image
              className="w-12 inline-block mr-2"
              src={`https://community.cloudflare.steamstatic.com/economy/image/${item.icon}`}
              alt="item-image"
            />
            <CompactItemName
              name={item.name}
              exterior={item.exterior}
              phase={item.phase}
              isStattrak={item.isStattrak}
            />
          </td>
          <td>
            <Percentage value={item.discount} />
          </td>
          <td>
            <Anchor
              href={`https://shadowpay.com/en/csgo-items?search=${item.hashName}`}
              title="shadowpay-market"
              target="_blank"
            >
              <Price value={item.price} />
            </Anchor>
          </td>
          <td>
            <Anchor
              href={`https://steamcommunity.com/market/listings/730/${item.hashName}`}
              title="steam-market"
              target="_blank"
            >
              <Price value={item.steamPrice} />
            </Anchor>
          </td>
          <td>
            {item.buffPrice
              ? (
                <Anchor
                  href={`https://buff.163.com/goods/${item.goodId}`}
                  title="buff-market"
                  target="_blank"
                >
                  <Price value={item.buffPrice} />
                </Anchor>
              )
              : '-'
            }
          </td>
          <td>
            <FormattedNumber value={item.sold} />
          </td>
          <td>
            <Image
              src={`storage/sparkline/7d/${item.sparkline}.svg`}
              alt="7d-sparkline"
            />
          </td>
        </tr>
      )}
    </tbody>
  );
}