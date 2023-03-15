import { useRef, useState } from "react";

export default function useTableSorter<T extends Object>(items: T[]) {
  const [sortedField, setSortedField] = useState<keyof T>();

  const [sortedAscending, setSortedAscending] = useState(true);

  const [sortedItems, setSortedItems] = useState(items);

  const lastClickedField = useRef<keyof T>();

  const sortByField = (field: keyof T) => {
    let ascending = sortedAscending;

    if (lastClickedField.current == field) {
      ascending = !ascending;
    }

    const nextSortedItems = [...items].sort((a, b) => {
      if (b[field] == a[field]) {
        return 0;
      }

      const modifier = b[field] < a[field] ? 1 : -1;

      return modifier * (ascending ? 1 : -1);
    });

    setSortedField(field);

    setSortedAscending(ascending);

    setSortedItems(nextSortedItems);

    lastClickedField.current = field;
  }

  return {
    sortedField,
    sortedAscending,
    sortedItems,
    sortByField
  }
}