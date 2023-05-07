import { Link } from "@inertiajs/react";
import { FormattedNumber } from "react-intl";
import classNames from "classnames";
import { SummaryItem } from "@/types/items";
import Image from "@/components/common/image";
import CompactItemName from "@/components/compact-item-name";
import Percentage from "@/components/intl/percentage";
import Anchor from "@/components/common/anchor";
import Price from "@/components/intl/price";

const profitablePriceClass = (isProfitable: boolean) => classNames([
  isProfitable ? 'text-green-450' : 'text-red-450'
]);

interface Props {
  item: SummaryItem;
}

export default function Row({ item }: Props) {
  return (
    <>
      <td className="pr-2">
        {item.position}
      </td>
      <td className="px-2">
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
      <td className="px-2">
        <Percentage value={item.discount} />
      </td>
      <td className="px-2">
        <Anchor
          href={`https://shadowpay.com/en/csgo-items?search=${item.hashName}`}
          title="shadowpay-market"
          target="_blank"
        >
          <Price value={item.price} />
        </Anchor>
      </td>
      <td className="px-2">
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
      <td className="px-2">
        <Anchor
          className={profitablePriceClass(item.steamPrice * 0.95 < item.price)}
          href={`https://steamcommunity.com/market/listings/730/${item.hashName}`}
          title="steam-market"
          target="_blank"
        >
          <Price value={item.steamPrice} />
        </Anchor>
      </td>
      <td className="px-2">
        <FormattedNumber value={item.sold} />
      </td>
      <td className="pl-2">
        <Image
          src={`storage/sparkline/7d/${item.sparkline}.svg`}
          alt="7d-sparkline"
        />
      </td>
    </>
  );
}