import Column from "../../types/table";
import { SummaryItem } from "../../types/items";
import useTableSorter from "../../hooks/use-table-sorter";
import { VscTriangleDown, VscTriangleUp } from "react-icons/all";

function getSortIcon(isSelected: boolean, isAscending: boolean) {
  if (!isSelected) {
    return null;
  }

  const Icon = isAscending ? VscTriangleUp : VscTriangleDown;

  return <Icon className="inline-block ml-1" size={8} />;
}

const columns: Column<SummaryItem>[] = [
  {
    name: '#',
    accessor: 'position',
    className: 'w-12'
  },
  {
    name: 'Item',
    accessor: 'name'
  },
  {
    name: 'Discount',
    accessor: 'discount',
    className: 'w-28'
  },
  {
    name: 'Price',
    accessor: 'price',
    className: 'w-28'
  },
  {
    name: 'Buff price',
    accessor: 'buffPrice',
    className: 'w-28'
  },
  {
    name: 'Steam price',
    accessor: 'steamPrice',
    className: 'w-28'
  },
  {
    name: 'Sold',
    accessor: 'sold',
    className: 'w-16'
  },
  {
    name: 'Last 7 days',
    accessor: 'sparkline',
    className: 'w-[120px]'
  }
];

type Props = Omit<ReturnType<typeof useTableSorter<SummaryItem>>, 'sortedItems'>;

export default function TableHead({ sortedField, sortedAscending, sortByField }: Props) {
  return (
    <thead className="sticky h-12 top-0 bg-white text-left dark:bg-neutral-900 z-10">
      <tr>
        {columns.map(column =>
          <th
            key={column.accessor}
            className={column.className}
          >
            <button
              className="w-full text-left"
              type="button"
              onClick={() => sortByField(column.accessor)}
            >
              <span>
                {column.name}
              </span>
              {getSortIcon(sortedField == column.accessor, sortedAscending)}
            </button>
          </th>
        )}
      </tr>
    </thead>
  );
}