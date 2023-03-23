import { useMemo, useRef, useState } from "react";

export default function useTableSorter<T extends Object>(items: T[]) {
  const [sortedField, setSortedField] = useState<keyof T>();

  const [sortedAscending, setSortedAscending] = useState(true);

  const lastClickedField = useRef<keyof T>();

  const sortedItems = useMemo(() => {
    if (!sortedField) {
      return [...items];
    }

    return [...items].sort((a, b) => {
      if (b[sortedField] == a[sortedField]) {
        return 0;
      }

      return (b[sortedField] < a[sortedField] ? 1 : -1) * (sortedAscending ? 1 : -1);
    });
  }, [items, sortedField, sortedAscending]);

  const sortByField = (field: keyof T) => {
    let ascending = sortedAscending;

    if (lastClickedField.current == field) {
      ascending = !ascending;
    }

    setSortedField(field);

    setSortedAscending(ascending);

    lastClickedField.current = field;
  }

  return {
    sortedField,
    sortedAscending,
    sortedItems,
    sortByField
  }
}