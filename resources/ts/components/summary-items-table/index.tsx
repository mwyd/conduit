import { SummaryItem } from "../../types/items";
import { Paginator } from "../../types/pagination";
import Pagination from "../pagination/pagination";
import useTableSorter from "../../hooks/use-table-sorter";
import NoData from "../common/no-data";
import TableBody from "./table-body";
import TableHead from "./table-head";

interface Props {
  paginator: Paginator<SummaryItem>;
}

export default function SummaryItemsTable({ paginator: { data, links } }: Props) {
  if (data.length == 0) {
    return <NoData />;
  }

  const { sortedField, sortedAscending, sortedItems, sortByField } = useTableSorter(data);

  return (
    <div>
      <div className="xl:overflow-x-clip overflow-x-auto">
        <table className="w-full min-w-max border-collapse relative text-sm dark:text-gray-400">
          <TableHead
            sortedField={sortedField}
            sortedAscending={sortedAscending}
            sortByField={sortByField}
          />
          <TableBody items={sortedItems} />
        </table>
      </div>
      <div className="mt-4">
        <Pagination links={links} />
      </div>
    </div>
  );
}