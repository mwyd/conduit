import { usePage } from "@inertiajs/react";
import useCurrency, { updateCurrency } from "../hooks/use-currency";

export default function CurrencySelect() {
  const { props: { currencies } } = usePage() as { props: { currencies: Record<string, number> } };

  const { iso } = useCurrency();

  const handleChange = (key: string) => {
    updateCurrency({ iso: key, ratio: currencies[key] });
  }

  return (
    <select
      className="dark:bg-neutral-900 bg-white text-xs font-semibold"
      value={iso}
      onChange={e => handleChange(e.target.value)}
    >
      {Object.keys(currencies).map(key =>
        <option
          key={key}
          value={key}
        >
          {key}
        </option>
      )}
    </select>
  );
}