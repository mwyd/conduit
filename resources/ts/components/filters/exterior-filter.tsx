import FilterWrapper from "@/components/filters/filter-wrapper";
import CheckboxFilter from "@/components/filters/checkbox-filter";
import { Exterior } from "@/types/items";

const exteriors: Record<Exterior, string> = {
  FN: 'Factory New',
  MW: 'Minimal Wear',
  FT: 'Field-Tested',
  WW: 'Well-Worn',
  BS: 'Battle-Scarred',
  Foil: 'Foil',
  Holo: 'Holo',
  Gold: 'Gold',
  Blue: 'Blue',
  Red: 'Red',
  Glitter: 'Glitter'
}

interface Props {
  value: string[];
  onChange: (value: string[]) => void;
}

export default function ExteriorFilter({ value, onChange }: Props) {
  const isChecked = (key: string) => {
    return value.includes(key);
  }

  const handleChange = (key: string) => {
    const nextSelected = isChecked(key)
      ? value.filter(e => e != key)
      : [...value, key];

    onChange(nextSelected);
  }

  return (
    <FilterWrapper title="Exterior">
      <div>
        {Object.keys(exteriors).map(key =>
          <div
            className="my-1"
            key={key}
          >
            <CheckboxFilter
              label={exteriors[key as Exterior]}
              value={isChecked(key)}
              onChange={() => handleChange(key)}
            />
          </div>
        )}
      </div>
    </FilterWrapper>
  );
}