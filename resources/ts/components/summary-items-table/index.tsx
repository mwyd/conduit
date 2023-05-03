import { SummaryItem } from "../../types/items";
import { Paginator } from "../../types/pagination";
import Pagination from "../pagination/pagination";
import Table from "./table";

interface Props {
  paginator: Paginator<SummaryItem>;
}

export default function SummaryItemsTable({ paginator }: Props) {
  return (
    <div>
      <Table items={paginator.data} />
      <div className="mt-4">
        <Pagination links={paginator.links} />
      </div>
    </div>
  );
}