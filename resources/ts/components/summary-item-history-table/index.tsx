import { SummaryItemHistory } from "@/types/items";
import { Paginator } from "@/types/pagination";
import Column from "@/types/table";
import Pagination from "@/components/pagination/pagination";
import NoData from "@/components/common/no-data";
import SortableTable from "@/components/common/sortable-table";
import Row from "@/components/summary-item-history-table/row";

const columns: Column<SummaryItemHistory>[] = [
  {
    name: '#',
    accessor: 'position',
    className: 'w-12 pr-2'
  },
  {
    name: 'Transaction',
    accessor: 'transactionId',
    className: 'px-2'
  },
  {
    name: 'Discount',
    accessor: 'discount',
    className: 'w-28 px-2'
  },
  {
    name: 'Price',
    accessor: 'price',
    className: 'w-28 px-2'
  },
  {
    name: 'Date',
    accessor: 'date',
    className: 'w-28 pl-2'
  }
];

interface Props {
  paginator: Paginator<SummaryItemHistory>;
}

export default function SummaryItemHistoryTable({ paginator }: Props) {
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