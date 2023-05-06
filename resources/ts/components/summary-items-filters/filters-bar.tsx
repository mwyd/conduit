import { VscFilter, VscFilterFilled, VscSearch } from "react-icons/vsc";
import { debounce, isEmpty } from "lodash";
import Input from "../common/input";
import Button from "../common/button";
import { FormEvent, useRef, useState } from "react";
import Modal from "../common/modal";
import { objectDifference, time } from "../../utils";
import { SummaryItemFilters } from "../../types/items";
import { FormDataConvertable } from "../../types/form";
import { router } from "@inertiajs/react";
import dateFormat, { masks } from "dateformat";
import SummaryItemsFiltersForm from "./filters-form";

function filterSummaryItems(filters: Record<string, FormDataConvertable>) {
  router.get('/', filters, {
    only: ['paginator'],
    preserveState: true,
    preserveScroll: true,
    replace: true
  });
}

const debouncedFilterSummaryItems = debounce(filterSummaryItems, 700);

function getFilterIcon(isEmpty: boolean) {
  const Icon = isEmpty ? VscFilter : VscFilterFilled;

  return <Icon className="mx-auto" />;
}

const dateStart = dateFormat(Date.now() - time.day * 8, masks.isoDate);
const dateEnd = dateFormat(Date.now() + time.day, masks.isoDate);

const defaultFilters: SummaryItemFilters = {
  search: '',
  price_from: '0',
  price_to: '1000000',
  quantity_from: '0',
  quantity_to: '1000000',
  date_start: dateStart,
  date_end: dateEnd,
  exteriors: [],
  is_stattrak: '0'
}

interface Props {
  initialFilters: Partial<SummaryItemFilters>;
}

export default function SummaryItemsFiltersBar({ initialFilters }: Props) {
  const [filters, setFilters] = useState<SummaryItemFilters>({ ...defaultFilters, ...initialFilters });

  const [isModalOpen, setIsModalOpen] = useState(false);

  const previousFilters = useRef(filters);

  const changedFilters = useRef(initialFilters);

  const handleModalOpen = () => {
    previousFilters.current = filters;

    setIsModalOpen(true);
  }

  const handleModalClose = () => {
    setFilters(previousFilters.current);

    setIsModalOpen(false);
  }

  const handleFilterChange = (key: keyof SummaryItemFilters, value: SummaryItemFilters[keyof SummaryItemFilters]) => {
    const nextFilters = {
      ...filters,
      [key]: value
    }

    setFilters(nextFilters);
  }

  const setChangedFilters = (filters: SummaryItemFilters) => {
    changedFilters.current = objectDifference(filters, defaultFilters);
  }

  const handleSearchChange = (value: string) => {
    handleFilterChange('search', value);

    setChangedFilters({ ...filters, search: value });

    debouncedFilterSummaryItems(changedFilters.current);
  }

  const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
    e.preventDefault();

    setIsModalOpen(false);

    setChangedFilters(filters);

    filterSummaryItems(changedFilters.current);
  }

  const handleClear = () => {
    setFilters(defaultFilters);
  }

  return (
    <div className="text-sm flex gap-2 h-8">
      <div className="relative flex-1">
        <VscSearch className="absolute top-2.5 left-3" />
        <Input
          className="w-full h-full pl-8"
          placeholder="Search..."
          value={filters.search}
          onChange={e => handleSearchChange(e.target.value)}
        />
      </div>
      <Button
        className="basis-8"
        title="Filters"
        onClick={handleModalOpen}
        variant="secondary"
      >
        {getFilterIcon(isEmpty(changedFilters.current))}
      </Button>
      <Modal
        title="Filters"
        isOpen={isModalOpen}
        handleClose={handleModalClose}
      >
        <SummaryItemsFiltersForm
          dateStart={dateStart}
          filters={filters}
          onFilterChange={handleFilterChange}
          onSubmit={handleSubmit}
          onClear={handleClear}
        />
      </Modal>
    </div>
  );
}