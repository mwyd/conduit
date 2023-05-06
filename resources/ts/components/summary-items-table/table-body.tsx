import Image from "@/components/common/image";
import CompactItemName from "@/components/compact-item-name";
import Anchor from "@/components/common/anchor";
import Percentage from "@/components/intl/percentage";
import Price from "@/components/intl/price";
import { SummaryItem } from "@/types/items";
import { FormattedNumber } from "react-intl";
import classNames from "classnames";
import { Link } from "@inertiajs/react";

const profitablePriceClass = (isProfitable : boolean) => classNames([
  isProfitable ? 'text-green-450' : 'text-red-450'
]);

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
            <Link
              className="inline-block"
              href={`/${item.hashName}`}
            >
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
            </Link>
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
            {item.buffPrice
              ? (
                <Anchor
                  className={profitablePriceClass(item.buffPrice / item.price < 0.8)}
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
            <Anchor
              className={profitablePriceClass(item.steamPrice < item.price)}
              href={`https://steamcommunity.com/market/listings/730/${item.hashName}`}
              title="steam-market"
              target="_blank"
            >
              <Price value={item.steamPrice} />
            </Anchor>
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