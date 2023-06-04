import { SummaryItem } from "@/types/items";
import { Paginator } from "@/types/pagination";
import Column from "@/types/table";
import Pagination from "@/components/pagination/pagination";
import NoData from "@/components/common/no-data";
import SortableTable from "@/components/common/sortable-table";
import Row from "@/components/summary-items/table-row";

const columns: Column<SummaryItem>[] = [
  {
    name: '#',
    accessor: 'position',
    className: 'w-12 pr-2'
  },
  {
    name: 'Item',
    accessor: 'name',
    className: 'px-2'
  },
  {
    name: 'Discount',
    accessor: 'discount',
    className: 'w-29 px-2'
  },
  {
    name: 'Price',
    accessor: 'price',
    className: 'w-29 px-2'
  },
  {
    name: 'Buff price',
    accessor: 'buffPrice',
    className: 'w-29 px-2'
  },
  {
    name: 'Steam price',
    accessor: 'steamPrice',
    className: 'w-29 px-2'
  },
  {
    name: 'Sold',
    accessor: 'sold',
    className: 'w-16 px-2'
  },
  {
    name: 'Last 7 days',
    accessor: 'sparkline',
    className: 'w-[128px] pl-2'
  }
];

interface Props {
  paginator: Paginator<SummaryItem>;
}

export default function SummaryItemsTable({ paginator }: Props) {
  if (paginator.data.length == 0) {
    return <NoData />;
  }

  return (
    <div>
      <SortableTable
        columns={columns}
        items={paginator.data}
        renderItem={item => <Row item={item} />}
      />
      <div className="mt-4">
        <Pagination links={paginator.links} />
      </div>
    </div>
  );
}