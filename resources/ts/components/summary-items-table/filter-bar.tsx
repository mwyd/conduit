import { VscSearch } from "react-icons/vsc";
import { debounce } from "lodash";
import { router } from "@inertiajs/react";

const searchItems = (search?: string) => {
  router.get('/', { search }, {
    only: ['paginator'],
    preserveState: true,
    replace: true
  });
}

export default function FilterBar() {
  const handleChange = debounce((value: string) => searchItems(value || undefined), 400);

  return (
    <div className="relative text-sm">
      <VscSearch className="absolute top-2 left-3" />
      <input
        className="w-full rounded-md bg-gray-50 dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 p-1 pl-8"
        placeholder="Search..."
        onChange={e => handleChange(e.target.value)}
      />
    </div>
  );
}