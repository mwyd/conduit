import { SummaryItemHistory } from "../../types/items";
import { Paginator } from "../../types/pagination";
import Pagination from "../pagination/pagination";
import Table from "./table";
import NoData from "../common/no-data";

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