import { SummaryItemHistory } from "@/types/items";
import { Paginator } from "@/types/pagination";
import Pagination from "@/components/pagination/pagination";
import Table from "@/components/summary-item-history-table/table";
import NoData from "@/components/common/no-data";

interface Props {
  paginator: Paginator<SummaryItemHistory>;
}

export default function SummaryItemsTable({ paginator }: Props) {
  if (paginator.data.length == 0) {
    return <NoData />;
  }

  return (
    <div>
      <Table items={paginator.data} />
      <div className="mt-4">
        <Pagination links={paginator.links} />
      </div>
    </div>
  );
}