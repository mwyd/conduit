import TableHead from "./table-head";
import TableBody from "./table-body";
import useTableSorter from "../../hooks/use-table-sorter";
import { SummaryItemHistory } from "../../types/items";

interface Props {
  items: SummaryItemHistory[];
}

export default function Table({ items }: Props) {
  const { sortedField, sortedAscending, sortedItems, sortByField } = useTableSorter(items);

  return (
    <div className="xl:overflow-x-clip overflow-x-auto mt-4">
      <table className="w-full min-w-max border-collapse relative text-sm dark:text-gray-400">
        <TableHead
          sortedField={sortedField}
          sortedAscending={sortedAscending}
          sortByField={sortByField}
        />
        <TableBody items={sortedItems} />
      </table>
    </div>
  );
}