import RangeFilter from "../filters/range-filter";
import ExteriorFilter from "../filters/exterior-filter";
import FilterWrapper from "../filters/filter-wrapper";
import CheckboxFilter from "../filters/checkbox-filter";
import Button from "../common/button";
import { VscCircleSlash } from "react-icons/vsc";
import { SummaryItemFilters } from "../../types/items";
import { FormEvent } from "react";

interface Props {
  dateStart: string;
  filters: SummaryItemFilters;
  onFilterChange: (key: keyof SummaryItemFilters, value: SummaryItemFilters[keyof SummaryItemFilters]) => void;
  onSubmit: (e: FormEvent<HTMLFormElement>) => void;
  onClear: () => void;
}

export default function SummaryItemsFiltersForm({ dateStart, filters, onFilterChange, onSubmit, onClear }: Props) {
  return (
    <form onSubmit={onSubmit}>
      <RangeFilter
        title="Price"
        type="number"
        from={filters.price_from}
        to={filters.price_to}
        min="0"
        onFromChange={value => onFilterChange('price_from', value)}
        onToChange={value => onFilterChange('price_to', value)}
        required
      />
      <div className="mt-4">
        <RangeFilter
          title="Quantity"
          type="number"
          from={filters.quantity_from}
          to={filters.quantity_to}
          min="0"
          onFromChange={value => onFilterChange('quantity_from', value)}
          onToChange={value => onFilterChange('quantity_to', value)}
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
          onFromChange={value => onFilterChange('date_start', value)}
          onToChange={value => onFilterChange('date_end', value)}
          required
        />
      </div>
      <div className="mt-4">
        <ExteriorFilter
          value={filters.exteriors}
          onChange={value => onFilterChange('exteriors', value)}
        />
      </div>
      <div className="mt-4">
        <FilterWrapper title="Other">
          <div className="my-1">
            <CheckboxFilter
              label="StatTrak™"
              value={filters.is_stattrak == '1'}
              onChange={() => onFilterChange('is_stattrak', filters.is_stattrak == '0' ? '1' : '0')}
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
            onClick={onClear}
          >
            <VscCircleSlash className="mx-auto" />
          </Button>
        </div>
      </div>
    </form>
  );
}