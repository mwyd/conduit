import TableHead from "@/components/summary-items-table/table-head";
import TableBody from "@/components/summary-items-table/table-body";
import useTableSorter from "@/hooks/use-table-sorter";
import { SummaryItem } from "@/types/items";

interface Props {
  items: SummaryItem[];
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