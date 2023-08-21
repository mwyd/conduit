import { ReactNode } from "react";
import { VscTriangleDown, VscTriangleUp } from "react-icons/vsc";
import Column from "@/types/table";
import useTableSorter from "@/hooks/use-table-sorter";

function getSortIcon(isSelected: boolean, isAscending: boolean) {
  if (!isSelected) {
    return null;
  }

  const Icon = isAscending ? VscTriangleUp : VscTriangleDown;

  return <Icon className="inline-block" size={8} />;
}

interface Props<T extends object> {
  columns: Column<T>[];
  items: T[];
  renderItem: (item: T) => ReactNode;
}

export default function SortableTable<T extends object>({ columns, items, renderItem }: Props<T>) {
  const { sortedField, sortedAscending, sortedItems, sortByField } = useTableSorter(items);

  return (
    <div className="xl:overflow-x-clip overflow-x-auto">
      <table className="w-full min-w-max border-collapse relative text-sm dark:text-gray-400">
        <thead>
          <tr className="sticky h-12 top-0 bg-white text-left dark:bg-neutral-900 z-10">
            {columns.map((column, i) =>
              <th
                key={i}
                className={column.className}
              >
                <button
                  className="w-full flex items-center gap-1"
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
        <tbody>
          {sortedItems.map((item, i) =>
            <tr
              key={i}
              className="h-16 hover:bg-gray-50 dark:hover:bg-neutral-800 border-t border-gray-200 dark:border-neutral-700"
            >
              {renderItem(item)}
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
}