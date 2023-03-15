import { SummaryItem } from "../types/items";
import React from "react";
import Image from "./image";
import CompactItemName from "./compact-item-name";
import Column from "../types/table";
import { Paginator } from "../types/pagination";
import Pagination from "./pagination";
import Anchor from "./anchor";
import UnitValue from "./unit-value";
import useTableSorter from "../hooks/use-table-sorter";
import classNames from "classnames";

const sortButtonClass = (isSelected: boolean, isAscending: boolean) => classNames([
  'w-full',
  'text-left',
  isSelected ? `after:ml-1 ${isAscending ? "after:content-['🠡']" : "after:content-['🠣']"}` : ''
]);

const columns: Column<SummaryItem>[] = [
  {
    name: '#',
    accessor: 'position'
  },
  {
    name: 'Item',
    accessor: 'name'
  },
  {
    name: 'Discount',
    accessor: 'discount'
  },
  {
    name: 'Price',
    accessor: 'price'
  },
  {
    name: 'Steam price',
    accessor: 'steamPrice'
  },
  {
    name: 'Buff price',
    accessor: 'buffPrice'
  },
  {
    name: 'Sold',
    accessor: 'sold'
  },
  {
    name: 'Last 7 days',
    accessor: 'sparkline'
  }
];

interface Props {
  paginator: Paginator<SummaryItem>;
}

export default function SummaryItemsTable({ paginator: { data, links } }: Props) {
  const { sortedField, sortedAscending, sortedItems, sortByField } = useTableSorter(data);

  return (
    <div>
      <div className="xl:overflow-x-clip overflow-x-auto">
        <table className="w-full min-w-max border-collapse relative text-sm dark:text-gray-400">
          <thead className="sticky h-16 top-0 bg-white text-left dark:bg-neutral-900 z-10">
            <tr>
              {columns.map(column =>
                <th key={column.accessor}>
                  <button
                    className={sortButtonClass(sortedField === column.accessor, sortedAscending)}
                    type="button"
                    onClick={() => sortByField(column.accessor)}
                  >
                    {column.name}
                  </button>
                </th>
              )}
            </tr>
          </thead>
          <tbody>
          {sortedItems.map((item, i) =>
            <tr
              className="h-16 hover:bg-gray-50 dark:hover:bg-neutral-800 border-t border-gray-200 dark:border-neutral-700"
              key={i}
            >
              <td className="w-12">
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
              <td className="w-28">
                <UnitValue
                  value={item.discount}
                  unit="%"
                />
              </td>
              <td className="w-28">
                <Anchor
                  href={`https://shadowpay.com/en/csgo-items?search=${item.hashName}`}
                  title="shadowpay-market"
                  target="_blank"
                >
                  <UnitValue
                    value={item.price}
                    unit="$"
                  />
                </Anchor>
              </td>
              <td className="w-28">
                <Anchor
                  href={`https://steamcommunity.com/market/listings/730/${item.hashName}`}
                  title="steam-market"
                  target="_blank"
                >
                  <UnitValue
                    value={item.steamPrice}
                    unit="$"
                  />
                </Anchor>
              </td>
              <td className="w-28">
                {item.buffPrice
                  ? (
                    <Anchor
                      href={`https://buff.163.com/goods/${item.goodId}`}
                      title="buff-market"
                      target="_blank"
                    >
                      <UnitValue
                        value={item.buffPrice}
                        unit="$"
                      />
                    </Anchor>
                  )
                  : '-'
                }
              </td>
              <td className="w-16">
                {item.sold}
              </td>
              <td className="w-[120px]">
                <Image
                  src={`storage/sparkline/7d/${item.sparkline}.svg`}
                  alt="7d-sparkline"
                />
              </td>
            </tr>
          )}
          </tbody>
        </table>
      </div>
      <div className="mt-4">
        <Pagination links={links} />
      </div>
    </div>
  );
}