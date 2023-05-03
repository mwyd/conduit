import Input from "../common/input";
import FilterWrapper from "./filter-wrapper";

interface Props {
  title: string;
  type: string;
  from: string;
  to: string;
  onFromChange: (value: string) => void;
  onToChange: (value: string) => void;
  required: boolean;
  min?: string;
  max?: string;
}

export default function RangeFilter({ title, type, from, to, onFromChange, onToChange, required, min, max }: Props) {
  return (
    <FilterWrapper title={title}>
      <div className="flex gap-2 h-8">
        <Input
          className="w-full px-2"
          type={type}
          required={required}
          min={min}
          max={to}
          value={from}
          onChange={e => onFromChange(e.target.value)}
        />
        <Input
          className="w-full px-2"
          type={type}
          required={required}
          min={from}
          max={max}
          value={to}
          onChange={e => onToChange(e.target.value)}
        />
      </div>
    </FilterWrapper>
  );
}