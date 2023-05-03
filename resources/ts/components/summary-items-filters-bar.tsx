import { VscCircleSlash, VscFilter, VscFilterFilled, VscSearch } from "react-icons/vsc";
import { debounce, isEmpty } from "lodash";
import Input from "./common/input";
import Button from "./common/button";
import { FormEvent, useRef, useState } from "react";
import Modal from "./common/modal";
import RangeFilter from "./filters/range-filter";
import ExteriorFilter from "./filters/exterior-filter";
import FilterWrapper from "./filters/filter-wrapper";
import { objectDifference, time } from "../utils";
import { SummaryItemFilters } from "../types/items";
import { FormDataConvertable } from "../types/form";
import { router } from "@inertiajs/react";
import dateFormat, { masks } from "dateformat";
import CheckboxFilter from "./filters/checkbox-filter";

function filterSummaryItems(filters: Record<string, FormDataConvertable>) {
  router.get('/', filters, {
    only: ['paginator'],
    preserveState: true,
    preserveScroll: true,
    replace: true
  });
}

const debouncedFilterSummaryItems = debounce(filterSummaryItems, 700);

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

  const updateFilter = (key: keyof SummaryItemFilters, value: SummaryItemFilters[keyof SummaryItemFilters]) => {
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
    updateFilter('search', value);

    setChangedFilters({ ...filters, search: value });

    debouncedFilterSummaryItems(changedFilters.current);
  }

  const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
    e.preventDefault();

    setIsModalOpen(false);

    setChangedFilters(filters);

    filterSummaryItems(changedFilters.current);
  }

  const clearFilters = () => {
    setFilters(defaultFilters);
  }

  return (
    <div className="text-sm flex gap-2 h-8">
      <div className="relative flex-1">
        <VscSearch className="absolute top-2.5 left-3" />
        <Input
          className="w-full h-full pl-8"
          type="search"
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
        {isEmpty(changedFilters.current) ? <VscFilter className="mx-auto" /> : <VscFilterFilled className="mx-auto" />}
      </Button>
      <Modal
        title="Filters"
        isOpen={isModalOpen}
        handleClose={handleModalClose}
      >
        <form onSubmit={handleSubmit}>
          <RangeFilter
            title="Price"
            type="number"
            from={filters.price_from}
            to={filters.price_to}
            min="0"
            onFromChange={value => updateFilter('price_from', value)}
            onToChange={value => updateFilter('price_to', value)}
            required
          />
          <div className="mt-4">
            <RangeFilter
              title="Quantity"
              type="number"
              from={filters.quantity_from}
              to={filters.quantity_to}
              min="0"
              onFromChange={value => updateFilter('quantity_from', value)}
              onToChange={value => updateFilter('quantity_to', value)}
              required
            />
          </div>
          <div className="mt-4">
            <RangeFilter
              title="Date"
              type="date"
              from={filters.date_start}
              to={filters.date_end}
              min={dateStart}
              onFromChange={value => updateFilter('date_start', value)}
              onToChange={value => updateFilter('date_end', value)}
              required
            />
          </div>
          <div className="mt-4">
            <ExteriorFilter
              value={filters.exteriors}
              onChange={value => updateFilter('exteriors', value)}
            />
          </div>
          <div className="mt-4">
            <FilterWrapper title="Other">
              <div className="my-1">
                <CheckboxFilter
                  label="StatTrak™"
                  value={filters.is_stattrak == '1'}
                  onChange={() => updateFilter('is_stattrak', filters.is_stattrak == '0' ? '1' : '0')}
                />
              </div>
            </FilterWrapper>
          </div>
          <div className="mt-4">
            <div className="flex gap-2 h-8 text-sm">
              <Button
                className="w-full flex-1"
                type="submit"
              >
                Apply
              </Button>
              <Button
                className="basis-8"
                title="Clear"
                onClick={clearFilters}
              >
                <VscCircleSlash className="mx-auto" />
              </Button>
            </div>
          </div>
        </form>
      </Modal>
    </div>
  );
}